@props(['title' => 'TechStock'])

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} · {{ config('app.name', 'TechStock') }}</title>

    @vite(['resources/css/app.scss'])
</head>
<body>

<a href="#main-content" class="visually-hidden-focusable btn btn-primary position-absolute top-0 start-0 m-2">
    Aller au contenu principal
</a>

<header class="app-header">
    <nav class="container d-flex flex-wrap align-items-center justify-content-between gap-2 py-2"
         aria-label="Navigation principale">

        <a class="navbar-brand app-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <span class="brand-mark" aria-hidden="true"><i class="bi bi-hdd-stack"></i></span>
            {{ config('app.name', 'TechStock') }}
        </a>

        {{-- Navigation affichée en permanence (pas de menu déroulant : pas de JavaScript). --}}
        <ul class="navbar-nav app-nav flex-row flex-wrap gap-2 gap-md-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}"
                   @if (request()->routeIs('dashboard')) aria-current="page" @endif>
                    Tableau de bord
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('devices.*') ? 'active' : '' }}"
                   href="{{ route('devices.index') }}"
                   @if (request()->routeIs('devices.*')) aria-current="page" @endif>
                    Équipements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}"
                   href="{{ route('rooms.index') }}"
                   @if (request()->routeIs('rooms.*')) aria-current="page" @endif>
                    Salles
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                   href="{{ route('categories.index') }}"
                   @if (request()->routeIs('categories.*')) aria-current="page" @endif>
                    Catégories
                </a>
            </li>
        </ul>
    </nav>
</header>

<main id="main-content" class="container py-4">

    @if (session('success'))
        <div class="alert alert-success" role="status">
            <i class="bi bi-check-circle me-1" aria-hidden="true"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle me-1" aria-hidden="true"></i> {{ session('error') }}
        </div>
    @endif

    {{ $slot }}

</main>

<footer class="app-footer py-3">
    <div class="container text-center">
        {{ config('app.name', 'TechStock') }} — Gestion du parc informatique
    </div>
</footer>

</body>
</html>
