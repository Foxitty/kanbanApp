<x-app-layout>
    <div class="container py-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                <h1 class="fw-black h2 mb-1">Projetos Ativos</h1>
                <p class="text-muted mb-0">Gerencie todos os quadros de tarefas</p>
            </div>
            <button id="openModalBtn" class="btn btn-outline-primary shadow-sm px-4 py-2 rounded-3 fw-bold">
                + Novo Quadro
            </button>
        </div>

        <div class="row g-4">
            @forelse($boards ?? [] as $board)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="auth-card card-board h-100 position-relative border shadow-sm p-4">

                    @if($board->user_id === auth()->id())
                    <div class="position-absolute top-0 end-0 p-3 d-flex gap-2">
                        <button onclick="editBoard({{ $board->id }}, '{{ $board->name }}', '{{ $board->slug }}')"
                            class="btn btn-sm btn-light border rounded-3 text-primary shadow-sm">
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                        <button onclick="deleteBoard('{{ $board->slug }}', '{{ csrf_token() }}')"
                            class="btn btn-sm btn-light border rounded-3 text-danger shadow-sm">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    @endif

                    <div class="mt-3">
                        <div class="logo-box mb-3" style="width: 42px; height: 42px; font-size: 1rem;">K</div>
                        <h4 class="fw-bold mb-1">{{ $board->name }}</h4>
                        <p class="text-muted small mb-4">Por: {{ $board->user->name }}</p>

                        <a href="{{ route('kanban.index', $board->slug) }}" class="btn btn-link p-0 fw-bold text-decoration-none d-flex align-items-center gap-2">
                            Acessar Quadro →
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 border rounded-5 bg-light">
                <p class="text-muted mb-0">Nenhum quadro criado ainda.</p>
            </div>
            @endforelse
        </div>
    </div>

    <div class="modal fade" id="boardModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-body p-4">
                    <h3 id="modalTitle" class="fw-black mb-4">Novo Projeto</h3>
                    <form id="formNewBoard">
                        <input type="hidden" id="boardSlug">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Nome do Quadro</label>
                            <input type="text" id="boardName" class="form-control py-2" placeholder="Ex: Marketing" required>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" id="submitBtn" class="btn btn-outline-primary px-4">Criar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.setupDashboard('{{ csrf_token() }}');
        });
    </script>
</x-app-layout>