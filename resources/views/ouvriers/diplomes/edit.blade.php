@extends("base")

@section("content")
    <h1 class="text-center">Modifier un diplôme</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route("diplomes.update", $diplome->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du diplôme</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $diplome->name }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection