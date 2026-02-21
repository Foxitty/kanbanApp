<x-guest-layout>
    <div class="text-center mb-5">
        <div class="d-flex justify-content-center mb-3">
            <div class="logo-box" style="width: 50px; height: 50px; font-size: 1.8rem;">K</div>
        </div>
        <h2 class="fw-bolder tracking-tight mb-1">Bem-vindo</h2>
        <p class="text-muted small">Acesse seu painel de tarefas para continuar.</p>
    </div>

    @if (session('status'))
    <div class="alert alert-success border-0 shadow-sm small mb-4" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input id="email" type="email" name="email"
                class="form-control"
                placeholder="seu@email.com"
                value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <label for="password" class="form-label">Senha</label>
                @if (Route::has('password.request'))
                <a class="text-decoration-none small fw-bold" href="{{ route('password.request') }}">
                    Esqueceu?
                </a>
                @endif
            </div>
            <input id="password" type="password" name="password"
                class="form-control"
                placeholder="Sua senha secreta"
                required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label text-muted small">
                    Manter conectado
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-outline-primary w-100 mb-4 shadow-sm py-3">
            Entrar no Sistema
        </button>

        <div class="text-center">
            <span class="text-muted small">Novo por aqui?</span>
            <a href="{{ route('register') }}" class="text-decoration-none small fw-bold ms-1">
                Crie sua conta
            </a>
        </div>
    </form>
</x-guest-layout>