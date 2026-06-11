<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">
        <h4 class="fw-bold mb-0">
            Cambiar Contraseña
        </h4>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-12">
                    <label class="form-label fw-bold">
                        Contraseña Actual
                    </label>

                    <input
                        type="password"
                        name="current_password"
                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">

                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        Nueva Contraseña
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password', 'updatePassword') is-invalid @enderror">

                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        Confirmar Contraseña
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control">
                </div>

            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-warning">
                    Actualizar Contraseña
                </button>
            </div>

        </form>

    </div>

</div>