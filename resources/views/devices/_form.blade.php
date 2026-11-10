@csrf
@isset($device)
    @method('PUT')
@endisset

@php
    // Catégories cochées : on garde la saisie si la validation échoue.
    $selected = array_map('intval', (array) old('categories', isset($device) ? $device->categories->pluck('id')->all() : []));
@endphp

<div class="row g-3">

    <div class="col-md-6">
        <label for="nom" class="form-label">Nom de l'équipement</label>
        <input type="text" id="nom" name="nom" value="{{ old('nom', $device->nom ?? '') }}"
               class="form-control @error('nom') is-invalid @enderror" maxlength="100">
        @error('nom')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="marque" class="form-label">Marque</label>
        <input type="text" id="marque" name="marque" value="{{ old('marque', $device->marque ?? '') }}"
               class="form-control @error('marque') is-invalid @enderror" maxlength="100">
        @error('marque')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="numero_serie" class="form-label">Numéro de série</label>
        <input type="text" id="numero_serie" name="numero_serie"
               value="{{ old('numero_serie', $device->numero_serie ?? '') }}"
               class="form-control @error('numero_serie') is-invalid @enderror" maxlength="50">
        <div class="form-text">Ce numéro doit être unique dans le parc.</div>
        @error('numero_serie')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="etat" class="form-label">État</label>
        @php $etat = old('etat', $device->etat ?? ''); @endphp
        <select id="etat" name="etat" class="form-select @error('etat') is-invalid @enderror">
            <option value="">-- Choisir --</option>
            @foreach (App\Models\Device::ETATS as $value => $label)
                <option value="{{ $value }}" @selected($etat === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('etat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="date_achat" class="form-label">Date d'achat</label>
        <input type="date" id="date_achat" name="date_achat"
               value="{{ old('date_achat', isset($device) && $device->date_achat ? $device->date_achat->format('Y-m-d') : '') }}"
               class="form-control @error('date_achat') is-invalid @enderror">
        @error('date_achat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="room_id" class="form-label">Salle</label>
        @php $roomId = old('room_id', $device->room_id ?? ''); @endphp
        <select id="room_id" name="room_id" class="form-select @error('room_id') is-invalid @enderror">
            <option value="">-- Choisir une salle --</option>
            @foreach ($rooms as $room)
                <option value="{{ $room->id }}" @selected((string) $roomId === (string) $room->id)>
                    {{ $room->nom }} ({{ $room->batiment }})
                </option>
            @endforeach
        </select>
        @error('room_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" rows="3"
                  class="form-control @error('description') is-invalid @enderror" maxlength="1000">{{ old('description', $device->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <span class="form-label d-block">Catégories</span>

        <div class="d-flex flex-wrap gap-3">
            @forelse ($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categories[]"
                           id="cat{{ $category->id }}" value="{{ $category->id }}"
                           @checked(in_array((int) $category->id, $selected, true))>
                    <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->nom }}</label>
                </div>
            @empty
                <span class="text-muted small">
                    Aucune catégorie — <a href="{{ route('categories.create') }}">en créer une</a>.
                </span>
            @endforelse
        </div>

        @error('categories')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>
