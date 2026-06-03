<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-evenly ">
                        <a href="{{ route('ouvriers.create') }}" class="btn btn-primary">Ajouter un ouvrier</a>
                        {{-- <a href="{{ route('ouvriers.show', $numero_de_telephone) }}" class="btn btn-primary">Mon Compte</a> --}}
                        <a href="{{ route('ouvriers.index') }}" class="btn btn-primary">Voir la liste des Ouvriers</a>
                        {{-- <div class=""> --}}
                            <form action="{{ route("ouvriers.mon_compte") }}" method="get" style="display: inline;" class="d-flex justify-content-end">
                                @csrf
                                <input type="text" name="telephone" placeholder="Mon numéro de téléphone">
                                @error('telephone')
                                    {{ $message }}
                                @enderror
                                <br>
                                <button type="submit" class="btn btn-secondary">Mon Compte</button>
                            </form>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
