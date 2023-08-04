{{-- Import do layout --}}
@extends('layout')
{{-- Declaração do titulo da pagina --}}
@section('title', 'Novo Post')
{{-- Declarção do conteudo da pagina --}}
@section('content')

    <div class="body_login">
        <div class="formulario w-100 m-auto">
            {{-- Formulario de Adição de post --}}
            <form enctype="multipart/form-data" action="/createpost" method="post">
                @csrf
                <h1 class="h3 mb-3 fw-normal titulos fs-2">Novo Post</h1>

                <input name="imagem" id="imagem" class="btn btn-outline-secondary rounded-0 rounded-3 form-control"
                    type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                <input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
                <label for="imageUpload"></label>

                <div class="form-floating">
                    <input type="text" name="title" id="title" class="rounded-0 rounded-top-3 form-control"
                        placeholder="Titulo do Post">
                    <label>Titulo do Post</label>
                </div>

                <div class="form-floating">
                    <textarea name="body" id="body" class="mb-4 rounded-0 rounded-bottom-3 form-control"
                        placeholder="Texto do Post"></textarea>
                    <label>Texto do Post</label>
                </div>

                <input type="submit" class="w-100 btn btn-lg btn-primary">
            </form>
        </div>
    </div>
@endsection
