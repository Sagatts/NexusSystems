<div class="card shadow-sm border-0 rounded-4">
    <div class="card-header">
        <h5 class="mb-0">Cambiar Contraseña</h5>
    </div>

    <div class="card-body">

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="mb-3">
                <label class="form-label">
                    Contraseña Actual
                </label>

                <input
                    type="password"
                    name="current_password"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Nueva Contraseña
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Confirmar Contraseña
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control">
            </div>

            <button class="btn btn-warning">
                Actualizar Contraseña
            </button>

        </form>

    </div>
</div>