@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-lg-10 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="my-2 right">
                        <a href="{{route('contacts.create')}}">
                            <button class="btn btn-primary">Cadastrar</button>
                        </a>
                    </div>

                    <table class="display table-responsive nowrap " width="100%" id="tUsers">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>E-mails</th>
                                <th>Telefones</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css" />
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/v/dt/dt-1.10.25/af-2.3.7/r-2.2.8/datatables.min.js"></script>

<script>
    function deleteContact(id) {
        $.ajax({
            url: '/contacts/' + id,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log(data);
                $("#tUsers").DataTable().ajax.reload();
                alert(data.message);
            },
            error: function(jqxhr, status) {
                console.log(status)
                $("#tUsers").DataTable().ajax.reload();
                alert(status);
            }
        })
    }

    $(document).ready(function() {
        $("#tUsers").DataTable({
            serverSide: true,
            ajax: {
                url: "{{route('contacts.list')}}",
                type: 'GET'
            },
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json'
            },
            responsive: true,
            columns: [{
                    render: function(data, type, row, meta) {
                        return data + (row.nickname != null ? " (" + row.nickname + ")" : "");
                    },
                    data: 'name'
                },
                {
                    render: function(data, type, row, meta) {
                        let html = '<ul class="list-group">';
                        data.forEach(element => {
                            html += '<li class="list-group-item">' + element.email + '</li>';
                        });
                        html += '</ul>';

                        return html;
                    },
                    data: 'email'
                },
                {
                    render: function(data, type, row, meta) {
                        let html = '<ul class="list-group">';

                        data.forEach(element => {
                            html += '<li class="list-group-item">' + element.phone + '</li>';
                        });
                        html += '</ul>';
                        return html;
                    },
                    data: 'phone'
                },
                {
                    render: function(data, type, row, meta) {
                        let html = "";
                        html += '<a href="contacts/' + row.id + '/edit"><button class="btn btn-warning mx-2">Editar</button></a>';
                        html += '<button class="btn btn-danger mx-2" onClick="deleteContact(' + row.id + ');"  >Apagar</button>';

                        return html;
                    },
                    data: 'id'
                },

            ]

        })
    });
</script>
@endsection