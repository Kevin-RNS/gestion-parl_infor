<x-layout title="Catégories">

    <x-page-header title="Catégories" subtitle="Les types de matériel utilisés dans le parc.">
        <x-slot:actions>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nouvelle catégorie
            </a>
        </x-slot:actions>
    </x-page-header>

    @if ($categories->isEmpty())
        <div class="surface-card">
            <div class="empty-state">
                <span class="empty-icon" aria-hidden="true"><i class="bi bi-tags"></i></span>
                <p class="fw-bold">Aucune catégorie enregistrée</p>
                <p>Les catégories permettent de regrouper les équipements par type.</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nouvelle catégorie
                </a>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach ($categories as $category)
                <div class="col-6 col-md-4 col-xl-3">
                    <a href="{{ route('categories.show', $category) }}" class="text-decoration-none text-body">
                        <div class="surface-card h-100 p-3 text-center">
                            <i class="bi bi-tag fs-3 text-primary" aria-hidden="true"></i>
                            <h2 class="h6 fw-bold my-2">{{ $category->nom }}</h2>
                            <span class="badge-soft badge-soft-primary">
                                {{ $category->devices_count }} équipement(s)
                            </span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

</x-layout>
