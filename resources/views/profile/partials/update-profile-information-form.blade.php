<div class="card shadow-sm border-0 rounded-4">
    <div class="card-header">
        <h5 class="mb-0">Información Personal</h5>
    </div>

    <div class="card-body">

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label class="form-label">RUT</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ Auth::user()->rut }}"
                    readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Nombre</label>

                <input
                    type="text"
                    name="nombre"
                    class="form-control"
                    value="{{ old('nombre', Auth::user()->nombre) }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', Auth::user()->email) }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Rol</label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ ucfirst(Auth::user()->rol) }}"
                    readonly>
            </div>

            <button class="btn btn-primary">
                Guardar Cambios
            </button>

        </form>

    </div>
</div>