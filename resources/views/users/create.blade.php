@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="custom-card-body-register">
                    <div class="card-header">
                        Cadastrar novo usuário
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

                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <a href="{{ route('users.index') }}" class="btn btn-primary">Voltar</a>
                            
                            <div class="form-group mt-3">
                                <label for="name">Nome</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="cpf">CPF</label>
                                <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" required oninput="formatarCPF(this)">
                                @error('cpf')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="telefone">Telefone</label>
                                <input id="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" maxlength="15" oninput="formatarTelefone(this)" pattern="\(\d{2}\) \d{5}-\d{4}" title="Formato: (00) 00000-0000">
                                @error('telefone')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="password">Senha</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="password-confirm">Confirmar Senha</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-success w-30">Cadastrar</button>
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
    function formatarCPF(campo) {
        let valor = campo.value.replace(/\D/g, ''); // Remove qualquer coisa que não seja número
        if (valor.length > 11) valor = valor.slice(0, 11); // Limita a 11 caracteres

        if (valor.length > 9) {
            campo.value = `${valor.slice(0, 3)}.${valor.slice(3, 6)}.${valor.slice(6, 9)}-${valor.slice(9)}`;
        } else if (valor.length > 6) {
            campo.value = `${valor.slice(0, 3)}.${valor.slice(3, 6)}.${valor.slice(6)}`;
        } else if (valor.length > 3) {
            campo.value = `${valor.slice(0, 3)}.${valor.slice(3)}`;
        } else {
            campo.value = valor;
        }
    }

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
