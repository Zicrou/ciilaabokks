@extends("base")

@section("content")
    <h1 class="text-center">Ajouter une Region</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route("regions.store")}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de la region</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="country_id" class="form-label">Pays</label>
                    <select name="country_id" id="country_id" class="form-control" required>
                        <option value="">Sélectionnez un pays</option>
                        @foreach($countries as $k => $v)
                            <option value="{{ $k }}">{{ $v}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection