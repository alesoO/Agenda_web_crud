@extends('layout')
@section('title', 'Pagina home')
@section('content')
    <main>
        <div class="container-sm">
            <div class="container  pt-5">
                <h2 class="border-bottom border-primary titulos">Posts</h2>
            </div>
            <div class="row row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2 mt-5">
                @foreach ($posts as $post)
                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="bd-placeholder-img card-img-top" width="100%" height="250px"
                                src="{{ asset($post->imagem) }}" />
                            <div class="card-body">
                                <h4 class="titulo-card">{{ $post['title'] }}</h4>
                                <p class="card-text">{{ $post['body'] }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-body-secondary">{{ $post['updated_at'] }}</small>
                                    <div class="btn-group d-flex">
                                        <form action="/editpost/{{ $post->id }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn btn-outline-warning rounded-0 rounded-start"><i
                                                    class="bi bi-pencil"></i></button>
                                        </form>

                                        <form action="/deletpost/{{ $post->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger rounded-0 rounded-end"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </main>

@endsection
