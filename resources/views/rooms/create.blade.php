<x-layout title="Nouvelle salle">

    <h1 class="h3 mb-4">Nouvelle salle</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nom de la salle</label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="form-control @error('nom') is-invalid @enderror">
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Bâtiment</label>
                    <input type="text" name="batiment" value="{{ old('batiment') }}"
                           class="form-control @error('batiment') is-invalid @enderror">
                    @error('batiment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Capacité</label>
                    <input type="number" name="capacite" value="{{ old('capacite') }}" min="1"
                             class="form-control @error('capacite') is-invalid @enderror">
                    @error('capacite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Créer la salle
                </button>
                <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>

</x-layout>
