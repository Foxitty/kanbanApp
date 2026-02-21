<section>
    <header class="mb-4">
        <h2 class="fw-bold h5 text-danger mb-1">
            {{ __('Excluir Conta') }}
        </h2>

        <p class="text-muted small">
            {{ __('Uma vez que sua conta for excluída, todos os seus recursos e dados serão permanentemente removidos. Antes de excluir, por favor, baixe qualquer dado que deseje manter.') }}
        </p>
    </header>

    <button
        type="button"
        class="btn btn-danger px-4 py-2 fw-bold rounded-3 shadow-sm"
        data-bs-toggle="modal"
        data-bs-target="#confirmUserDeletionModal">
        {{ __('Excluir Minha Conta') }}
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                    @csrf
                    @method('delete')

                    <div class="modal-header border-0 pb-0">
                        <h5 class="fw-black text-dark mb-0" id="deleteModalLabel">
                            {{ __('Você tem certeza que deseja excluir sua conta?') }}
                        </h5>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted small mb-4">
                            {{ __('Uma vez excluída, não haverá volta. Por favor, insira sua senha para confirmar que você realmente deseja encerrar sua conta permanentemente.') }}
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold text-uppercase">{{ __('Senha') }}</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control"
                                placeholder="{{ __('Sua senha de confirmação') }}"
                                required>
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-danger small" />
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">
                            {{ __('Cancelar') }}
                        </button>

                        <button type="submit" class="btn btn-danger rounded-3 px-4 fw-bold">
                            {{ __('Confirmar Exclusão') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>