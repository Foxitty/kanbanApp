<section>
    <header class="mb-4">
        <h2 class="fw-bold h5 mb-1">
            {{ __('Informações do Perfil') }}
        </h2>

        <p class="text-muted small">
            {{ __("Atualize as informações de perfil e o endereço de e-mail da sua conta.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label small fw-bold text-uppercase">{{ __('Nome') }}</label>
            <input id="name" name="name" type="text" class="form-control"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            <x-input-error class="mt-2 text-danger small" :messages="$errors->get('name')" />
        </div>

        <div class="mb-4">
            <label for="email" class="form-label small fw-bold text-uppercase">{{ __('E-mail') }}</label>
            <input id="email" name="email" type="email" class="form-control"
                value="{{ old('email', $user->email) }}" required autocomplete="username">
            <x-input-error class="mt-2 text-danger small" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="small text-warning">
                    {{ __('Seu endereço de e-mail não foi verificado.') }}

                    <button form="send-verification" class="btn btn-link p-0 small text-decoration-none">
                        {{ __('Clique aqui para re-enviar o e-mail de verificação.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 small text-success fw-bold">
                    {{ __('Um novo link de verificação foi enviado para o seu endereço de e-mail.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-3 shadow-sm">
                {{ __('Salvar Alterações') }}
            </button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-success small mb-0 fw-medium">
                <i class="bi bi-check-circle me-1"></i>{{ __('Salvo com sucesso!') }}
            </p>
            @endif
        </div>
    </form>
</section>