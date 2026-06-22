<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">
        <h4 class="fw-bold mb-0">
            Información Personal
        </h4>
    </div>

    <div class="card-body">

        <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        RUT
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ Auth::user()->rut }}"
                        readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        Rol
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ ucfirst(Auth::user()->rol) }}"
                        readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        Nombre
                    </label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        class="form-control @error('nombre') is-invalid @enderror"
                        value="{{ old('nombre', Auth::user()->nombre) }}">

                    @error('nombre')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div id="nombreError" class="text-danger small mt-1"></div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        Correo Electrónico
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', Auth::user()->email) }}">

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div id="emailError" class="text-danger small mt-1"></div>
                </div>

            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    Guardar Cambios
                </button>
            </div>

        </form>

    </div>

</div>
@stack('scripts')