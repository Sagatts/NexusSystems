<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">
        <h4 class="fw-bold mb-0">
            Cambiar Contraseña
        </h4>
    </div>

    <div class="card-body">

        <form id="updatePasswordForm" method="POST" action="{{ route('password.update') }}">
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
                        id="current_password"
                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">

                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">
                        Nueva Contraseña
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password', 'updatePassword') is-invalid @enderror">

                    <!-- Barra de fortaleza -->
                    <div id="password-strength-container" class="mt-2 mb-3">
                        <div class="progress" style="height: 6px;">
                            <div id="password-strength-bar"
                                class="progress-bar"
                                style="width: 0%; transition: width 0.3s ease;">
                            </div>
                        </div>

                        <small id="password-strength-text"
                            class="d-block mt-1"
                            style="color: #999;">
                        </small>
                    </div>

                    <!-- Requisitos -->
                    <div id="password-requirements" class="row g-2 mb-3">

                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-length" class="bi bi-circle"
                                    style="color: #999; font-size: 18px;"></i>
                                <small>Mín. 8 caracteres</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-lowercase" class="bi bi-circle"
                                    style="color: #999; font-size: 18px;"></i>
                                <small>Minúscula</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-uppercase" class="bi bi-circle"
                                    style="color: #999; font-size: 18px;"></i>
                                <small>Mayúscula</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-number" class="bi bi-circle"
                                    style="color: #999; font-size: 18px;"></i>
                                <small>Número</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i id="req-special" class="bi bi-circle"
                                    style="color: #999; font-size: 18px;"></i>
                                <small>Carácter especial</small>
                            </div>
                        </div>

                    </div>

                    @error('password', 'updatePassword')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                    <div id="password-error" class="text-danger small mt-2"></div>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">
                        Confirmar Contraseña
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control">

                    <div id="password-match-message" class="small mt-2"></div>
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

@stack('scripts')