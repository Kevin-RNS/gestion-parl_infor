<x-layout :title="$device->nom">

    <x-page-header :title="$device->nom"
                   :subtitle="$device->marque.' · '.$device->numero_serie">
        <x-slot:actions>
            <a href="{{ route('devices.edit', $device) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1" aria-hidden="true"></i> Modifier
            </a>

            <a href="{{ route('devices.confirm-destroy', $device) }}" class="btn btn-outline-danger">
                <i class="bi bi-trash3 me-1" aria-hidden="true"></i> Supprimer
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="mb-3">
        <span class="badge-soft badge-soft-{{ $device->badge_color }}">{{ $device->etat_label }}</span>

        @foreach ($device->categories as $category)
            <a href="{{ route('categories.show', $category) }}" class="badge-soft badge-soft-secondary">
                {{ $category->nom }}
            </a>
        @endforeach
    </div>

    <div class="row g-4">

        {{-- Informations --}}
        <div class="col-lg-5">
            <div class="surface-card">
                <div class="card-body">
                    <h2 class="section-title">Informations</h2>

                    <dl class="row mb-0">
                        <dt class="col-5">Marque</dt>
                        <dd class="col-7">{{ $device->marque }}</dd>

                        <dt class="col-5">N° de série</dt>
                        <dd class="col-7"><code>{{ $device->numero_serie }}</code></dd>

                        <dt class="col-5">Date d'achat</dt>
                        <dd class="col-7">{{ $device->date_achat->format('d/m/Y') }}</dd>

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

        {{-- Interventions --}}
        <div class="col-lg-7">

            <div class="surface-card mb-4">
                <div class="card-body">
                    <h2 class="section-title">Historique des interventions</h2>

                    @forelse ($device->interventions->sortByDesc('date') as $intervention)
                        <div class="border-bottom py-2">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $intervention->type_label }}</strong>
                                <span class="text-muted small">{{ $intervention->date->format('d/m/Y') }}</span>
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

            <div class="surface-card">
                <div class="card-body">
                    <h2 class="section-title">Ajouter une intervention</h2>

                    <form action="{{ route('interventions.store', $device) }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" id="date" name="date"
                                       value="{{ old('date', now()->format('Y-m-d')) }}"
                                       class="form-control @error('date') is-invalid @enderror">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="type" class="form-label">Type</label>
                                <select id="type" name="type" class="form-select @error('type') is-invalid @enderror">
                                    <option value="">-- Choisir --</option>
                                    @foreach (App\Models\Intervention::TYPES as $value => $label)
                                        <option value="{{ $value }}" @selected(old('type') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Ajouter
                                </button>
                            </div>

                            <div class="col-12">
                                <label for="commentaire" class="form-label">Commentaire</label>
                                <textarea id="commentaire" name="commentaire" rows="2"
                                          class="form-control @error('commentaire') is-invalid @enderror">{{ old('commentaire') }}</textarea>
                                @error('commentaire')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <p class="mt-4">
        <a href="{{ route('devices.index') }}">&larr; Retour à la liste des équipements</a>
    </p>

</x-layout>
