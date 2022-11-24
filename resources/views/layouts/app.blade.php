<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Remote</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.2/flatly/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
    @yield('styles')

</head>

<body>
    @include('sweetalert::alert')
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/wallet">Remote</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav me-auto">
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="/match">Match</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/team">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/player">Player</a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="false">Dropdown</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                    </li> --}}
                </ul>
                {{-- <form class="d-flex">
                    <input class="form-control me-sm-2" type="text" placeholder="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form> --}}
                @if (Auth::user())
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="btn btn-danger mx-2 my-2 my-sm-0" type="submit">Logout</button>
                    </form>
                @else
                    <a href="/wallet">
                        <button class="btn btn-secondary my-2 my-sm-0"
                            type="button">Wallet</button>
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer class="mt-3 py-3">
        <div class="container">
            <span>2022 &copy; Pipeline Network Sdn. Bhd.
            </span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    @yield('scripts')
</body>

</html>
