<x-app-layout>
    <style>
        .action-btn-hover:hover {
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 4px;
            transform: scale(1.1);
            transition: all 0.2s ease;
        }

        .text-danger.action-btn-hover:hover {
            background-color: rgba(220, 53, 69, 0.1);
        }
    </style>

    <input type="hidden" id="current_user_id" value="{{ auth()->id() }}">

    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-black h3 mb-0 text-truncate">{{ $board->name }}</h1>
                <p class="text-muted small mb-0">Gerencie suas tarefas no quadro</p>
            </div>
            <div class="d-flex gap-2">
                <button onclick="window.location.href='{{ route('dashboard') }}'" class="btn btn-outline-secondary rounded-3 px-4 fw-bold shadow-sm">
                    <i class="fa-solid fa-arrow-left me-2"></i>Voltar
                </button>

                <button onclick="openCategoryModal()" class="btn btn-outline-primary rounded-3 px-4 fw-bold shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i>Nova Coluna
                </button>
            </div>
        </div>

        <div id="kanban-board" class="kanban-container pb-3 overflow-x-auto">
            @foreach($board->categories->sortBy('position') as $category)
            <div class="kanban-column shadow-sm"
                style="border-top-color: {{ $category->color }}"
                data-id="{{ $category->id }}">

                <div class="p-3 d-flex justify-content-between align-items-center column-handle cursor-grab">
                    <h6 class="fw-black text-uppercase small mb-0 tracking-wider text-muted">
                        {{ $category->name }}
                    </h6>
                    <div class="d-flex gap-1">
                        <button onclick='event.stopPropagation(); editCategory(@json($category))'
                            class="btn btn-sm action-btn-hover p-1">
                            <i class="fa-solid fa-pencil" style="font-size: 12px;"></i>
                        </button>
                        <button onclick="event.stopPropagation(); deleteCategory({{ $category->id }}, {{ $category->tasks->count() }})"
                            class="btn btn-sm action-btn-hover p-1 text-danger">
                            <i class="fa-solid fa-trash-can" style="font-size: 12px;"></i>
                        </button>
                    </div>
                </div>

                <div class="task-list px-3 flex-grow-1 overflow-y-auto custom-scrollbar"
                    data-category-id="{{ $category->id }}"
                    style="min-height: 100px;">

                    @foreach($category->tasks->sortBy('position') as $task)
                    <div class="task-card mb-3 shadow-sm"
                        style="--task-color: {{ $task->color }}; cursor: pointer;"
                        data-id="{{ $task->id }}"
                        onclick='openTaskDetails(@json($task->load("user","comments.user")))'>
                        <div class="p-2">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <p class="fw-bold small lh-sm mb-0">{{ $task->title }}</p>

                                @if(auth()->id() == $task->user_id)
                                <button onclick="event.stopPropagation(); deleteTask({{ $task->id }})"
                                    class="btn btn-xs p-1 text-danger border-0 bg-transparent shadow-none action-btn-hover">
                                    <i class="fa-solid fa-trash-can" style="font-size: 10px;"></i>
                                </button>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-light">
                                <span class="text-muted" style="font-size: 10px; font-weight: 600;">
                                    {{ $task->user->name }}
                                </span>
                                <div class="d-flex align-items-center gap-1 text-muted">
                                    <i class="fa-regular fa-comment-dots" style="font-size: 12px;"></i>
                                    <span class="small fw-bold"
                                        id="task-comm-count-{{ $task->id }}">
                                        {{ $task->comments->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="p-3 mt-auto">
                    <button onclick="addTask({{ $category->id }})"
                        class="btn btn-outline-primary w-100 btn-sm rounded-3 fw-bold border-dashed">
                        &#43; Adicionar Card
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @include('kanban.partials.modals')

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const csrfToken = "{{ csrf_token() }}";
            const palette = ['#6366f1', '#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#f97316', '#06b6d4', '#4b5563'];

            function bootKanban() {
                if (window.initKanban) {
                    window.initKanban("{{ $board->id }}", csrfToken, palette);
                } else {
                    setTimeout(bootKanban, 50);
                }
            }
            bootKanban();

            window.localSaveOrder = function() {
                let payload = {
                    categories: [],
                    _token: csrfToken
                };
                document.querySelectorAll('.kanban-column').forEach((column) => {
                    let tasks = [];
                    column.querySelectorAll('.task-card').forEach((task) => {
                        tasks.push(task.dataset.id);
                    });
                    payload.categories.push({
                        id: column.dataset.id,
                        tasks: tasks
                    });
                });
                fetch("{{ route('kanban.reorder') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(payload)
                });
            };

            if (typeof Sortable !== 'undefined') {
                document.querySelectorAll('.task-list').forEach(el => {
                    new Sortable(el, {
                        group: 'tasks',
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        onEnd: function(evt) {
                            if (evt.from !== evt.to || evt.oldIndex !== evt.newIndex) {
                                window.localSaveOrder();
                            }
                        }
                    });
                });

                new Sortable(document.getElementById('kanban-board'), {
                    animation: 150,
                    handle: '.column-handle',
                    ghostClass: 'sortable-ghost',
                    onEnd: function(evt) {
                        if (evt.oldIndex !== evt.newIndex) {
                            window.localSaveOrder();
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>