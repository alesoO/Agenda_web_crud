@extends('layout')
@section('title','Pagina Login')
@section("content")
<main>
    <div class="body_login">
        <div class="formulario w-100 m-auto">
            <form action="/login" method="post">
                @csrf
                <h1 class="h3 mb-3 fw-normal titulos fs-2">Login</h1>

                <div class="form-floating">
                    <input type="email" name="email" id="email" class="mt-4 rounded-0 rounded-top-3 form-control" placeholder="Nome do Diretor da Escola">
                    <label>Email</label>
                </div>

                <div class="form-floating">
                    <input type="password" name="password" id="password" class="mb-4 rounded-0 rounded-bottom-3 form-control" placeholder="Nome do Diretor da Escola">
                    <label>Senha</label>
                </div>

                <input type="submit" class="w-100 btn btn-lg btn-primary fs-4">
            </form>
        </div>
    </div>
</main>

@endsection