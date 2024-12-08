@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
            <div class="col-lg-10 col-md-10 col-sm-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Serviços</span>

                    <div class="d-flex gap-2">
                    <a href="{{ route('servicos.create') }}" class="btn btn-secondary">+ Novo</a>
                    <a href="{{ route('home') }}" class="btn btn-primary">Voltar</a>
                    </div>

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
                                <td>{{ $servico->name }}</td>
                                <td>R$ {{ number_format($servico->valor, 2, ',', '.') }}</td>
                                <td>{{ $servico->tempo }} minutos</td>
                                <td>
                                    <a href="{{ route('servicos.edit', $servico) }}" type="button" class="btn btn-primary">Editar</a>
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
                            <tr>
                                <td colspan="4" class="text-center">Nenhum serviço encontrado.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
