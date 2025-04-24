@props(['links' => [], 'scripts' => []])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @foreach ($links as $link)
        <link rel="stylesheet" href="{{ $link }}" />
    @endforeach

    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
   
    @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/js/game-controller.js'])

    <title>Songely</title>
</head>
<body class="flex flex-col bg-lightgray font-hanken-grotesk min-h-screen overflow-hidden">
    <nav class="flex justify-end pt-7 px-12">

        <div class="flex gap-7">
            <x-button href="/register">Register</x-button>
            <x-button href="/login">Log In</x-button>
        </div>
        
    </nav>
    <main class="flex flex-col flex-1">
        {{ $slot }}
    </main>
</body>
</html>