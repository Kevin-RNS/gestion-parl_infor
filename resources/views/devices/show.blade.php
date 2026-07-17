<x-layout :title="$device->nom">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $device->nom }}</h1>
            <span class="badge bg-{{ $device->badge_color }}">{{ $device->etat }}</span>
            @foreach ($device->categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="badge bg-secondary text-decoration-none">
                    {{ $category->nom }}
                </a>
            @endforeach
        </div>
        <div>
            <a href="{{ route('devices.edit', $device) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <form action="{{ route('devices.destroy', $device) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Supprimer cet équipement ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="h6 text-muted">Informations</h2>
                    <dl class="row mb-0">
                        <dt class="col-5">Marque</dt>
                        <dd class="col-7">{{ $device->marque }}</dd>

                        <dt class="col-5">N° de série</dt>
                        <dd class="col-7"><code>{{ $device->numero_serie }}</code></dd>

                        <dt class="col-5">Date d'achat</dt>
                        <dd class="col-7">{{ \Carbon\Carbon::parse($device->date_achat)->format('d/m/Y') }}</dd>

                        <dt class="col-5">Salle</dt>
                        <dd class="col-7">
                            <a href="{{ route('rooms.show', $device->room) }}">{{ $device->room->nom }}</a>
                        </dd>

                        @if ($device->description)
                            <dt class="col-5">Description</dt>
                            <dd class="col-7">{{ $device->description }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="h6 text-muted">Historique des interventions</h2>

                    @forelse ($device->interventions->sortByDesc('date') as $intervention)
                        <div class="border-bottom py-2">
                            <div class="d-flex justify-content-between">
                                <strong>{{ ucfirst($intervention->type) }}</strong>
                                <span class="text-muted small">
                                    {{ \Carbon\Carbon::parse($intervention->date)->format('d/m/Y') }}
                                </span>
                            </div>
                            @if ($intervention->commentaire)
                                <div class="small text-muted">{{ $intervention->commentaire }}</div>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted mb-0">Aucune intervention enregistrée.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2 class="h6 text-muted">Ajouter une intervention</h2>
                    <form action="{{ route('interventions.store', $device) }}" method="POST" class="row g-2">
                        @csrf
                        <div class="col-md-4">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" value="{{ old('date') }}"
                                   class="form-control @error('date') is-invalid @enderror">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror">
                                <option value="">-- Choisir --</option>
                                <option value="maintenance" @selected(old('type') === 'maintenance')>Maintenance</option>
                                <option value="panne" @selected(old('type') === 'panne')>Panne</option>
                                <option value="reparation" @selected(old('type') === 'reparation')>Réparation</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-lg"></i> Ajouter
                            </button>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Commentaire</label>
                            <textarea name="commentaire" rows="2"
                                      class="form-control @error('commentaire') is-invalid @enderror">{{ old('commentaire') }}</textarea>
                            @error('commentaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layout>
