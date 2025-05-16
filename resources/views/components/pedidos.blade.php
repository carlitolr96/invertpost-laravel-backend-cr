@extends('layouts.app')
@section('content')

@include('edit.modal-edit-pedidos')

<div>
    <h5 class="mb-4">Listado de Pedidos</h5>

    <div class="row m-3">
        <form action="{{ route('pedidos.store') }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col">
                <label for="cliente_id" class="form-label mb-0">Cliente:</label>
                <select name="cliente_id" id="cliente_id" class="form-select" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($clientes as $cliente)
                    <option value="{{ $cliente->ClienteId }}">{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="articulo_id" class="form-label mb-0">Artículo:</label>
                <select name="articulo_id" id="articulo_id" class="form-select" required>
                    <option value="">Seleccione un artículo</option>
                    @foreach($articulos as $articulo)
                    <option value="{{ $articulo->ArticuloId }}">{{ $articulo->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success">Agregar pedido</button>
            </div>
        </form>
    </div>

    <br>

    @if ($pedidos->count() > 0)
    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Artículo</th>
                    <th>Fecha de Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->ClienteId }}</td>
                    <td>{{ $pedido->cliente->nombre ?? 'Sin nombre' }}</td>
                    <td>{{ $pedido->articulo->descripcion ?? 'Sin artículo' }}</td>
                    <td>{{ $pedido->fecha_pedido }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#editarPedidoModal"
                            data-id="{{ $pedido->PedidoId }}"
                            data-cliente="{{ $pedido->ClienteId }}"
                            data-articulo="{{ $pedido->ArticuloId }}"
                            data-fecha="{{ $pedido->fecha_pedido }}">
                            <i class="fa fa-edit"></i>
                        </button>

                        <form action="{{ route('pedidos.destroy', $pedido->PedidoId) }}" method="POST" class="d-inline form-eliminar-pedido">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.form-eliminar-pedido').forEach(form => {
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