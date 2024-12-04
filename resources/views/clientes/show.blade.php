@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Cadastrar criança</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{route('criancas.store')}}" method="post">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="">Nome</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Data de Nascimento</label>
                                <input type="date" name="nascimento" class="form-control">
                            </div>
                            <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                            <div class="form-group mt-3">
                                <button class="btn btn-success w-100">Cadastrar</button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal" id="novaComanda">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Abrir Comanda</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{route('consumo.store')}}" method="post">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="">Criança</label>
                                <select name="crianca_id" id="" class="form-control">
                                    @forelse($cliente->criancas as $crianca)
                                        <option value="{{$crianca->id}}">{{$crianca->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Tempo</label>
                                <select name="servico_id" id="" class="form-control">
                                    @forelse($servicos as $servico)
                                        <option value="{{$servico->id}}">{{$servico->name}} -- R${{$servico->valor}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                            <div class="form-group mt-3">
                                <button class="btn btn-success w-100">Cadastrar</button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Crianças cadastradas de {{ $cliente->name }}</span>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">+ Novo</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novaComanda">Abrir comanda</button>
                        <a href="{{route('clientes.create')}}" class="btn btn-primary">Voltar</a>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Criança</th>
                                    <th>Nascimento</th>
                                    <th>Idade</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cliente->criancas as $crianca)
                                    <tr>
                                        <td>{{ $crianca->name }}</td>
                                        <td>{{ $crianca->nascimento->format('d-m-Y') }}</td>
                                        <td>{{ $crianca->nascimento->diffInYears() }} anos</td>
                                        <td>
                                            <button>Editar</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Este cliente não tem crianças cadastradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
