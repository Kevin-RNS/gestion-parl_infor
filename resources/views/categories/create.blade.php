<x-layout title="Nouvelle catégorie">

    <x-page-header title="Nouvelle catégorie" subtitle="Créer un type de matériel.">
        <x-slot:actions>
            <a href="{{ route('categories.index') }}" class="btn btn-light">Annuler</a>
        </x-slot:actions>
    </x-page-header>

    <div class="surface-card">
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @include('categories._form')

                <hr class="my-4">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Créer la catégorie
                </button>
            </form>
        </div>
    </div>

</x-layout>
