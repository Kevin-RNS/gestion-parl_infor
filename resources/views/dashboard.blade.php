<x-layout title="Tableau de bord">

    <x-page-header title="Tableau de bord" subtitle="Vue d'ensemble du parc informatique.">
        <x-slot:actions>
            <a href="{{ route('devices.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nouvel équipement
            </a>
        </x-slot:actions>
    </x-page-header>

    {{-- Indicateurs --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-value">{{ $total }}</div>
                <div class="stat-label">Équipements</div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-value">{{ $enPanne }}</div>
                <div class="stat-label">En panne</div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-value">{{ $totalSalles }}</div>
                <div class="stat-label">Salles</div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-value">{{ $totalInterventions }}</div>
                <div class="stat-label">Interventions</div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- Dernières interventions --}}
        <div class="col-lg-7">
            <div class="surface-card">
                <div class="card-body">
                    <h2 class="section-title">Dernières interventions</h2>

                    @forelse ($interventions as $intervention)
                        <div class="border-bottom py-2">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('devices.show', $intervention->device) }}">
                                    {{ $intervention->device->nom }}
                                </a>
                                <span class="text-muted small">{{ $intervention->date->format('d/m/Y') }}</span>
                            </div>
                            <div class="small text-muted">
                                {{ $intervention->type_label }}
                                @if ($intervention->commentaire)
                                    — {{ $intervention->commentaire }}
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Aucune intervention enregistrée.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Salles --}}
        <div class="col-lg-5">
            <div class="surface-card">
                <div class="card-body">
                    <h2 class="section-title">Salles</h2>

                    @forelse ($salles as $room)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <a href="{{ route('rooms.show', $room) }}">{{ $room->nom }}</a>
                            <span class="text-muted small">{{ $room->devices_count }} équipement(s)</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Aucune salle enregistrée.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</x-layout>
