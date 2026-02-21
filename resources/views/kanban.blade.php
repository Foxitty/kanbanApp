<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white leading-tight">
                {{ $board->name }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-slate-500 hover:text-indigo-600 transition-colors">
                &larr; Voltar aos Meus Quadros
            </a>
        </div>
    </x-slot>

    <div class="py-6 h-[calc(100vh-140px)]">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 h-full">

            <div id="kanban-container" class="flex gap-6 overflow-x-auto pb-4 h-full items-start">

                @foreach($board->categories as $category)
                <div class="flex-shrink-0 w-80 bg-slate-100 dark:bg-slate-800/50 rounded-2xl flex flex-col max-h-full border border-slate-200 dark:border-slate-700">
                    <div class="p-4 flex justify-between items-center">
                        <h3 class="font-black text-slate-700 dark:text-slate-200 uppercase text-xs tracking-widest">{{ $category->name }}</h3>
                        <span class="bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-400 text-[10px] px-2 py-1 rounded-full font-bold">
                            {{ $category->tasks->count() }}
                        </span>
                    </div>

                    <div class="task-list p-3 flex-1 overflow-y-auto space-y-3 min-h-[100px]" data-category-id="{{ $category->id }}">
                        @foreach($category->tasks as $task)
                        <div class="task-card bg-white dark:bg-slate-700 p-4 rounded-xl shadow-sm border border-slate-200 dark:border-slate-600 cursor-grab active:cursor-grabbing hover:border-indigo-500 transition-all" data-task-id="{{ $task->id }}">
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $task->title }}</p>
                            @if($task->description)
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 line-clamp-2">{{ $task->description }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <button class="p-3 text-sm text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 font-bold flex items-center gap-2 transition-colors">
                        <span class="text-lg">+</span> Adicionar Cartão
                    </button>
                </div>
                @endforeach

                <button class="flex-shrink-0 w-80 h-16 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl text-slate-500 font-bold hover:border-indigo-500 hover:text-indigo-500 transition-all">
                    + Nova Coluna
                </button>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.task-list').each(function() {
                new Sortable(this, {
                    group: 'kanban',
                    animation: 150,
                    ghostClass: 'opacity-40',
                    onEnd: function(evt) {
                        const taskId = $(evt.item).data('task-id');
                        const newCategoryId = $(evt.to).data('category-id');

                        $.ajax({
                            url: "{{ route('kanban.reorder') }}",
                            method: "POST",
                            data: {
                                task_id: taskId,
                                category_id: newCategoryId,
                                _token: "{{ csrf_token() }}"
                            }
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>