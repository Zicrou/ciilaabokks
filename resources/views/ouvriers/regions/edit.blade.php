@extends("base")

@section("content")
    <h1 class="text-center">Modifier une region</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route("regions.update", $region->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de la region</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $region->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="country_id" class="form-label">Pays</label>
                    <select name="country_id" id="country_id" class="form-control" required>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ $region->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection