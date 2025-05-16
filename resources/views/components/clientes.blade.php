@extends('layouts.app')
@section('content')

@include('create.modal-crear-cliente')
@include('edit.modal-edit-cliente')

<div>
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

    @if ($clientes->count() > 0)
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
                    <td>
                        <button type="button" class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#editarClienteModal"
                            data-id="{{ $cliente->ClienteId }}"
                            data-nombre="{{ $cliente->nombre }}"
                            data-telefono="{{ $cliente->telefono }}"
                            data-tipo_cliente="{{ $cliente->tipo_cliente }}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <form action="{{ route('clientes.destroy', $cliente->ClienteId) }}" method="POST" class="d-inline form-eliminar-cliente">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.form-eliminar-cliente').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush