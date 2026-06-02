@extends("base")

@section("content")
    <h1 class="text-center">Ouvriers</h1>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Numéro de téléphone</th>  
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($ouvriers as $ouvrier)
                        <tr>
                            <td>{{ $ouvrier->name }}</td>       
                            <td>{{ $ouvrier->email }}</td>
                            <td>{{ $ouvrier->phone_number }}</td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection