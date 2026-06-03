@extends("base")

@section("content")
    <h1 class="text-center">Ajouter un domaine</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route("domaines.store")}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du domaine</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection