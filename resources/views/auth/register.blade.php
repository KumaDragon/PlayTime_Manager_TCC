@extends('layouts.app')

@section('content')
<div class="container custom-container-register">
    <div class="row justify-content-center">
            <div class="col-lg-10 col-md-10 col-sm-8">
            <div class="custom-card-body-register">
                <div class="card-header text-center">
                    {{ __('CADASTRE-SE') }}
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group mt-3 row justify-content-center">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-3 row justify-content-center">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-3 row justify-content-center">
                        <label for="cpf" class="col-md-4 col-form-label text-md-end">{{ __('CPF') }}</label>

                        <div class="col-md-6">
                            <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" required oninput="formatarCPF(this)">

                            @error('cpf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-3 row justify-content-center">
                        <label for="telefone" class="col-md-4 col-form-label text-md-end">{{ __('Telefone') }}</label>

                        <div class="col-md-6">
                            <input id="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" maxlength="15" oninput="formatarTelefone(this)" pattern="\(\d{2}\) \d{5}-\d{4}" title="Formato: (00) 00000-0000" required>

                            @error('telefone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-3 row justify-content-center">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Senha') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-3 row justify-content-center">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar senha') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group mt-3 row justify-content-center">
                        <button type="submit" class="btn btn-success" style="width: 250px">
                            {{ __('Cadastrar') }}
                            
                        </button>
                        
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('login') }}" class="btn btn-primary ms-auto">Voltar</a>
                    </div>
                </form>
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
