@extends('layouts.app')
@section('content')
@section('scripts')
<script src="{{ asset('js/clientes.js') }}"></script>
@endsection

<div>

    @if ($clientes->count() > 0)
    <div class="row">
        <div class="col-8">
            <h5 class="mb-4">Listado de Clientes</h5>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#crearClienteModal">
                Nuevo Cliente
            </button>
        </div>
    </div>

    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Tipo de Cliente</th>
                    <th>Fecha de Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->ClienteId }}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->tipo_cliente }}</td>
                    <td>{{ $cliente->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $clientes->links() }}
    </div>
    @else
    <div class="alert alert-info">
        No hay clientes registrados.
    </div>
    @endif
</div>

@include('create.modal-crear-cliente')
@endsection