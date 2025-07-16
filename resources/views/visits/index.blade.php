<x-layout>
    <div class="row m-4">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success my-2">{{ session('success') }}</div>
            @endif

            <a href="{{ route('visits.create') }}" class="btn btn-primary mb-3">Nueva Visita</a>
        </div>

        <div class="col-12 mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($visits as $visit)
                        <tr>
                            <td>{{ $visit->name }}</td>
                            <td>{{ $visit->email }}</td>
                            <td>{{ $visit->latitud }}</td>
                            <td>{{ $visit->longitud }}</td>
                            <td>
                                <a href="{{ route('visits.edit', $visit) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form method="POST" action="{{ route('visits.destroy', $visit) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $visits->links() }}
        </div>
    </div>
</x-layout>