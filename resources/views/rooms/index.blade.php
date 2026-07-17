<x-layout title="Salles">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Salles</h1>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouvelle salle
        </a>
    </div>

    <div class="row g-3">
        @forelse ($rooms as $room)
            <div class="col-md-4">
                <a href="{{ route('rooms.show', $room) }}" class="text-decoration-none text-dark">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="h5">{{ $room->nom }}</h2>
                            <p class="text-muted mb-1"><i class="bi bi-building"></i> {{ $room->batiment }}</p>
                            <p class="text-muted mb-1"><i class="bi bi-people"></i> Capacité : {{ $room->capacite }}</p>
                            {{-- Bonus : nombre d'équipements par salle --}}
                            <span class="badge bg-primary">{{ $room->devices_count }} équipement(s)</span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-muted">Aucune salle enregistrée pour le moment.</p>
        @endforelse
    </div>

</x-layout>
