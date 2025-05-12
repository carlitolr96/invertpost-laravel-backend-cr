@extends('layouts.app')
@section('content')
    <div>
    <h5 class="mb-4">Listado de Pedidos</h5>

    @if ($pedidos->count() > 0)
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Fecha de Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->ClienteId }}</td>
                <td>{{ $pedido->fecha_pedido }}</td>
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