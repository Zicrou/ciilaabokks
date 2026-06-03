@extends("base")

@section("content")
    <h1 class="text-center">Ajouter un metier</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route("metiers.store")}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du metier</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="domain_id" class="form-label">Domaine</label>
                    <select name="domain_id" id="domain_id" class="form-control" required>
                        <option value="">Sélectionnez un domaine</option>
                        @foreach($domaines as $domaine)
                            <option value="{{ $domaine->id }}">{{ $domaine->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection