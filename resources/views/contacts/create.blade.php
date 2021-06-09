@extends('layouts.app')
@inject('htmlExtensions', 'App\Http\Helpers\HtmlExtensions')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-lg-8 col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="my-2 right">
                        <button class="btn btn-primary">Voltar</button>
                    </div>
                    <div class="row">
                    @if (session('exception'))
                        <div class="alert alert-danger">
                            {{ session('exception') }}
                        </div>
                        @endif
                        <form action="{{route('contacts.store')}}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="labelName">Nome*</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" required>
                                @if($errors->has('name'))
                                <small id="nameHelp" class="form-text text-muted">{{$errors->first('name')}}</small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="labelName">Apelido</label>
                                <input type="text" class="form-control" name="nickname" id="nickname" value="{{old('nickname')}}">
                            </div>

                            <div id="addres" class="shadow-sm p-2 mt-2">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6>Endereço</h6>
                                </div>

                                <div class="row">
                                    <div class="form-group mb-3 col-12 col-lg-3">
                                        <label for="labelName">CEP</label>
                                        <input type="text" id="cep" name="CEP" class="form-control m-input" autocomplete="off">
                                    </div>

                                    <div class="form-group mb-3 col-12 col-lg-6">
                                        <label for="labelName">Cidade</label>
                                        <input type="text" id="city" name="city" class="form-control m-input" autocomplete="off">
                                    </div>

                                    <div class="form-group mb-3 col-12 col-lg-3">
                                        <label for="labelName">Estado</label>
                                        <input type="text" id="state" name="state" class="form-control m-input" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group mb-3 col-12 col-lg-5">
                                        <label for="labelName">Endereço</label>
                                        <input type="text" id="address" name="address" class="form-control m-input" autocomplete="off">
                                    </div>

                                    <div class="form-group mb-3 col-12 col-lg-3">
                                        <label for="labelName">Numero</label>
                                        <input type="text" id="number" name="number" class="form-control m-input" autocomplete="off">
                                    </div>

                                    <div class="form-group mb-3 col-12 col-lg-4">
                                        <label for="labelName">Bairro</label>
                                        <input type="text" id="district" name="district" class="form-control m-input" autocomplete="off">
                                    </div>
                                </div>
                            </div>


                            <div id="emailInputList" class="shadow-sm p-2 mt-2">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6>Email</h6>
                                    <button id="addRow" type="button" class="btn btn-warning">+</button>
                                </div>
                                <div id="inputRowEmail" class="input-group mb-3">
                                    <input type="email" name="email[]" class="form-control m-input" placeholder="nome@email.com" autocomplete="off" required>
                                    <div class="input-group-append">
                                        {!! $htmlExtensions->selectEmail('typeEmail','typeEmail[]', 'form-select') !!}
                                    </div>
                                </div>
                            </div>

                            <div id="phoneInputList" class="shadow-sm p-2 mt-2">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6>Telefones</h6>
                                    <button id="addRowPhone" type="button" class="btn btn-warning">+</button>
                                </div>
                                <div id="inputRowPhone" class="input-group mb-3">
                                    <input type="text" name="phone[]" class="form-control m-input" minlength="14" required placeholder="(01) 2345-6789" autocomplete="off">
                                    <div class="input-group-append">
                                        {!! $htmlExtensions->selectPhone('typePhone[]', 'typePhone[]','form-select') !!}
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')

<script src="{{asset('js/jquery.mask.js')}}"></script>

<script type="text/javascript">
    var phoneMaskBehavior = function(val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        phoneOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

    $('#phoneInputList input').mask(phoneMaskBehavior, phoneOptions);
    $('#cep').mask('00000-000');

    $("#cep").change(function() {
        $.ajax({
            url: "{{route('correios.cep')}}",
            method: 'get',
            data: {
                cep: $('#cep').val()
            },
            success: function(data) {
                $('#city').val(data.return.cidade);
                $('#state').val(data.return.uf);
                $('#district').val(data.return.bairro);
                $('#address').val(data.return.end);
            }
        });

    });

    $("#addRow").click(function() {
        var html = '';
        html += '<div id="inputRowEmail" class="input-group mb-3">';
        html += '<input type="email" name="email[]" class="form-control m-input" placeholder="nome@email.com" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '{!! $htmlExtensions->selectEmail("typeEmail","typeEmail[]", "form-select") !!}';
        html += '</div>';
        html += '<div class="input-group-append">';
        html += '<button id="removeEmail" type="button" class="btn btn-danger">Remover</button>';
        html += '</div>';
        html += '</div>';

        $('#emailInputList').append(html);
    });

    // remove row
    $(document).on('click', '#removeEmail', function() {
        $(this).closest('#inputRowEmail').remove();
    });

    $("#addRowPhone").click(function() {
        var html = '';
        html += '<div id="inputRowPhone" class="input-group mb-3">';
        html += '<input type="text" name="phone[]" class="form-control m-input" pminlength="14" required placeholder="(01) 2345-6789" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '{!! $htmlExtensions->selectPhone("typePhone[]", "typePhone[]", "form-select") !!}'
        html += '</div>';
        html += '<div class="input-group-append">';
        html += '<button id="removePhone" type="button" class="btn btn-danger">Remover</button>';
        html += '</div>';
        html += '</div>';

        $('#phoneInputList').append(html);
        $('#phoneInputList input').mask(phoneMaskBehavior, phoneOptions);

    });

    // remove row
    $(document).on('click', '#removePhone', function() {
        $(this).closest('#inputRowPhone').remove();
    });
</script>
@endsection
@endsection