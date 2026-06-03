@extends("base")

@section("content")
    <h1 class="text-center">Modifier un departement</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route("departements.update", $departement->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du departement</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $departement->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="region_id" class="form-label">Region</label>
                    <select name="region_id" id="region_id" class="form-control" required>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ $departement->region_id == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection