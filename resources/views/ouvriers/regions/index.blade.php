@extends("base")

@section("content")
    <span class="h1 text-center">Regions</span> <a href="{{ route("regions.create") }}" class="h1 btn btn-primary">Ajouter</a>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Country</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($regions as $region)
                        <tr>
                            <td>{{ $region->name }}</td> 
                            <td>{{ $region->country->name }}</td>
                            <td class="text-end">
                                <a href="{{ route("regions.edit", $region->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route("regions.destroy", $region->id) }}" method="post" style="display: inline;">
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