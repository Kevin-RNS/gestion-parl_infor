<x-layout :title="'Modifier ' . $device->nom">

    <h1 class="h3 mb-4">Modifier « {{ $device->nom }} »</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('devices.update', $device) }}" method="POST">
                @include('devices._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Enregistrer les modifications
                </button>
                <a href="{{ route('devices.show', $device) }}" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>

</x-layout>
