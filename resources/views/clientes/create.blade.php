@extends('layouts.app')

@section('content')


    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-register-client">
                    <div class="card-header">
                        Cadastrar cliente
                    </div>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{route('clientes.store')}}" method="post">

                            @csrf
                            <a href="{{route('clientes.index')}}" class="btn btn-info">Voltar</a>
                            <div class="form-group mt-3">
                                <label for="">Nome</label>
                                <input type="text" name="name" class="form-control" id="">
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Telefone</label>
                                <input type="text" name="telefone" class="form-control" id="telefone" maxlength="15" oninput="formatarTelefone(this)" pattern="\(\d{2}\) \d{5}-\d{4}" title="Formato: (00) 00000-0000">
                            </div>
                            <div class="form-group mt-3">
                                <button class="btn btn-success w-30">Cadastrar</button>
                            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    function formatarTelefone(campo) {
        let valor = campo.value.replace(/\D/g, ''); // Remove tudo que não é dígito
        if (valor.length > 11) valor = valor.slice(0, 11); // Limita a 11 dígitos

        if (valor.length > 10) {
            campo.value = `(${valor.slice(0, 2)}) ${valor.slice(2, 7)}-${valor.slice(7)}`;
        } else if (valor.length > 6) {
            campo.value = `(${valor.slice(0, 2)}) ${valor.slice(2, 6)}-${valor.slice(6)}`;
        } else if (valor.length > 2) {
            campo.value = `(${valor.slice(0, 2)}) ${valor.slice(2)}`;
        } else {
            campo.value = valor;
        }
    }
</script>
@endsection