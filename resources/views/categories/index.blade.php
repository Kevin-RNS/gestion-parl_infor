<x-layout title="Catégories">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Catégories</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouvelle catégorie
        </a>
    </div>

    <div class="row g-3">
        @forelse ($categories as $category)
            <div class="col-md-3">
                <a href="{{ route('categories.show', $category) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="bi bi-tag fs-3 text-primary"></i>
                            <h2 class="h5 mt-2">{{ $category->nom }}</h2>
                            {{-- Bonus : nombre d'équipements par catégorie --}}
                            <span class="badge bg-primary">{{ $category->devices_count }} équipement(s)</span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-muted">Aucune catégorie enregistrée pour le moment.</p>
        @endforelse
    </div>

</x-layout>
