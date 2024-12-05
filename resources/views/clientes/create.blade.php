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
                                <input type="text" name="telefone" class="form-control" id="telefone" oninput="formatarTelefone(this)">
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
function formatarTelefone(input) {
    let telefone = input.value.replace(/\D/g, ''); // Remove qualquer caractere não numérico
    if (telefone.length <= 10) {
        telefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3'); // Formato (XX) XXXXX-XXXX
    } else {
        telefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3'); // Formato (XX) XXXXX-XXXX
    }
    input.value = telefone; // Atualiza o valor do campo com a máscara
}
</script>
@endsection