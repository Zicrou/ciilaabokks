@extends("base")

@section("content")
    <span class="h1 text-center">Metiers</span> <a href="{{ route("metiers.create") }}" class="h1 btn btn-primary">Ajouter</a>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Domaine</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($metiers as $metier)
                        <tr>
                            <td>{{ $metier->name }}</td> 
                            <td>{{ $metier->domain->name }}</td>
                            <td class="text-end">
                                <a href="{{ route("metiers.edit", $metier->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route("metiers.destroy", $metier->id) }}" method="post" style="display: inline;">
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