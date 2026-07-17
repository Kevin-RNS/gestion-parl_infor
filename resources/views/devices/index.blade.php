<x-layout title="Équipements">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Équipements</h1>
        <a href="{{ route('devices.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouvel équipement
        </a>
    </div>

    {{--recherche par nom ou marque --}}
    <form method="GET" action="{{ route('devices.index') }}" class="row g-2 mb-3">
        <div class="col-auto flex-grow-1">
            <input type="text" name="search" value="{{ $search }}" class="form-control"
                   placeholder="Rechercher par nom ou marque...">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="bi bi-search"></i> Rechercher</button>
        </div>
        @if($search)
            <div class="col-auto">
                <a href="{{ route('devices.index') }}" class="btn btn-outline-danger">
                    <i class="bi bi-x-lg"></i> Réinitialiser
                </a>
            </div>
        @endif
    </form>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-3">Nom</th>
                        <th>Marque</th>
                        <th>N° série</th>
                        <th>État</th>
                        <th>Salle</th>
                        <th>Catégories</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                
                    @forelse ($devices as $device)
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('devices.show', $device) }}" class="text-decoration-none fw-semibold">
                                    {{ $device->nom }}
                                </a>
                            </td>
                            <td>{{ $device->marque }}</td>
                            <td><code>{{ $device->numero_serie }}</code></td>
                            <td>
                                {{--badge de couleur selon l'état --}}
                                <span class="badge bg-{{ $device->badge_color }}">{{ $device->etat }}</span>
                            </td>
                            <td>
                                <a href="{{ route('rooms.show', $device->room) }}">{{ $device->room->nom }}</a>
                            </td>
                            <td>
                                @foreach ($device->categories as $category)
                                    <a href="{{ route('categories.show', $category) }}" class="badge bg-secondary text-decoration-none">
                                        {{ $category->nom }}
                                    </a>
                                @endforeach
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('devices.show', $device) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('devices.edit', $device) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('devices.destroy', $device) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Supprimer cet équipement ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Aucun équipement trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $devices->links() }}
    </div>

</x-layout>
