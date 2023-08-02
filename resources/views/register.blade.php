@extends('layout')
@section('title','Pagina Cadastro')
@section("content")
<main>
    <div class="body_login">
        <div class="formulario w-100 m-auto">
            <form action="/register" method="post">
                @csrf
                <h1 class="h3 mb-3 fw-normal titulos fs-2">Cadastre-se</h1>

                <div class="form-floating">
                    <input type="text" name="name" id="name" class="mt-4 rounded-0 rounded-top-3 form-control" placeholder="Nome">
                    <label>Nome</label>
                </div>

                <div class="form-floating">
                    <input type="email" name="email" id="email" class="rounded-0 form-control" placeholder="Email">
                    <label>Email</label>
                </div>

                <div class="form-floating">
                    <input type="password" name="password" id="password" class="mb-4 rounded-0 rounded-bottom-3 form-control" placeholder="Confirmação da Senha">
                    <label>Senha</label>
                </div>

                <input type="submit" class="w-100 btn btn-lg btn-primary titulos fs-4">
            </form>
        </div>
    </div>
</main>
@endsection