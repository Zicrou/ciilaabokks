@extends("base")

@section("content")
<div class="container">

  <h1>Rechercher d'ouvriers</h1>

  <!-- SEARCH FORM -->
  <div class="card mb-5">
        <form action="{{ route("ouvriers.rechercher") }}" method="get" style="display: inline; margin-left: -20px;" class="">
            @csrf
            <div class="row d-flex justify-content-center">
                <div class="form-group col-lg-4">
                    <div class="mb-3">
                        <label for="departement_id" class="form-label">Département</label>
                        <select name="departement_id" id="departement_id" class="form-control" >
                            <option value="">Sélectionnez un département</option>
                            @foreach($departements as $departement)
                                <option value="{{ $departement->id }}" {{ request('departement_id') == $departement->id ? 'selected' : '' }}>{{ $departement->name }}</option>
                            @endforeach
                            onchange="getIdDepartement()"
                        </select>
                    </div>
                </div>


                <div class="form-group departements col-lg-4" data-departements="<%= @departements.to_json %>">
                    <label for="region_id" class="form-label">Région</label>
                    <select name="region_id" id="region_id" class="form-control" >
                        <option value="">Sélectionnez une région</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                        @endforeach
                        onchange="getIdRegion()"
                    </select>
                </div>
            </div>

            <div class="row mt-5 d-flex justify-content-center">
                <div class="form-group col-lg-4">
                    <label for="domaine_id" class="form-label">Domaine</label>
                    <select name="domaine_id" id="domaine_id" class="form-control" >
                        <option value="">Sélectionnez un domaine</option>
                        @foreach($domaines as $domaine)
                            <option value="{{ $domaine->id }}" {{ request('domaine_id') == $domaine->id ? 'selected' : '' }}>{{ $domaine->name }}</option>
                        @endforeach
                        onchange="getIDDomaine()"
                    </select>
                </div>
            
                <div class="form-group metiers col-lg-4" data-metiers="<%= @metiers.to_json %>">
                    <label for="metier_id" class="form-label">Métier</label>
                    <select name="metier_id" id="metier_id" class="form-control" >
                        <option value="">Sélectionnez un métier</option>
                        @foreach($metiers as $metier)
                            <option value="{{ $metier->id }}" {{ request('metier_id') == $metier->id ? 'selected' : '' }}>{{ $metier->name }}</option>
                        @endforeach
                        onchange="getIdMetier()"
                    </select>
                </div>
            </div>
            <div class="row m-5 d-flex justify-content-center">
                <div class="form-group col-lg-4">
                    <div class="">
                        <label for="phone_number" class="form-label">Telephone</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ request('phone_number') }}"  required>
                    </div>
                </div>
            </div>
            <div class="row m-3 d-flex justify-content-center">
                <div class="form-group col-lg-4">
                    <button type="submit" class="form-control btn btn-primary">Rechercher</button>
                </div>
                <div class="form-group col-lg-4">
                    <a class="btn btn-secondary col-4" href="{{ route('ouvriers.index') }}"class="form-control btn btn-primary">Réinitialiser</a>
                </div>
            </div>

            </div>
        </form>
    </div>


    <span class="h1 text-center">Ouvriers</span> <a href="{{ route("ouvriers.create") }}" class="h1 btn btn-primary">Ajouter</a>

    @foreach($ouvriers as $ouvrier)
        @if($ouvriers->isEmpty())
            <div class="card text-center mt-5">
                <div class="card-body">
                    <p class="text-center">Aucun ouvrier trouvé.</p>
                </div>
            </div>
        @else
            <div class="card text-center mt-5">
                <div class="card-header">
                    <h2 class="card-title">{{  $ouvrier->metier->domain->name . " / " . $ouvrier->metier->name}}</h2>
                </div>
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <p class="card-text" style="text-align:center;">{{ $ouvrier->departement->name . '/' . $ouvrier->region->name }}</p>
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
                            <a href="{{ route("ouvriers.edit", $ouvrier) }}" class=" btn btn-sm btn-outline-primary col-2">Edit</a>
                            <a href="{{ route("ouvriers.show", $ouvrier) }}" class=" btn btn-sm btn-outline-info col-2 mx-2">Show</a>
                            <form action="{{ route("ouvriers.destroy", $ouvrier) }}" method="post" style="display: inline; margin-left: -20px;" class="col-2">
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

