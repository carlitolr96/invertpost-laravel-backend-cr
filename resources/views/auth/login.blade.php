@extends('layouts.app')

@section('content')
<div class="row justify-content-center mb-3">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
            <div class="card-body p-3 p-md-4 p-xl-5">
                <div class="text-center mb-3">
                    <h1 class="h3 mb-0">InvenPost</h1>
                </div>

                <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Inicia sesión en tu cuenta</h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="row gy-3">

                        <div class="col-12">
                            <div class="form-floating">
                                <input
                                    id="usuario"
                                    type="text"
                                    name="usuario"
                                    class="form-control @error('usuario') is-invalid @enderror"
                                    placeholder="Usuario"
                                    value="{{ old('usuario') }}"
                                    required
                                    autocomplete="usuario"
                                    autofocus>
                                <label for="usuario">{{ __('Usuario') }}</label>
                                @error('usuario')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Contraseña"
                                    required
                                    autocomplete="current-password">
                                <label for="password">{{ __('Contraseña') }}</label>
                                @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Recordarme') }}
                                </label>
                            </div>
                        </div>

                        {{-- Botón de envío --}}
                        <div class="col-12">
                            <div class="d-grid my-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            @if (Route::has('password.request'))
                            <a class="text-decoration-none" href="{{ route('password.request') }}">
                                {{ __('¿Olvidaste tu contraseña?') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection