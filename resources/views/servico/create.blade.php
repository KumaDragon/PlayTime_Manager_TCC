@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-register-client">
                    <div class="card-header">
                        Novo serviço
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

                        <form action="{{route('servicos.store')}}" method="post">

                        @csrf
                    <input type="hidden" id="serviceId" name="id"> <!-- Campo oculto para o ID -->

                    <div class="form-group mt-3">
                        <label for="name">Brinquedo</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="tempo">Tempo</label>
                        <input type="number" id="tempo" name="tempo" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="valor">Valor</label>
                        <input type="number" id="valor" name="valor" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" id="modalSubmitButton" class="btn btn-success w-100">Salvar</button>
                    </div>
                </form>
            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
