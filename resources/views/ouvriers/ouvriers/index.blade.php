@extends("base")

@section("content")
    <span class="h1 text-center">Ouvriers</span> <a href="{{ route("ouvriers.create") }}" class="h1 btn btn-primary">Ajouter</a>
    @foreach($ouvriers as $ouvrier)
        @if($ouvriers->isEmpty())
            <div class="card text-center">
                <div class="card-body">
                    <p class="text-center">Aucun ouvrier trouvé.</p>
                </div>
            </div>
        @else
        <div class="card text-center mb-5">
            <div class="card-header">
                <h2 class="card-title">{{  $ouvrier->metier->domain->name . " / " . $ouvrier->metier->name}}</h2>
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-3 me-auto flex-fill" style="">
                        <p class="card-text" style="text-align:left;"> {{ $ouvrier->name }}</p>
                        <p class="card-text" style="text-align:left;">Adresse : {{ $ouvrier->address }}</p>
                    </div>
                    <div class="col-md-3 flex-fill" style="">
                        @if($ouvrier->photo)
                            <img src="{{ asset('storage/' . $ouvrier->photo) }}" alt="Photo" width="70%">
                        @endif
                    </div>
                    <div class="col-md-3 text-start flex-fill" style="">
                        <p class="card-text" style="">Téléphone 1 : {{ $ouvrier->phone_number }}</p>
                        <p class="card-text" style="text-align:left;" >Téléphone 2 : {{ $ouvrier->phone_number_2 }}</p>
                    </div>
                </div>
            </div>
            <div class="container card-footer text-body-secondary">
                <div class="row d-flex text-start flex-fill">
                    <div class=" col-2 col-sm-2 col-lg-2">
                        <span class="">CiiLaaBokK</span>
                    </div>
                    <div class="col-7 d-flex justify-content-center text-center mx-auto gap-2" style="padding: 0">
                        <a href="{{ route("ouvriers.edit", $ouvrier->id) }}" class=" btn btn-sm btn-outline-primary col-2">Edit</a>
                        <a href="{{ route("ouvriers.show", $ouvrier->id) }}" class=" btn btn-sm btn-outline-info col-2 mx-2">Show</a>
                        <form action="{{ route("ouvriers.destroy", $ouvrier->id) }}" method="post" style="display: inline; margin-left: -20px;" class="col-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    

        @endif
    @endforeach

@endsection