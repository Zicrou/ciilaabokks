@extends("base")

@section("content")
    <h1 class="text-center">Modifier un ouvrier</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route("ouvriers.update", $ouvrier->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'ouvrier</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $ouvrier->name }}"  required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Adresse</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ $ouvrier->address }}"  required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Téléphone 1</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $ouvrier->phone_number }}"  required>
                </div>
                <div class="mb-3">
                    <label for="phone_number_2" class="form-label">Téléphone 2</label>
                    <input type="text" name="phone_number_2" id="phone_number_2" class="form-control" value="{{ $ouvrier->phone_number_2 }}" >
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $ouvrier->email }}" >
                </div>
                <div class="mb-3">
                    <label for="domaines" class="form-label">Domaine</label>
                    <select name="domaines[]" id="domaines" class="form-control" multiple required>
                        <option value="">Sélectionnez un domaine</option>
                        @foreach($domaines as $k => $v)
                            <option value="{{ $k }}" @selected($selectedDomaines->contains($k))>
                                {{ $v }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="metiers" class="form-label">Metier</label>
                    <select name="metiers[]" id="metiers" class="form-control" multiple required>
                        <option value="">Sélectionnez un metier</option>
                        @foreach($metiers as $k => $v)
                            <option value="{{ $k }}" @selected($selectedMetiers->contains($k))>
                                {{ $v }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="annees_experience" class="form-label">Année experience</label>
                    <input type="numeric" name="annees_experience" id="annees_experience" class="form-control" value="{{ $ouvrier->annees_experience }}">
                </div>
                <input type="hidden" name="deleted_entreprises" id="deleted_entreprises">
                <div id="entreprises-container">
                    @foreach ($ouvrier->entreprises as $entreprise)
                        <div class="d-flex mb-2 entreprise-row">
                            <input
                                type="text"
                                name="entreprises[]"
                                class="form-control me-2"
                                value="{{ $entreprise->name }}"
                                placeholder="Nom de l'entreprise"
                            >

                            <button
                                type="button"
                                class="btn btn-danger remove-row"
                                data-id="{{ $entreprise->id }}"
                                >
                                X
                            </button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-entreprise" class="mb-3 btn btn-primary">
                    Ajouter une entreprise
                </button>
                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">Date de naissance</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $ouvrier->date_of_birth }}" required>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo de l'ouvrier</label>
                    <input type="file" name="photo" id="photo" class="form-control" value="{{ $ouvrier->photo }}" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="photo_cni" class="form-label">Photo de la CNI</label>
                    <input type="file" name="photo_cni" id="photo_cni" class="form-control" value="{{ $ouvrier->photo_cni }}" accept="image/png, image/jpeg, image/jpg, image/webp">
                </div>

                <div class="mb-3">
                    <label for="numero_cni" class="form-label">Numéro de la CNI</label>
                    <input type="text" name="numero_cni" id="numero_cni" class="form-control" value="{{ $ouvrier->numero_cni }}" >
                </div>

                <div class="mb-3">
                    <label for="country_id" class="form-label">Pays</label>
                    <select name="country_id" id="country_id" class="form-control" required>
                        <option value="">Sélectionnez un pays</option>
                        @foreach($countries as $k => $v)
                            <option value="{{ $k }}" @selected($selectedCountry->contains($k))>
                                {{ $v }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="region_id" class="form-label">Region</label>
                    <select name="region_id" id="region_id" class="form-control" required>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ $ouvrier->region_id == $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="departement_id" class="form-label">Département</label>
                    <select name="departement_id" id="departement_id" class="form-control" required>
                        @foreach($departements as $departement)
                            <option value="{{ $departement->id }}" {{ $ouvrier->departement_id == $departement->id ? 'selected' : '' }}>
                                {{ $departement->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="Diplômes" class="form-label">Diplômes</label>
                    <select name="diplomes[]" id="diplomes" class="form-control" multiple required>
                        @foreach($diplomes as $k => $v)
                            <option value="{{ $k }}" @selected($selectedDiplomes->contains($k))>
                                {{ $v }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="images" class="form-label">Portfolio</label>
                    <input type="file" name="images[]" id="images" class="form-control" value="{{ old('images') }}" accept="image/png, image/jpeg, image/jpg, image/webp" multiple
                        accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('ouvriers.liste') }}" class="btn btn-secondary">
            Retour
        </a>
    </div>

    <script>
        document.getElementById('add-entreprise').addEventListener('click', function () {
            const row = document.createElement('div');

            row.innerHTML = `
                <div class="d-flex mb-2">
                    <input
                        type="text"
                        name="entreprises[]"
                        class="form-control me-2"
                        placeholder="Nom de l'entreprise">

                    <button
                        type="button"
                        class="btn btn-danger remove-row">
                        X
                    </button>
                </div>
            `;

            document
                .getElementById('entreprises-container')
                .appendChild(row);
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('.d-flex').remove();
            }
        });
        
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {

                const id = e.target.dataset.id;

                if (id) {
                    const deletedInput = document.getElementById('deleted_entreprises');

                    let deleted = deletedInput.value
                        ? deletedInput.value.split(',')
                        : [];
                    console.log(deletedInput);
                    deleted.push(id);
                    deletedInput.value = deleted.join(',');
                }
                e.target.closest('.entreprise-row').remove();
            }
        });
    </script>
@endsection