<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use App\Http\Helpers\HtmlExtensions;
use App\Http\Helpers\SendEmail;
use App\Mail\DeletedContact;
use App\Mail\RegistredContact;
use App\Mail\UpdatedContact;

class ContactsController extends Controller
{
    public function index()
    {
        return view('contacts.list');
    }

    public function list()
    {
        $contacts = Contact::with(['email', 'phone'])->where('user_id', '=', auth()->id());
        return DataTables()->of($contacts)->toJson();
    }

    public function create()
    {
        $typesEmail = HtmlExtensions::selectEmail('email', 'email[]', '');
        $typesPhone = HtmlExtensions::selectPhone('phone', 'phone[]', '');

        return view('contacts.create', ['typesEmail' => $typesEmail, 'typesPhone' => $typesPhone]);
    }

    public function edit(Request $request, $id)
    {
        $contact = Contact::with(['email', 'phone'])->find($id);
        $typesEmail = HtmlExtensions::selectEmail('email', 'email[]', '');
        $typesPhone = HtmlExtensions::selectPhone('phone', 'phone[]', '');

        return view('contacts.edit', ['contact' => $contact, 'typesEmail' => $typesEmail, 'typesPhone' => $typesPhone]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $this->validate($request, [
                'name' => 'required|max:50',
                'email' => 'array|min:1',
                'phone' => 'array|min:1'
            ], [
                'name.required' => 'O nome do contato deve ser completado.',
                'name.max' => 'O nome deve conter no maximo 50 caracteres.',
                'email.min' => 'Você deve inserir pelo meneos 1 e-mail',
                'phone.min' => 'Você deve inserir pelo meneos 1 telefone',
            ]);


            $contact = Contact::create([
                'name' => $request->get('name'),
                'user_id' => auth()->id(),
                'nickname' => $request->get('nickname'),
                'address' => $request->get('address'),
                'number' => $request->get('number'),
                'district' => $request->get('district'),
                'city' => $request->get('city'),
                'state' => $request->get('state'),
                'CEP' => $request->get('CEP')
            ]);

            for ($i = 0; $i < count($data['email']); $i++) {
                $contact->email()->create([
                    'email' => $data['email'][$i],
                    'type_email_id' => $data['typeEmail'][$i]
                ]);
            }

            for ($i = 0; $i < count($data['phone']); $i++) {
                $contact->phone()->create([
                    'phone' => $data['phone'][$i],
                    'type_phone_id' => $data['typePhone'][$i]
                ]);
            }

            SendEmail::send(new RegistredContact($contact->id));
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with(['exception' => $e->getMessage()]);
        }
        return redirect(route('contacts.index'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'name' => 'required|max:50',
                'email' => 'array|min:1',
                'phone' => 'array|min:1'
            ], [
                'name.required' => 'O nome do contato deve ser completado.',
                'name.max' => 'O nome deve conter no maximo 50 caracteres.',
                'email.min' => 'Você deve inserir pelo meneos 1 e-mail',
                'phone.min' => 'Você deve inserir pelo meneos 1 telefone',
            ]);

            if (is_numeric($id)) {

                $data = $request->all();

                $contact = Contact::with(['phone', 'email'])->find($id);
                $contact->name = $request->get('name');
                $contact->nickname = $request->get('nickname');
                $contact->address = $request->get('address');
                $contact->number = $request->get('number');
                $contact->district = $request->get('district');
                $contact->city = $request->get('city');
                $contact->state = $request->get('state');
                $contact->CEP = $request->get('CEP');


                for ($i = 0; $i < count($data['email']); $i++) {

                    $contact->email()->updateOrCreate(['email' => $data['email'][$i]], ['type_email_id' => $data['typeEmail'][$i]]);
                }

                for ($i = 0; $i < count($contact->email); $i++) {
                    if (!in_array($contact->email[$i]->email, $data['email'])) {
                        $contact->email[$i]->delete();
                    }
                }

                for ($i = 0; $i < count($data['phone']); $i++) {

                    $contact->phone()->updateOrCreate(['phone' => $data['phone'][$i]], ['type_phone_id' => $data['typePhone'][$i]]);
                }

                for ($i = 0; $i < count($contact->phone); $i++) {
                    if (!in_array($contact->phone[$i]->phone, $data['phone'])) {
                        $contact->phone[$i]->delete();
                    }
                }

                if ($contact->save()) {
                    SendEmail::send(new UpdatedContact($contact->id));
                }
            }
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with(['exception' => $e->getMessage()]);
        }
        return redirect(route('contacts.index'));
    }

    public function destroy(Request $request, int $id)
    {
        try {
            if (is_numeric($id)) {
                $contact = Contact::find($id);
                SendEmail::send(new DeletedContact($contact->id));
                $deleted = $contact->delete();
                if ($deleted) {
                    return response(['message' => 'Apagado com sucesso'], 200);
                }
            }
            return response(['message' => 'Contato invalido'], 400);
        } catch (\Exception $e) {
            return response(['message' => 'Erro ao realizar requisição: ' + $e->getMessage()], 500);
        }
    }
}
