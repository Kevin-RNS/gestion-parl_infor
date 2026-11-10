<x-layout :title="'Modifier '.$device->nom">

    <x-page-header :title="'Modifier '.$device->nom" subtitle="Mettre à jour la fiche de l'équipement.">
        <x-slot:actions>
            <a href="{{ route('devices.show', $device) }}" class="btn btn-light">Annuler</a>
        </x-slot:actions>
    </x-page-header>

    <div class="surface-card">
        <div class="card-body">
            <form action="{{ route('devices.update', $device) }}" method="POST">
                @include('devices._form')

                <hr class="my-4">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>

</x-layout>
