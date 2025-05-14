<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Sistema de Inventario | Carlos Lachapell</title>

  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
  <div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container-fluid">
          <a class="navbar-brand" href="/"><i class="fa-solid fa-cart-flatbed"></i> InvenPost</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          @auth
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="/components/clientes">Clientes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/components/articulos">Artículos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/components/pedidos">Pedidos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/components/facturas">Facturas</a>
              </li>
            </ul>
            <form action="{{ route('logout') }}" method="POST" class="d-flex">
              @csrf
              <button type="submit" class="btn btn-danger"><i class="fa-solid fa-right-to-bracket"></i></button>
            </form>
          </div>

          @endauth
        </div>
      </nav>

      <main>
        @yield('content')
      </main>
    </div>
  </div>

  @yield('scripts')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>

</html>