<x-layout :title="$category->nom">

    <h1 class="h3 mb-4">Catégorie : {{ $category->nom }}</h1>

    <h2 class="h5 mb-3">Équipements dans cette catégorie</h2>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-3">Nom</th>
                        <th>Marque</th>
                        <th>État</th>
                        <th>Salle</th>
                        <th class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($category->devices as $device)
                        <tr>
                            <td class="ps-3">{{ $device->nom }}</td>
                            <td>{{ $device->marque }}</td>
                            <td><span class="badge bg-{{ $device->badge_color }}">{{ $device->etat }}</span></td>
                            <td>{{ $device->room->nom }}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('devices.show', $device) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Aucun équipement dans cette catégorie.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layout>
