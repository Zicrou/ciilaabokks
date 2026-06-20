@extends("base")

@section("content")
    <h1 class="text-center">Modifier un metier</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route("metiers.update", $metier->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du metier</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $metier->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="domaine_id" class="form-label">Domaine</label>
                    <select name="domaine_id" id="domaine_id" class="form-control" required>
                        @foreach($domaines as $domaine)
                            <option value="{{ $domaine->id }}" {{ $metier->domaine_id == $domaine->id ? 'selected' : '' }}>{{ $domaine->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection