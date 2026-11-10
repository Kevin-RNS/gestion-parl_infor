<x-layout :title="'Modifier '.$room->nom">

    <x-page-header :title="'Modifier '.$room->nom" subtitle="Mettre à jour les informations de la salle.">
        <x-slot:actions>
            <a href="{{ route('rooms.show', $room) }}" class="btn btn-light">Annuler</a>
        </x-slot:actions>
    </x-page-header>

    <div class="surface-card">
        <div class="card-body">
            <form action="{{ route('rooms.update', $room) }}" method="POST">
                @include('rooms._form')

                <hr class="my-4">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>

</x-layout>
