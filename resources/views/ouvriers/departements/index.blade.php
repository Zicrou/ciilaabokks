@extends("base")

@section("content")
    <span class="h1 text-center">Departements</span> <a href="{{ route("departements.create") }}" class="h1 btn btn-primary">Ajouter</a>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Region</th>
                        <th>Country</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departements as $departement)
                        <tr>
                            <td>{{ $departement->name }}</td> 
                            <td>{{ $departement->region->name }}</td>
                            <td>{{ $departement->region->country->name }}</td>
                            <td class="text-end">
                                <a href="{{ route("departements.edit", $departement->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route("departements.destroy", $departement->id) }}" method="post" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>      
                        </tr>
                        <tr>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection