<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <style>
        body {
            background-image: url('/images/backgrounds/foto2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }
        .main-content {
            padding-top: 70px;
        }
    </style>
</head>
<body class="relative">
<x-main-navigation />

<main class="main-content">
    <!-- Aquí va el contenido principal de tu página -->
    <div class="container mx-auto py-6 px-6">
        <h1 class="text-3xl font-bold text-white">Anuncios</h1>
        @foreach($advertisements as $advertisement)
            <div class="bg-white p-4 rounded shadow mb-4">
                <h2 class="text-xl font-bold">{{ $advertisement->title }}</h2>
                <p>{{ $advertisement->description }}</p>
            </div>
        @endforeach
    </div>
</main>

@stack('scripts')
</body>
</html>
