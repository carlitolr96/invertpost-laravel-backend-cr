@extends('layouts.app')
@section('content')

<div class="card mx-auto" style="max-width: 400px;">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Perfil de Usuario</h5>
    </div>
    <div class="card-body">
        <p><strong>Nombre:</strong> {{ Auth::user()->nombre ?? Auth::user()->usuario ?? 'Sin nombre' }}</p>
        <p><strong>Usuario:</strong> {{ Auth::user()->usuario ?? Auth::user()->email }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email ?? 'No registrado' }}</p>
        <p><strong>Rol:</strong> {{ Auth::user()->rol ?? 'No especificado' }}</p>
        <p><strong>Fecha de registro:</strong> {{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y') : 'Desconocida' }}</p>
    </div>
</div>
@endsection