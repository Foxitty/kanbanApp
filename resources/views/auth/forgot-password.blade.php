<x-guest-layout>
    <div class="text-center mb-5">
        <div class="d-flex justify-content-center mb-3">
            <div class="logo-box logo-auth-header">K</div>
        </div>
        <h2 class="fw-bolder tracking-tight mb-1">Recuperar Senha</h2>
        <p class="text-muted small">
            Esqueceu sua senha? Sem problemas. Informe seu e-mail e enviaremos um link para você escolher uma nova.
        </p>
    </div>

    @if (session('status'))
    <div class="alert alert-success border-0 shadow-sm small mb-4" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">E-mail de Recuperação</label>
            <input id="email" type="email" name="email"
                class="form-control"
                placeholder="seu@email.com"
                value="{{ old('email') }}" required autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
        </div>

        <button type="submit" class="btn btn-outline-primary w-100 mb-4 shadow-sm py-3">
            Enviar Link de Recuperação
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-decoration-none small fw-bold">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                </svg>
                Voltar para o login
            </a>
        </div>
    </form>
</x-guest-layout>