@extends('layouts.app')
@section('content')

@include('create.modal-crear-articulo')
@include('edit.modal-edit-articulo')

<div>
    <div class="row mb-3">
        <div class="col-8">
            <h5 class="mb-0">Listado de Artículos</h5>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#crearArticuloModal">
                Nuevo Artículo
            </button>
        </div>
    </div>

    @if ($articulos->count() > 0)
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fabricante</th>
                <th>Codigo de Barra</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articulos as $articulo)
            <tr>
                <td>{{ $articulo->ArticuloId }}</td>
                <td>{{ $articulo->descripcion }}</td>
                <td>{{ $articulo->fabricante }}</td>
                <td>{{ $articulo->codigo_barras }}</td>
                <td>{{ $articulo->precio }}</td>
                <td>{{ $articulo->stock }}</td>
                <td>{{ $articulo->created_at }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#editarArticuloModal"
                        data-id="{{ $articulo->ArticuloId }}"
                        data-descripcion="{{ $articulo->descripcion }}"
                        data-fabricante="{{ $articulo->fabricante }}"
                        data-codigo_barras="{{ $articulo->codigo_barras }}"
                        data-precio="{{ $articulo->precio }}"
                        data-stock="{{ $articulo->stock }}">
                        <i class="fa fa-edit"></i>
                    </button>
                    
                    <form action="{{ route('articulos.destroy', $articulo->ArticuloId) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este artículo?')">
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

    <div class="d-flex justify-content-center">
        {{ $articulos->links() }}
    </div>
    @else
    <div class="alert alert-info">
        No hay articulos registrados.
    </div>
    @endif
</div>
@endsection