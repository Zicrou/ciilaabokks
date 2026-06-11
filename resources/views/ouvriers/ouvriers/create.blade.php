@extends("base")

@section("content")
    <h1 class="text-center">Ajouter un ouvrier</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route("ouvriers.store")}}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'ouvrier</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Adresse</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Téléphone 1</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}" required>
                </div>
                <div class="mb-3">
                    <label for="phone_number_2" class="form-label">Téléphone 2</label>
                    <input type="text" name="phone_number_2" id="phone_number_2" class="form-control" value="{{ old('phone_number_2') }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="domain_id" class="form-label">Domaine</label>
                    <select name="domain_id" id="domain_id" class="form-control"  required>
                        <option value="">Sélectionnez un domaine</option>
                        @foreach($domains as $domain)
                            <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="metier_id" class="form-label">Metier</label>
                    <select name="metier_id" id="metier_id" class="form-control" required>
                        <option value="">Sélectionnez un metier</option>
                        
                        @foreach($metiers as $metier)
                            <option value="{{ $metier->id }}">{{ $metier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="annees_experience" class="form-label">Année experience</label>
                    <input type="numeric" name="annees_experience" id="annees_experience" class="form-control" value="{{ old('annees_experience') }}">
                </div>
                <div class="mb-3">
                    <label for="entreprises" class="form-label">Entreprise</label>
                    <input type="text" name="entreprises" id="entreprises" class="form-control" value="{{ old('entreprises') }}">
                </div>
                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">Date de naissance</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo de l'ouvrier</label>
                    <input type="file" name="photo" id="photo" class="form-control" value="{{ old('photo') }}" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="photo_cni" class="form-label">Photo de la CNI</label>
                    <input type="file" name="photo_cni" id="photo_cni" class="form-control" value="{{ old('photo_cni') }}" accept="image/png, image/jpeg, image/jpg, image/webp">
                </div>

                <div class="mb-3">
                    <label for="numero_cni" class="form-label">Numéro de la CNI</label>
                    <input type="text" name="numero_cni" id="numero_cni" class="form-control" value="{{ old('numero_cni') }}">
                </div>

                <div class="mb-3">
                    <label for="country_id" class="form-label">Pays</label>
                    <select name="country_id" id="country_id" class="form-control" required>
                        <option value="">Sélectionnez un pays</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="region_id" class="form-label">Region</label>
                    <select name="region_id" id="region_id" class="form-control"  required>
                        <option value="">Sélectionnez une region</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="departement_id" class="form-label">Département</label>
                    <select name="departement_id" id="departement_id" class="form-control"  required>
                        <option value="">Sélectionnez un département</option>
                        @foreach($departements as $departement)
                            <option value="{{ $departement->id }}">{{ $departement->name }}</option>
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
        <a href="{{ route('ouvriers.index') }}" class="btn btn-secondary">
            Retour
        </a>
    </div>
@endsection