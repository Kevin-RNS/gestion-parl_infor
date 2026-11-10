<x-layout :title="'Modifier '.$category->nom">

    <x-page-header :title="'Modifier '.$category->nom" subtitle="Renommer cette catégorie.">
        <x-slot:actions>
            <a href="{{ route('categories.show', $category) }}" class="btn btn-light">Annuler</a>
        </x-slot:actions>
    </x-page-header>

    <div class="surface-card">
        <div class="card-body">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @include('categories._form')

                <hr class="my-4">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>

</x-layout>
