<x-layout :title="$category->nom">

    <x-page-header :title="$category->nom" subtitle="Équipements rattachés à cette catégorie.">
        <x-slot:actions>
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1" aria-hidden="true"></i> Modifier
            </a>

            <a href="{{ route('categories.confirm-destroy', $category) }}" class="btn btn-outline-danger">
                <i class="bi bi-trash3 me-1" aria-hidden="true"></i> Supprimer
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="surface-card">
        <div class="card-body">
            <h2 class="section-title">Équipements dans cette catégorie</h2>
        </div>

        <div class="table-wrap">
            <table class="table table-hover app-table align-middle">
                <caption class="visually-hidden">Équipements de la catégorie {{ $category->nom }}</caption>

                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Marque</th>
                        <th scope="col" class="d-none d-md-table-cell">N° de série</th>
                        <th scope="col">État</th>
                        <th scope="col" class="d-none d-lg-table-cell">Salle</th>
                        <th scope="col" class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($category->devices as $device)
                        <tr>
                            <td><a href="{{ route('devices.show', $device) }}">{{ $device->nom }}</a></td>
                            <td>{{ $device->marque }}</td>
                            <td class="d-none d-md-table-cell"><code>{{ $device->numero_serie }}</code></td>
                            <td>
                                <span class="badge-soft badge-soft-{{ $device->badge_color }}">
                                    {{ $device->etat_label }}
                                </span>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <a href="{{ route('rooms.show', $device->room) }}">{{ $device->room->nom }}</a>
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
                            <td colspan="6">
                                <div class="empty-state">
                                    <span class="empty-icon" aria-hidden="true"><i class="bi bi-tags"></i></span>
                                    <p class="fw-bold">Catégorie vide</p>
                                    <p>Aucun équipement n'est rattaché à cette catégorie.</p>
                                    <a href="{{ route('devices.index') }}" class="btn btn-primary">
                                        Voir les équipements
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
        <a href="{{ route('categories.index') }}">&larr; Retour à la liste des catégories</a>
    </p>

</x-layout>
