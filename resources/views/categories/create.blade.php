<x-layout title="Nouvelle catégorie">

    <h1 class="h3 mb-4">Nouvelle catégorie</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nom de la catégorie</label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="form-control @error('nom') is-invalid @enderror">
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Créer la catégorie
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>

</x-layout>
