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

                <input name="image" id="image" class="btn btn-outline-secondary rounded-0 rounded-3 form-control"
                    type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                <input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
                <label for="imageUpload"></label>

                <div class="form-floating">
                    <input type="text" name="title" id="title" class="rounded-0 rounded-top-3 form-control"
                        placeholder="Titulo do Post">
                    <label>Titulo do Post</label>
                </div>

                <div class="form-floating">
                    <textarea name="body" id="body" class="mb-2 rounded-0 rounded-bottom-3 form-control"
                        placeholder="Texto do Post"></textarea>
                    <label>Texto do Post</label>
                </div>

                <div class="form-check form-switch d-flex checkbox-lg ms-2 my-3 align-items-center">
                    <input class="form-check-input align-content-center me-4" name="multiple_authors" type="checkbox"
                        role="switch" id="flexSwitchCheckDefault" value="1">
                    <label class="form-check-label align-content-center titulos mt-2 fs-4"
                        for="flexSwitchCheckDefault">Multiplos Autores</label>
                </div>

                <div id="fieldAuthors" style="display: none;">
                    <!-- Coloque aqui os campos adicionais que deseja exibir -->
                    <div class="d-flex justify-content-between align-items-center mt-2 mb-1">
                        <h2 class="h3 mb-2 fw-normal titulos fs-2 justfy-content-center">Outros Autores</h2>
                        <button type="button" id="addEmailField" class="btn btn-light"><i
                                class="fs-3 bi bi-plus-lg"></i></button>
                    </div>
                    <hr class="mt-0">
                    <div id="emailFieldsContainer">
                        <div class="form-floating email-field">
                            <input type="text" name="emailAuthor2" id="emailAuthor2" class="mb-3 form-control"
                                placeholder="Email do 2° Autor">
                            <label>Email do 2° Autor</label>
                        </div>
                    </div>
                    <div class="form-floating email-field align-items-center" style="display: none">
                        <input type="text" name="emailAuthor3" id="emailAuthor3" class="mb-3 form-control"
                            placeholder="Email do 3° Autor">
                        <label>Email do 3° Autor</label>
                        <button type="button" class="remove-email-field fs-4 ms-3 mb-3 btn-close"
                            aria-label="Close"></button>
                    </div>
                    <div class="form-floating email-field align-items-center" style="display: none">
                        <input type="text" name="emailAuthor4" id="emailAuthor4" class="mb-3 form-control"
                            placeholder="Email do 4° Autor">
                        <label>Email do 4° Autor</label>
                        <button type="button" class="remove-email-field fs-4 ms-3 mb-3 btn-close"
                            aria-label="Close"></button>
                    </div>
                    <div class="form-floating email-field align-items-center" style="display: none">
                        <input type="text" name="emailAuthor5" id="emailAuthor5" class="mb-3 form-control"
                            placeholder="Email do 5° Autor">
                        <label>Email do 5° Autor</label>
                        <button type="button" class="remove-email-field fs-4 ms-3 mb-3 btn-close"
                            aria-label="Close"></button>
                    </div>
                    <div class="form-floating email-field align-items-center" style="display: none">
                        <input type="text" name="emailAuthor6" id="emailAuthor6" class="mb-3 form-control"
                            placeholder="Email do 6° Autor">
                        <label>Email do 6° Autor</label>
                        <button type="button" class="remove-email-field fs-4 ms-3 mb-3 btn-close"
                            aria-label="Close"></button>
                    </div>
                </div>
                <input type="submit" class="mt-2 w-100 btn btn-lg btn-primary">
            </form>
        </div>
    </div>
@endsection
