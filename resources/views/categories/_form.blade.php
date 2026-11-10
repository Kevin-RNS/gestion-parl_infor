@csrf
@isset($category)
    @method('PUT')
@endisset

<div class="row g-3">
    <div class="col-md-8">
        <label for="nom" class="form-label">Nom de la catégorie</label>
        <input type="text" id="nom" name="nom" value="{{ old('nom', $category->nom ?? '') }}"
               class="form-control @error('nom') is-invalid @enderror" maxlength="100">
        <div class="form-text">Le nom doit être unique.</div>
        @error('nom')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
