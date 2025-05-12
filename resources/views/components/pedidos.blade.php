@extends('layouts.app')
@section('content')
    <div>
    <h5 class="mb-4">Listado de Pedidos</h5>

    @if ($pedidos->count() > 0)
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>NA</th>
                <th>NA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fpedidos as $pedido)
            <tr>
                <td>{{ $pedidos->id }}</td>
                <td>{{ $pedidos->nombre }}</td>
                <td>{{ $pedidos->telefono }}</td>
                <td>{{ $pedidos->tipo_cliente }}</td>
                <td>{{ $pedidos->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <div class="d-flex justify-content-center">
        {{ $pedidos->links() }}
    </div>
    @else
    <div class="pb-2">
        <div class="alert alert-warning" role="alert">
            No hay pedidos registrados.
        </div>
    </div>
    @endif
</div>
@endsection