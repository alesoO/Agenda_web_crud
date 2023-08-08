{{-- Import do layout --}}
@extends('layout')
{{-- Declaração do titulo da pagina --}}
@section('title', 'Home')
{{-- Declarção do conteudo da pagina --}}
@section('content')

    <main>
        <div class="container-sm">
            <div class="container pt-5">
                <h2 class="border-bottom border-primary titulos">Posts</h2>
            </div>
            {{-- Lista de posts para exibição --}}
            <div class="row row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2 mt-5">
                {{-- Contador de post --}}
                @foreach ($posts as $post)
                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="bd-placeholder-img card-img-top" width="100%" height="250px"
                                src="{{ asset($post->image) }}" /> {{-- Recupera o endereço da image no banco de dados --}}
                            <div class="card-body">
                                <h4 class="titulo-card">{{ $post['title'] }}</h4> {{-- Recupera o titulo do post --}}
                                <h5>Autor original: {{ $post->user->name }}</h5> {{-- Recupera o autor do post --}}
                                <h6>Outros autores; @foreach ($post->users as $user)
                                        {{ $user->name }},
                                    @endforeach
                                </h6>
                                <p class="card-text">{{ $post['body'] }}</p> {{-- Recupera o conteudo do post --}}
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-body-secondary">{{ $post['updated_at'] }}</small>
                                    {{-- Recupera a ultima atualização do post --}}
                                    {{-- Menu de Configurações do post, apenas o usuario autor pode ver esse menu --}}
                                    @auth
                                        @if ($post->user_id === auth()->id() || $post->users->contains(auth()->user()))
                                            <div class="d-flex" role="group">
                                                <form action="/editpost/{{ $post->id }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-outline-warning"><i
                                                            class="bi bi-pencil"></i></button> {{-- Link para o menu de edição --}}
                                                </form>
                                                @if ($post->user_id === auth()->id())
                                                    <button type="button" class="btn mx-2 btn-outline-danger"
                                                        data-bs-toggle="modal" data-bs-target="#warning{{ $post->id }}">
                                                        {{-- Ativador do modal de exclusão --}}
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    <!-- Modal de exculsão do post -->
                                                    <div class="modal fade" id="warning{{ $post->id }}" tabindex="-1"
                                                        aria-labelledby="warningLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger text-white titulos">
                                                                    <h1 class="modal-title fs-5 fw-bold" id="warningLabel">Aviso!
                                                                        -
                                                                        Essa ação não pode ser desfeita!
                                                                    </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Tem certza que deseja apagar o post ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Fechar</button>

                                                                    <form action="/deletepost/{{ $post->id }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Sim</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
