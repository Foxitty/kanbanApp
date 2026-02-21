<x-guest-layout>
    <div class="text-center mb-5">
        <div class="d-flex justify-content-center mb-3">
            <div class="logo-box logo-auth-header">K</div>
        </div>
        <h2 class="fw-bolder tracking-tight mb-1">Crie sua conta</h2>
        <p class="text-muted small">Comece a organizar suas tarefas hoje mesmo.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nome Completo</label>
            <input id="name" type="text" name="name"
                class="form-control"
                placeholder="Como quer ser chamado?"
                value="{{ old('name') }}" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger small" />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input id="email" type="email" name="email"
                class="form-control"
                placeholder="seu@email.com"
                value="{{ old('email') }}" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input id="password" type="password" name="password"
                class="form-control"
                placeholder="Mínimo 8 caracteres"
                required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                class="form-control"
                placeholder="Repita sua senha"
                required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small" />
        </div>

        <button type="submit" class="btn btn-outline-primary w-100 mb-4 shadow-sm py-3">
            Finalizar Cadastro
        </button>

        <div class="text-center">
            <span class="text-muted small">Já tem uma conta?</span>
            <a href="{{ route('login') }}" class="text-decoration-none small fw-bold ms-1">
                Entrar agora
            </a>
        </div>
    </form>
</x-guest-layout>