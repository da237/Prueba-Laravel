<x-layout>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form method="POST" action="{{ $visit->exists ? route('visits.update', $visit) : route('visits.store') }}">
                @csrf
                @if($visit->exists) @method('PUT') @endif

                <div class="form-group">
                    <label>Nombre</label>
                    <input name="name" class="form-control" value="{{ old('name', $visit->name) }}">
                    @error('name') <div>{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input name="email" class="form-control" value="{{ old('email', $visit->email) }}">
                    @error('email') <div>{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Latitud</label>
                    <input name="latitud" class="form-control" value="{{ old('latitud', $visit->latitud) }}">
                    @error('latitud') <div>{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Longitud</label>
                    <input name="longitud" class="form-control" value="{{ old('longitud', $visit->longitud) }}">
                    @error('longitud') <div>{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary mt-2">{{ $visit->exists ? 'Actualizar' : 'Crear' }}</button>
            </form>
        </div>
    </div>
</x-layout>