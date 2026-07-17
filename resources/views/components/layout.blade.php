@props(['title' => 'TechStock'])

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: .5px;
        }
        .card {
            border: none;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }
        .table thead th {
            font-size: .8rem;
            text-transform: uppercase;
            color: #6c757d;
            border-bottom-width: 1px;
        }
        footer {
            color: #adb5bd;
            font-size: .85rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('devices.index') }}">
            <i class="bi bi-hdd-stack"></i> TechStock
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('devices.*') ? 'active fw-bold' : '' }}" href="{{ route('devices.index') }}">
                        <i class="bi bi-pc-display"></i> Équipements
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('rooms.*') ? 'active fw-bold' : '' }}" href="{{ route('rooms.index') }}">
                        <i class="bi bi-door-open"></i> Salles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active fw-bold' : '' }}" href="{{ route('categories.index') }}">
                        <i class="bi bi-tags"></i> Catégories
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mb-5">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{ $slot }}

</div>

<footer class="text-center py-3">
    TechStock 
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
