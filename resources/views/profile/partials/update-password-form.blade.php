<section>
    <header class="mb-4">
        <h2 class="fw-bold h5 mb-1">
            {{ __('Atualizar Senha') }}
        </h2>

        <p class="text-muted small">
            {{ __('Certifique-se de que sua conta está usando uma senha longa e aleatória para manter a segurança.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label small fw-bold text-uppercase">{{ __('Senha Atual') }}</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="form-control" autocomplete="current-password">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-danger small" />
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label small fw-bold text-uppercase">{{ __('Nova Senha') }}</label>
            <input id="update_password_password" name="password" type="password"
                class="form-control" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-danger small" />
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label small fw-bold text-uppercase">{{ __('Confirmar Nova Senha') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-danger small" />
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-3 shadow-sm">
                {{ __('Atualizar Senha') }}
            </button>

            @if (session('status') === 'password-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-success small mb-0 fw-medium">
                <i class="bi bi-check-circle me-1"></i>{{ __('Senha atualizada com sucesso!') }}
            </p>
            @endif
        </div>
    </form>
</section>