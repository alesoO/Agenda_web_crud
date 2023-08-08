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
    {{-- Framework toastr para notificações --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Import do bootstrap icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    {{-- Imports do scss padrão do Laravel incluindo o bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    {{-- Inicio do Header --}}
    <header
        class="bg-body-secondary d-flex flex-wrap justify-content-center py-3 border-bottom border-black navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a href="/"
                class="d-flex align-items-center mb-md-0 me-md-auto text-dark link-body-emphasis text-decoration-none">
                <span class="fs-1 text-primary fw-bold titulos">Pagina dos Posts</span>
            </a>
            {{-- Navbar do menu Mobile --}}
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu-navegacao">
                <span class="navbar-toggler-icon"></span>
            </button>
            {{-- Links de navegação do Header --}}
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
                                class="bi bi-file-post"></i></i> Posts</a></li>
                    <li class="nav-item"><a href="/"
                            class="d-block p-2 fs-4 m-2 mx-3 link-primary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover"><i
                                class="bi bi-question-circle-fill"></i> Suporte</a></li>
                    {{-- Inicio do menu do usuario logado --}}
                    @auth
                        <li class="nav-item">
                            <div class="dropdown display_desktop">
                                <button
                                    class="btn btn-outline-primary d-flex justify-content-center align-items-center mt-2 dropdown-toggle fs-4"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Olá - {{ auth()->user()->name }} {{-- <- Exibe o nome do usuario cadastrado  --}}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/newpost">Novo Post</a></li>
                                    <form action="/edituser/{{ auth()->user()->id }}" method="post">
                                        @csrf
                                        <li><button type="submit" class="dropdown-item">Editar cadastro</button></li>
                                        {{-- Link para o menu de edição --}}
                                    </form>
                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#warning{{ auth()->user()->id }}">
                                        Apagar cadastro {{-- Ativador do modal de exclusão --}}
                                    </button>
                                    <form action="/logout" method="post">
                                        @csrf
                                        <li><button type="submit" class="dropdown-item">Sair</button></li>
                                        {{-- Botão de Logout --}}
                                    </form>
                                </ul>
                            </div>
                        </li>
                        {{-- Parte do menu especifico para mobile --}}
                        <div class="display_mobile">
                            <li class="nav-item"><a href="/newpost"
                                    class="d-block p-2 fs-4 m-2 mx-3 header_buttons btn btn-outline-primary">Novo Post</a>
                            </li>
                            <form class="d-flex justify-content-center flex-fill" action="/logout" method="post">
                                @csrf
                                <button type="submit"
                                    class="flex-fill p-2 fs-4 m-2 mx-3 header_buttons btn btn-danger">Sair</button>
                            </form>
                        </div>
                        {{-- Fim do menu do usuario --}}
                    @else
                        {{-- É exibido caso o usuario não esteja logado --}}
                        <li class="nav-item"><a href="/login"
                                class="d-block p-2 fs-4 m-2 mx-3 header_buttons btn btn-outline-primary">Login</a></li>
                        <li class="nav-item"><a href="/register"
                                class="d-block p-2 fs-4 m-2 mx-3 header_buttons btn btn-primary">Cadastro</a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>

    </header>

    {{-- conteudo --}}
    @yield('content')
    @auth
        <!-- Modal de exculsão do usuario -->
        <div class="modal fade" id="warning{{ auth()->user()->id }}" tabindex="-1" aria-labelledby="warningLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white titulos">
                        <h1 class="modal-title fs-5 fw-bold" id="warningLabel">Aviso!
                            -
                            Essa ação não pode ser desfeita!
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem certza que deseja apagar o seu cadastro ?
                    </div>
                    <div class="modal-footer d-flex">
                        <form class="flex-fill" action="/deleteuser/{{ auth()->user()->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div>
                                <h3 class="h3 mb-3 fw-normal titulos fs-4">Confirme sua senha: </h3> {{-- Para a exclusão e nescessaria a senha do usuario --}}
                                <div class="form-floating">
                                    <input type="password" name="password" id="password" class="mb-4 form-control"
                                        placeholder="Confirmação da Senha">
                                    <label>Senha</label>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-danger btn-lg">Sim</button>
                                <button type="button" class="btn btn-secondary ms-2 btn-lg"
                                    data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endauth
    {{-- Fim do modal e Inicio do footer --}}
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
                <li class="ms-3"><a class="text-body-secondary" href=""><i
                            class="bi fs-4 bi-twitter"></i></a>
                </li>
                <li class="ms-3"><a class="text-body-secondary" href=""><i
                            class="bi fs-4 bi-instagram"></i></a>
                </li>
                <li class="ms-3"><a class="text-body-secondary" href=""><i
                            class="bi fs-4 bi-linkedin"></i></a>
                </li>
            </ul>

        </footer>
        {{-- Import do Jquery --}}
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        {{-- Import do JavaScript do Toastr --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{asset('js/script.js')}}"></script>
        {{-- Script dos Toasts de mensagens de erros --}}
        @if (Session::has('message'))
            <script>
                toastr.options = {
                    "progressBar": true,
                    "closeButton": true
                }
                toastr.success("{{ Session::get('message') }}", 'Sucesso!', {
                    timeOut: 12000
                });
            </script>
        @endif
        @if (Session::has('error'))
            <script>
                toastr.options = {
                    "progressBar": true,
                    "closeButton": true
                }
                toastr.error("{{ Session::get('error') }}", 'Erro!', {
                    timeOut: 12000
                });
            </script>
        @endif
        @if (Session::has('info'))
            <script>
                toastr.options = {
                    "progressBar": true,
                    "closeButton": true
                }
                toastr.info("{{ Session::get('info') }}", 'Info!', {
                    timeOut: 12000
                });
            </script>
        @endif
</body>

</html>
