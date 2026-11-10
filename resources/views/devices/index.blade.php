<x-layout title="Équipements">

    <x-page-header title="Équipements" subtitle="Le matériel du parc et son état.">
        <x-slot:actions>
            <a href="{{ route('devices.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nouvel équipement
            </a>
        </x-slot:actions>
    </x-page-header>

    {{-- Recherche et filtres --}}
    <form method="GET" action="{{ route('devices.index') }}" class="surface-card p-3 mb-3">
        <div class="row g-2">

            <div class="col-12 col-md-4">
                <label for="search" class="form-label">Rechercher</label>
                <input type="search" id="search" name="search" value="{{ $search }}"
                       class="form-control" placeholder="Nom, marque ou n° de série">
            </div>

            <div class="col-6 col-md-3">
                <label for="etat" class="form-label">État</label>
                <select id="etat" name="etat" class="form-select">
                    <option value="">Tous les états</option>
                    @foreach (App\Models\Device::ETATS as $value => $label)
                        <option value="{{ $value }}" @selected($etat === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-3">
                <label for="room_id" class="form-label">Salle</label>
                <select id="room_id" name="room_id" class="form-select">
                    <option value="">Toutes les salles</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" @selected((string) $roomId === (string) $room->id)>
                            {{ $room->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-2 d-flex gap-2 align-items-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1" aria-hidden="true"></i> Filtrer
                </button>

                @if ($search || $etat || $roomId)
                    <a href="{{ route('devices.index') }}" class="btn btn-light">Réinitialiser</a>
                @endif
            </div>
        </div>
    </form>

    <p class="text-muted small">
        {{ $devices->total() }} équipement(s) trouvé(s).
    </p>

    <div class="surface-card">
        <div class="table-wrap">
            <table class="table table-hover app-table align-middle">
                <caption class="visually-hidden">Liste des équipements</caption>

                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Marque</th>
                        <th scope="col" class="d-none d-lg-table-cell">N° de série</th>
                        <th scope="col">État</th>
                        <th scope="col" class="d-none d-md-table-cell">Salle</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($devices as $device)
                        <tr>
                            <td>
                                <a href="{{ route('devices.show', $device) }}">{{ $device->nom }}</a>
                            </td>
                            <td>{{ $device->marque }}</td>
                            <td class="d-none d-lg-table-cell"><code>{{ $device->numero_serie }}</code></td>
                            <td>
                                <span class="badge-soft badge-soft-{{ $device->badge_color }}">
                                    {{ $device->etat_label }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <a href="{{ route('rooms.show', $device->room) }}">{{ $device->room->nom }}</a>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('devices.show', $device) }}" class="icon-btn"
                                       title="Voir la fiche" aria-label="Voir la fiche de {{ $device->nom }}">
                                        <i class="bi bi-eye" aria-hidden="true"></i>
                                    </a>

                                    <a href="{{ route('devices.edit', $device) }}" class="icon-btn"
                                       title="Modifier" aria-label="Modifier {{ $device->nom }}">
                                        <i class="bi bi-pencil" aria-hidden="true"></i>
                                    </a>

                                    <a href="{{ route('devices.confirm-destroy', $device) }}" class="icon-btn icon-btn-danger"
                                       title="Supprimer" aria-label="Supprimer {{ $device->nom }}">
                                        <i class="bi bi-trash3" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <span class="empty-icon" aria-hidden="true"><i class="bi bi-pc-display"></i></span>
                                    <p class="fw-bold">Aucun équipement trouvé</p>
                                    <p>
                                        @if ($search || $etat || $roomId)
                                            Aucun équipement ne correspond à votre recherche.
                                            <a href="{{ route('devices.index') }}">Réinitialiser les filtres</a>.
                                        @else
                                            Commencez par enregistrer votre premier équipement.
                                        @endif
                                    </p>
                                    <a href="{{ route('devices.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nouvel équipement
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($devices->hasPages())
        <div class="mt-3">
            {{ $devices->links() }}
        </div>
    @endif

</x-layout>
