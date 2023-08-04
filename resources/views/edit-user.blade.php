{{-- Import do layout --}}
@extends('layout')
{{-- Declaração do titulo da pagina --}}
@section('title','Edição de Cadastro')
{{-- Declarção do conteudo da pagina --}}
@section("content")
<main>
    <div class="body_login">
        {{-- Formulario de Edição --}}
        <div class="formulario w-100 m-auto">
            <form action="/edituser/{{$user->id}}" method="post">
                @csrf
                @method('PUT')
                <h1 class="h3 mb-3 fw-normal titulos fs-2">Edição de Cadastro</h1>

                <div class="form-floating">
                    <input type="text" name="name" id="name" class="mt-4 rounded-0 rounded-top-3 form-control" placeholder="Nome" value="{{$user->name}} {{-- Recupera o valor do banco de dados --}}">
                    <label>Nome</label>
                </div>

                <div class="form-floating">
                    <input type="email" name="email" id="email" class="mb-4 rounded-0 rounded-bottom-3 form-control" placeholder="Email" value="{{$user->email}} {{-- Recupera o valor do banco de dados --}}">
                    <label>Email</label>
                </div>

                <h3 class="h3 mb-3 fw-normal titulos fs-2">Digite sua senha: </h3>
                {{-- Senha para a confirmação da edição --}}
                <div class="form-floating">
                    <input type="password" name="password" id="password" class="mb-4 form-control" placeholder="Confirmação da Senha">
                    <label>Senha</label>
                </div>

                <input type="submit" class="w-100 btn btn-lg btn-primary titulos fs-4">
            </form>
        </div>
    </div>
</main>
@endsection