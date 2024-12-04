@extends('layouts.app')

@section('content')

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-services">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Serviços</span>
                        <a href="{{route('servicos.create')}}" class="btn btn-info">+Novo</a>
                        <a href="{{route('home')}}" class="btn btn-info">Voltar</a>
                    </div>

                    <div class="card-body-service">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Serviço</th>
                                <th>Valor</th>
                                <th>Tempo</th>
                                <th>Ação</th> 
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($servicos as $servico)

                                <tr>
                                    <td>{{$servico->name}}</td>
                                    <td>{{$servico->valor}}</td>
                                    <td>{{$servico->tempo}}</td>
                                    <td>
                                    <a href="{{route('servicos.edit', $servico)}}" type="button" class="btn btn-info">Editar</a>
                                        <form action="{{ route('servicos.destroy', $servico->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                                        Excluir
                                        </button>
                                        </form>
                                    </td>
                                </tr>

                            @empty
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

