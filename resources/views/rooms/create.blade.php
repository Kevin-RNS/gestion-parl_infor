<x-layout title="Nouvelle salle">

    <x-page-header title="Nouvelle salle" subtitle="Créer un espace dans le parc.">
        <x-slot:actions>
            <a href="{{ route('rooms.index') }}" class="btn btn-light">Annuler</a>
        </x-slot:actions>
    </x-page-header>

    <div class="surface-card">
        <div class="card-body">
            <form action="{{ route('rooms.store') }}" method="POST">
                @include('rooms._form')

                <hr class="my-4">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Créer la salle
                </button>
            </form>
        </div>
    </div>

</x-layout>
