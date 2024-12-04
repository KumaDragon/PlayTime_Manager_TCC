@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-register-client">
                    <div class="card-header">
                        Cadastrar cliente
                    </div>
                    <a href="{{route('clientes.index')}}" class="btn btn-info">Voltar</a>
                    <div class="card-body">
                        <form action="{{route('clientes.store')}}" method="post">
                            

                            @csrf
                            <div class="form-group mt-3">
                                <label for="">Nome</label>
                                <input type="text" name="name" class="form-control" id="">
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Telefone</label>
                                <input type="text" name="telefone" class="form-control" id="">
                            </div>
                            <div class="form-group mt-3">
                                <button class="btn btn-success w-100">Cadastrar</button>
                            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection