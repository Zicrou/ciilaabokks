@extends('base')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-center">

                        @if($ouvrier->photo)
                            <img
                                src="{{ asset('storage/' . $ouvrier->photo) }}"
                                alt="Photo"
                                class=""
                                style="width: 25rem; height: 15rem; object-fit: cover; margin: -8px; margin-left: -16px;"
                            >
                        @endif

                       

                    </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Left Part -->
                <div class="col-md-6">
                    <h5 class="mb-3">Informations personnelles</h5>

                   
                    <p><strong>Nom :</strong> {{ $ouvrier->name }}</p>
                    <p><strong>Téléphone :</strong> {{ $ouvrier->phone_number }}</p>
                    <p><strong>Téléphone 2 :</strong> {{ $ouvrier->phone_number_2 }}</p>
                    <p><strong>Email :</strong> {{ $ouvrier->email }}</p>
                    <p><strong>Adresse :</strong> {{ $ouvrier->address }}</p>
                    <p><strong>Numro CNI :</strong> {{ $ouvrier->numero_cni }}</p>
                    <p><strong>Photo CNI :</strong> <img src="{{ $ouvrier->photo_cni }}"
                            alt="Photo CNI"
                            class="aspect-video h-full w-full flex-1 rounded-[10px] object-top object-cover drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)] dark:hidden"
                        />
                    </p>
                    <p><strong>Région :</strong> {{ $ouvrier->region?->name }} / {{ $ouvrier->country?->name }}</p>
                    <p><strong>Département :</strong> {{ $ouvrier->departement?->name }}</p>
                </div>

                <!-- Right Part -->
                <div class="col-md-6">
                    <h5 class="mb-3">Informations professionnelles</h5>

                    @foreach ($ouvrier->metiers as $metier)
                        <p><strong>Domaine :</strong> {{ $metier?->domaine?->name }}</p>
                        <p><strong>Métier :</strong> {{ $metier?->name }}</p>
                    @endforeach
                    
                    
                    <p><strong>Année expérience :</strong> {{ $ouvrier->annee_experience }}</p>
                    <p><strong>Entreprises :</strong> 
                        @foreach ($ouvrier->entreprises as $entreprise)
                            {{ $entreprise->name}}
                        @endforeach</p>
                </div>

            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">Portfolio de l'ouvrier</h3>
        </div>

        <div class="card-body">
            <div class="row d-flex justify-content-center">
                @foreach ($ouvrier->portfolios as $portfolio)
                    <img class="d-block mb-5" style="height:300px;width:450px" src="{{ asset('storage/' . $portfolio->image) }}" alt="">
                @endforeach
            </div>
        </div>
    </div>
    <div class="mt-4">

        <a href="{{ route('ouvriers.index') }}" class="btn btn-secondary">

            Retour

        </a>

        <a href="{{ route('ouvriers.edit', $ouvrier) }}" class="btn btn-warning">

            Modifier

        </a>

    </div>
</div>
@endsection