<x-layout title="Salles">

    <x-page-header title="Salles" subtitle="Les espaces du parc et le matériel qu'ils abritent.">
        <x-slot:actions>
            <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nouvelle salle
            </a>
        </x-slot:actions>
    </x-page-header>

    @if ($rooms->isEmpty())
        <div class="surface-card">
            <div class="empty-state">
                <span class="empty-icon" aria-hidden="true"><i class="bi bi-door-open"></i></span>
                <p class="fw-bold">Aucune salle enregistrée</p>
                <p>Les salles permettent de regrouper les équipements.</p>
                <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nouvelle salle
                </a>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach ($rooms as $room)
                <div class="col-md-6 col-xl-4">
                    <a href="{{ route('rooms.show', $room) }}" class="text-decoration-none text-body">
                        <div class="surface-card h-100 p-3">
                            <h2 class="h6 fw-bold mb-1">{{ $room->nom }}</h2>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-building me-1" aria-hidden="true"></i>{{ $room->batiment }}
                            </p>
                            <span class="badge-soft badge-soft-primary">
                                {{ $room->devices_count }} équipement(s)
                            </span>
                            <span class="text-muted small ms-2">
                                {{ $room->capacite }} places
                            </span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

</x-layout>
