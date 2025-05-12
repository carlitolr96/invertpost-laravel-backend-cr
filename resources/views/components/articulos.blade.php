@extends('layouts.app')
@section('content')
    <div>
    <h5 class="mb-4">Listado de Articulos</h5>

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
            </tr>
        </thead>
        <tbody>
            @foreach ($articulos as $articulo)
            <tr>
                <td>{{ $articulo->id }}</td>
                <td>{{ $articulo->descripcion }}</td>
                <td>{{ $articulo->fabricante }}</td>
                <td>{{ $articulo->codigo_barras }}</td>
                <td>{{ $articulo->precio }}</td>
                <td>{{ $articulo->stock }}</td>
                <td>{{ $articulo->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
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