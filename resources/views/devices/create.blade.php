<x-layout title="Nouvel équipement">

    <x-page-header title="Nouvel équipement" subtitle="Enregistrer un matériel dans le parc.">
        <x-slot:actions>
            <a href="{{ route('devices.index') }}" class="btn btn-light">Annuler</a>
        </x-slot:actions>
    </x-page-header>

    <div class="surface-card">
        <div class="card-body">
            <form action="{{ route('devices.store') }}" method="POST">
                @include('devices._form')

                <hr class="my-4">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Créer l'équipement
                </button>
            </form>
        </div>
    </div>

</x-layout>
