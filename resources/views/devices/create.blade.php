<x-layout title="Nouvel équipement">

    <h1 class="h3 mb-4">Nouvel équipement</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('devices.store') }}" method="POST">
                @include('devices._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Créer l'équipement
                </button>
                <a href="{{ route('devices.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>

</x-layout>
