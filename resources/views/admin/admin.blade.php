@extends("base")

@section("content")
    <h1 class="text-center">Ajouter un ouvrier</h1>
    <div class="mt-4">
        <a href="{{ route('ouvriers.liste') }}" class="btn btn-secondary">
            Liste ouvriers
        </a>
        <a href="{{ route('ouvriers.create') }}" class="btn btn-secondary mx-5">
            Créer ouvrier
        </a>
    </div>

    <div class="mt-4">
        <a href="{{ route('domaines.index') }}" class="btn btn-secondary">
            Domaines
        </a>
    </div>

    <div class="mt-4">
        <a href="{{ route('metiers.index') }}" class="btn btn-secondary">
            Metiers
        </a>
    </div>

    <div class="mt-4">
        <a href="{{ route('regions.index') }}" class="btn btn-secondary">
            Region
        </a>
    </div>

    <div class="mt-4">
        <a href="{{ route('departements.index') }}" class="btn btn-secondary">
            Departement
        </a>
    </div>
    <div class="mt-4">
        <a href="{{ route('countries.index') }}" class="btn btn-secondary">
            Country
        </a>
    </div>

    <div class="mt-4">
        <a href="{{ route('diplomes.index') }}" class="btn btn-secondary">
            Diplome
        </a>
    </div>
@endsection