<x-layout :title="$room->nom">

    <x-page-header :title="$room->nom" :subtitle="$room->batiment.' · '.$room->capacite.' places'">
        <x-slot:actions>
            <a href="{{ route('rooms.edit', $room) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1" aria-hidden="true"></i> Modifier
            </a>

            <a href="{{ route('rooms.confirm-destroy', $room) }}" class="btn btn-outline-danger">
                <i class="bi bi-trash3 me-1" aria-hidden="true"></i> Supprimer
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="surface-card">
        <div class="card-body">
            <h2 class="section-title">Équipements de cette salle</h2>
        </div>

        <div class="table-wrap">
            <table class="table table-hover app-table align-middle">
                <caption class="visually-hidden">Équipements de la salle {{ $room->nom }}</caption>

                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Marque</th>
                        <th scope="col" class="d-none d-md-table-cell">N° de série</th>
                        <th scope="col">État</th>
                        <th scope="col" class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($room->devices as $device)
                        <tr>
                            <td><a href="{{ route('devices.show', $device) }}">{{ $device->nom }}</a></td>
                            <td>{{ $device->marque }}</td>
                            <td class="d-none d-md-table-cell"><code>{{ $device->numero_serie }}</code></td>
                            <td>
                                <span class="badge-soft badge-soft-{{ $device->badge_color }}">
                                    {{ $device->etat_label }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('devices.show', $device) }}" class="icon-btn"
                                   title="Voir la fiche" aria-label="Voir la fiche de {{ $device->nom }}">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <span class="empty-icon" aria-hidden="true"><i class="bi bi-pc-display"></i></span>
                                    <p class="fw-bold">Salle vide</p>
                                    <p>Aucun équipement n'est rattaché à cette salle.</p>
                                    <a href="{{ route('devices.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Ajouter un équipement
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <p class="mt-4">
        <a href="{{ route('rooms.index') }}">&larr; Retour à la liste des salles</a>
    </p>

</x-layout>
