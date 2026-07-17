@csrf
@isset($device)
    @method('PUT')
@endisset

<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Nom de l'équipement</label>
        <input type="text" name="nom" value="{{ old('nom', $device->nom ?? '') }}"
               class="form-control @error('nom') is-invalid @enderror">
        @error('nom')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Marque</label>
        <input type="text" name="marque" value="{{ old('marque', $device->marque ?? '') }}"
               class="form-control @error('marque') is-invalid @enderror">
        @error('marque')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Numéro de série</label>
        <input type="text" name="numero_serie" value="{{ old('numero_serie', $device->numero_serie ?? '') }}"
               class="form-control @error('numero_serie') is-invalid @enderror">
        @error('numero_serie')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">État</label>
        @php $etat = old('etat', $device->etat ?? ''); @endphp
        <select name="etat" class="form-select @error('etat') is-invalid @enderror">
            <option value="">-- Choisir --</option>
            <option value="neuf" @selected($etat === 'neuf')>Neuf</option>
            <option value="bon" @selected($etat === 'bon')>Bon</option>
            <option value="en panne" @selected($etat === 'en panne')>En panne</option>
        </select>
        @error('etat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Date d'achat</label>
        <input type="date" name="date_achat" value="{{ old('date_achat', $device->date_achat ?? '') }}"
               class="form-control @error('date_achat') is-invalid @enderror">
        @error('date_achat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Salle</label>
        @php $roomId = old('room_id', $device->room_id ?? ''); @endphp
        <select name="room_id" class="form-select @error('room_id') is-invalid @enderror">
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
        <label class="form-label">Description</label>
        <textarea name="description" rows="3"
                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $device->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label d-block">Catégories</label>
        {{-- Cases à cocher : le contrôleur fait un sync() sur la relation N-N --}}
        @php
            $selectedCategories = old('categories', isset($device) ? $device->categories->pluck('id')->toArray() : []);
        @endphp
        @foreach ($categories as $category)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="categories[]"
                       id="cat{{ $category->id }}" value="{{ $category->id }}"
                       @checked(in_array($category->id, $selectedCategories))>
                <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->nom }}</label>
            </div>
        @endforeach
        @error('categories')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

</div>

<hr class="my-4">
