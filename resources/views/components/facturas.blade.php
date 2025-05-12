@extends('layouts.app')
@section('content')
<div>
    <h5 class="mb-4">Listado de Facturas</h5>

    @if ($facturas->count() > 0)
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>NA</th>
                <th>NA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facturas as $factura)
            <tr>
                <td>{{ $factura->id }}</td>
                <td>{{ $factura->nombre }}</td>
                <td>{{ $factura->telefono }}</td>
                <td>{{ $factura->tipo_cliente }}</td>
                <td>{{ $factura->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <div class="d-flex justify-content-center">
        {{ $facturas->links() }}
    </div>
    @else
    <div class="pb-2">
        <div class="alert alert-warning" role="alert">
            No hay facturas registradas.
        </div>
    </div>
    @endif
</div>
@endsection