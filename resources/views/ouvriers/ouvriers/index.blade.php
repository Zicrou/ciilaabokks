@extends("base")

@section("content")
<div class="container mb-5">
    <div class="row d-flex">
        <div class="col-5">
            <h1>Rechercher d'ouvriers</h1>
        </div>
        <div class="col-5 d-flex flex-row-reverse">
            <span class="h1 text-center"></span> <a href="{{ route("ouvriers.create") }}" class="h1 btn btn-primary">Ajouter un ouvrier</a>
        </div>
    </div>

  <!-- SEARCH FORM -->
  <div class="card mb-5">
        <form action="{{ route("ouvriers.rechercher") }}" method="get" style="display: inline; margin-left: -20px;" class="">
            @csrf
            <div class="row d-flex m-3 justify-content-center">
                <div class="form-group col-lg-4">
                    <div class="mb-3">
                        <label for="departement_id" class="form-label">Département</label>
                        <select name="departement_id" id="departement_id" class="form-control" >
                            <option value="">Sélectionnez un département</option>
                            @foreach($departements as $departement)
                                <option value="{{ $departement->id }}" {{ request('departement_id') == $departement->id ? 'selected' : '' }}>{{ $departement->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-group departements col-lg-4">
                    <label for="region_id" class="form-label">Région</label>
                    <select name="region_id" id="region_id" class="form-control">
                        <option value="">Sélectionnez une région</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row m-3 d-flex justify-content-center">
                <div class="form-group col-lg-4">
                    <label for="domaine_id" class="form-label">Domaine</label>
                    <select name="domaine_id" id="domaine_id" class="form-control">
                        <option value="">Sélectionnez un domaine</option>
                        @foreach($domaines as $domaine)
                            <option value="{{ $domaine->id }}">{{ $domaine->name }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="form-group metiers col-lg-4" >
                    <label for="metier_id" class="form-label">Métier</label>
                    <select name="metier_id" id="metier_id" class="form-control">
                        <option value="">Sélectionnez un métier</option>
                        @foreach($metiers as $metier)
                            <option value="{{ $metier->id }}" {{ request('metier_id') == $metier->id ? 'selected' : '' }}>{{ $metier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row m-5 d-flex justify-content-center">
                <div class="form-group col-lg-4">
                    <div class="">
                        <label for="phone_number" class="form-label">Telephone</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ request('phone_number') }}" >
                    </div>
                </div>
            </div>
            <div class="row justify-content-center m-3">
                <div class="col-md-4 text-center">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        Rechercher
                    </button>

                    <a href="{{ route('ouvriers.liste') }}"
                    class="btn btn-secondary w-100">
                        Réinitialiser
                    </a>
                </div>
            </div>      
        </form>
    </div>



    @if($ouvriers->isEmpty())
            <div class="card text-center mt-5 mb-5">
                <div class="card-body">
                    <p class="text-center">Aucun ouvrier trouvé.</p>
                </div>
            </div>
    @endif
    @foreach($ouvriers as $ouvrier)
            <div class="card text-center mt-5 mb-5">
                <div class="card-header">
                    <div class="d-flex align-items-center">

                        @if($ouvrier->photo)
                            <img
                                src="{{ asset('storage/' . $ouvrier->photo) }}"
                                alt="Photo"
                                class="rounded"
                                style="width: 100px; height: 100px; object-fit: cover; margin: -8px; margin-left: -16px;"
                            >
                        @endif

                        <div class="flex-grow-1 text-center">
                            <h4 class="mb-1"><a href="{{ route("ouvrier.show", $ouvrier->id) }}" class="text-capitalized text-black col-3 col-sm-3 col-lg-3">{{ $ouvrier->name }}</a></h4>

                            <p class="mb-0">
                                Téléphone 1 : {{ $ouvrier->phone_number }}
                                @if($ouvrier->phone_number_2)
                                    / Téléphone 2 : {{ $ouvrier->phone_number_2 }}
                                @endif
                            </p>

                            <small class="text-muted">
                                {{ $ouvrier->departement->name }}/{{ $ouvrier->region->name }}
                                - {{ $ouvrier->address }}
                            </small>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row d-flex justify-content-around">
                        <div class="col-4">
                            <div class=" flex-fill" style="">
                                @foreach ($ouvrier->metiers as $metier)
                                    <p class="card-text bold" style="text-align:left;"><strong>{{ $metier->domaine->name . " / " . $metier->name }}</strong></p>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-4">
                            @foreach ($ouvrier->entreprises as $entreprise)
                                <p class="card-text" style="text-align:center;"><strong>Entreprises: </strong>{{ $entreprise->name }}</p>
                            @endforeach
                        </div>
                        
                        
                    </div>
                </div>
                <div class="container card-footer text-body-secondary">
                    <div class="row d-flex text-start flex-fill">
                        <div class="col-3 col-sm-3 col-lg-3">
                            <span class="">CiiLaaBokK</span>
                        </div>
                        <div class="col-7 d-flex justify-content-evenly text-center mx-auto gap-2" style="padding: 0">
                            <a href="{{ route("ouvrier.show", $ouvrier->id) }}" class=" btn btn-sm btn-outline-info col-3 col-sm-3 col-lg-3">Show</a>
                            @auth
                                @if (Auth()->user()->id == $ouvrier->user_id)
                                    <a href="{{ route("ouvriers.edit", $ouvrier) }}" class=" btn btn-sm btn-outline-primary col-3 col-sm-3 col-lg-3">Edit</a>
                                    <form action="{{ route("ouvriers.destroy", $ouvrier) }}" method="post" style="display: inline; margin-left: -1px;" class="col-3 col-sm-3 col-lg-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                @endif
                                
                            @endauth
                        </div>

                    </div>
                </div>
            </div>
    @endforeach

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        document.getElementById('domaine_id').addEventListener('change', function () {
            const domaineId = this.value;

            fetch(`/api/metiers?domaine_id=${domaineId}`)

            .then(response => response.json())

            .then(data => {

                let metierSelect =
                document.getElementById('metier_id');

                metierSelect.innerHTML =
                    '<option value="">Sélectionnez un métier</option>';

                data.forEach(metier => {
                    metierSelect.innerHTML += `
                        <option value="${metier.id}">
                            ${metier.name}
                        </option>
                    `;
                });

            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.getElementById('region_id').addEventListener('change', function () {

            const regionId = this.value;

            fetch(`/api/departements?region_id=${regionId}`)
            .then(response => response.json())
            .then(data => {

                console.log(data);
                let departementSelect =
                    document.getElementById('departement_id');

                departementSelect.innerHTML =
                    '<option value="">Sélectionnez un département</option>';

                data.forEach(departement => {
                    departementSelect.innerHTML += `
                        <option value="${departement.id}">
                            ${departement.name}
                        </option>`;
                });
            });
        });
    });
</script>
@endsection

