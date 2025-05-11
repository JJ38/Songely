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
<body class="bg-lightgray font-hanken-grotesk min-h-screen">
    <div class="overflow-hidden flex flex-col min-h-screen">

        <nav class="flex justify-between pt-3 px-2 mb-3 sm:mb-0 sm:px-12 sm:pt-7">

            <div class="flex">
                <x-button id="home_button" class="hidden">Home</x-button>
            </div>

            {{-- <div class="flex gap-7">
                <x-button href="/register">Register</x-button>
                <x-button href="/login">Log In</x-button>
            </div> --}}

        </nav>
        <main class="flex flex-col flex-1">
            {{ $slot }}
        </main>

    </div>


</body>
</html>
