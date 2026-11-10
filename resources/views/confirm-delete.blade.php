{{-- Page de confirmation avant suppression (aucun JavaScript nécessaire). --}}
<x-layout title="Confirmer la suppression">

    <x-page-header title="Confirmer la suppression"
                   subtitle="Cette action est définitive." />

    <div class="surface-card">
        <div class="card-body">
            <p class="mb-4">
                Voulez-vous vraiment supprimer <strong>{{ $name }}</strong> ?
            </p>

            <form action="{{ $route }}" method="POST" class="d-flex gap-2">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash3 me-1" aria-hidden="true"></i> Oui, supprimer
                </button>

                <a href="{{ $back }}" class="btn btn-light">Annuler</a>
            </form>
        </div>
    </div>

</x-layout>
