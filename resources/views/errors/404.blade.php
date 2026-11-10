{{-- Page d'erreur simple, sans dépendre de la base de données. --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page introuvable — {{ config('app.name', 'TechStock') }}</title>

    @vite(['resources/css/app.scss'])
</head>
<body>
    <main class="container py-5 text-center">
        <p class="display-4 fw-bold text-primary mb-0">404</p>
        <h1 class="h4 fw-bold mt-2 mb-3">Page introuvable</h1>
        <p class="text-muted mb-4">La page demandée n'existe pas ou a été déplacée.</p>

        <a href="{{ url('/') }}" class="btn btn-primary">Retour à l'accueil</a>
    </main>
</body>
</html>
