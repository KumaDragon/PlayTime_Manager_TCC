@extends('layouts.app')

@section('content')

<!-- Tabela -->
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Editar Serviço</span>

                <a href="{{route('servicos.index')}}" class="btn btn-primary">Voltar</a>
            </div>

            <div class="card-body">
                <form id="serviceForm" action="{{route('servicos.update', $servico)}}" method="post">
                    @csrf
                    @method("PUT")
                    <input type="hidden" id="serviceId" name="id"> 

                    <div class="form-group mt-3">
                        <label for="name">Brinquedo</label>
                        <input type="text" id="name" name="name" value="{{$servico->name}}" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="tempo">Tempo</label>
                        <input type="number" id="tempo" name="tempo" value="{{$servico->tempo}}" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="valor">Valor</label>
                        <input type="number" id="valor" name="valor" value="{{$servico->valor}}" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success w-100">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
