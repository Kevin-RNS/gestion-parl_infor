@csrf
@isset($room)
    @method('PUT')
@endisset

<div class="row g-3">

    <div class="col-md-6">
        <label for="nom" class="form-label">Nom de la salle</label>
        <input type="text" id="nom" name="nom" value="{{ old('nom', $room->nom ?? '') }}"
               class="form-control @error('nom') is-invalid @enderror" maxlength="100">
        @error('nom')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="batiment" class="form-label">Bâtiment</label>
        <input type="text" id="batiment" name="batiment" value="{{ old('batiment', $room->batiment ?? '') }}"
               class="form-control @error('batiment') is-invalid @enderror" maxlength="100">
        @error('batiment')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="capacite" class="form-label">Capacité</label>
        <input type="number" id="capacite" name="capacite"
               value="{{ old('capacite', $room->capacite ?? '') }}"
               class="form-control @error('capacite') is-invalid @enderror" min="1" max="1000">
        <div class="form-text">Nombre de postes dans la salle.</div>
        @error('capacite')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
