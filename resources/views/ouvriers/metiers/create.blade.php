@extends("base")

@section("content")
    <h1 class="text-center">Ajouter un departement</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route("departements.store")}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du departement</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="region_id" class="form-label">Region</label>
                    <select name="region_id" id="region_id" class="form-control" required>
                        <option value="">Sélectionnez une region</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection