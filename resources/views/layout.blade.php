<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    {{-- fonte externa --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- sass e javascript -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <header
        class="bg-body-secondary d-flex flex-wrap justify-content-center py-3 border-bottom border-black navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a href=""
                class="d-flex align-items-center mb-md-0 me-md-auto text-dark link-body-emphasis text-decoration-none">
                <span class="fs-1 text-primary fw-bold titulos">Pagina dos Posts</span>
            </a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu-navegacao">
                <span class="navbar-toggler-icon"></span>
            </button>

            <nav class="navbar-collapse collapse justify-content-end" id="menu-navegacao">
                <ul class="nav nav-pills header_list">
                    <li class="nav-item"><a href="/"
                            class="d-block p-2 fs-4 m-2 mx-3 link-primary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover"
                            aria-current="page"><i class="bi bi-house"></i> Home</a></li>
                    <li class="nav-item"><a href="/"
                            class="d-block p-2 fs-4 m-2 mx-3 link-primary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover"><i
                                class="bi bi-chat-left-text"></i> Sobre nós</a></li>
                    <li class="nav-item"><a href="/"
                            class="d-block p-2 fs-4 m-2 mx-3 link-primary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover"><i
                                class="bi bi-shop"></i> Posts</a></li>
                    <li class="nav-item"><a href="/"
                            class="d-block p-2 fs-4 m-2 mx-3 link-primary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover"><i
                                class="bi bi-question-circle-fill"></i> Suporte</a></li>
                    @auth
                        <li class="nav-item">
                            <div class="dropdown">
                                <button
                                    class="btn btn-outline-primary d-flex justify-content-center align-items-center mt-2 dropdown-toggle fs-4"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Olá -
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/newpost">Novo Post</a></li>
                                    <form action="/logout" method="post">
                                        @csrf
                                        <li><button type="submit" class="dropdown-item">Sair</button></li>
                                    </form>

                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="nav-item"><a href="/login"
                                class="d-block p-2 fs-4 m-2 mx-3 header_buttons btn btn-outline-primary">Login</a></li>
                        <li class="nav-item"><a href="/cadastrar"
                                class="d-block p-2 fs-4 m-2 mx-3 header_buttons btn btn-primary">Cadastro</a>
                        </li>
                    @endauth

                </ul>
            </nav>
        </div>
    </header>
    {{-- conteudo --}}
    @yield('content')
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <a href="" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                    <img src="https://png.pngtree.com/png-vector/20230209/ourmid/pngtree-notebook-icon-png-image_6591697.png"
                        width="36" height="36" alt="">
                </a>
                <span class="mb-md-0 text-body-secondary fs-5">© 2023 Post, Inc</span>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-body-secondary" href=""><x-simpleline-social-twitter /></a>
                </li>
                <li class="ms-3"><a class="text-body-secondary" href=""><x-simpleline-social-instagram /></a>
                </li>
                <li class="ms-3"><a class="text-body-secondary" href=""><i class="bi fs-4 bi-linkedin"></i></a>
                </li>
            </ul>

        </footer>
</body>

</html>
