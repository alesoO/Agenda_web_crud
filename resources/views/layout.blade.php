
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield("title")</title>
        <!-- sass e javascript -->
        @vite(['resources/sass/app.scss','resources/js/app.js'])
    </head>
    <body>
        {{-- conteudo --}}
        @yield('content')
    </body>
    </html>