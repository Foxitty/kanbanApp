<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-body p-4">
                <h4 id="catModalTitle" class="fw-black mb-4">Editar Coluna</h4>
                <form id="categoryForm">
                    <input type="hidden" id="editCatId">
                    <div class="mb-3">
                        <label class="form-label-xs">Nome da Coluna</label>
                        <input type="text" id="catName" class="form-control shadow-sm" placeholder="Ex: A fazer" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label-xs">Cor da Coluna</label>
                        <div class="palette-container" id="catPaletteContainer"></div>
                        <input type="hidden" id="catColor" value="#6366f1">
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary fw-bold" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-outline-primary px-4 shadow-sm">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-body p-4">
                <h4 class="fw-black mb-4">Novo Card</h4>
                <form id="createTaskForm">
                    <input type="hidden" id="taskCategoryId">
                    <div class="mb-3">
                        <label class="form-label-xs">Título</label>
                        <input type="text" id="newTaskTitle" class="form-control shadow-sm" placeholder="O que precisa ser feito?" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-xs">Descrição</label>
                        <textarea id="newTaskDescription" class="form-control shadow-sm" rows="3" placeholder="Detalhes (opcional)"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label-xs">Prioridade (Cor)</label>
                        <div class="palette-container" id="taskPaletteContainer"></div>
                        <input type="hidden" id="newTaskColor" value="#6366f1">
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary fw-bold" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-outline-primary px-4 shadow-sm">Criar Card</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="taskDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4 overflow-hidden">
            <div id="taskModalAccent" style="height: 35px; width: 100%;">
                <div class="task-modal-close" onclick="closeTaskModal()">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>

            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-7 p-4 border-end bg-white">
                        <div class="mb-4">
                            <label class="form-label-xs">Título da Tarefa</label>
                            <input type="text" id="editTaskTitle" class="form-control task-title-input h5" placeholder="Título da Tarefa">
                        </div>

                        <div class="mb-4">
                            <label class="form-label-xs">Prioridade & Cor</label>
                            <div id="editTaskPalette" class="d-flex flex-wrap gap-2 p-2 bg-light rounded-3"></div>
                            <input type="hidden" id="editTaskColor">
                        </div>

                        <div class="mb-3">
                            <label class="form-label-xs">Descrição</label>
                            <textarea id="editTaskDescription" class="description-editor w-100" rows="6" placeholder="Descreva a tarefa..."></textarea>
                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                <button id="btnSaveTask" onclick="saveTaskDetails()" class="btn btn-outline-primary px-4 fw-bold shadow-sm">Salvar Alterações</button>
                                <button type="button" class="btn btn-outline-secondary fw-bold px-3" data-bs-dismiss="modal">Fechar</button>
                            </div>
                            <button id="btnDeleteTaskModal" onclick="deleteTask(currentTaskObj.id)" class="btn btn-outline-danger text-danger p-0" style="display: none;">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-5 d-flex flex-column bg-light-subtle p-4" style="min-height: 500px; background-color: #f8f9fa;">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-black text-uppercase small m-0 tracking-wider">Discussão</h6>
                            <i class="fa-solid fa-comments text-muted"></i>
                        </div>

                        <div id="commentsList" class="custom-scrollbar flex-grow-1 mb-3 pe-2 discussion-wrapper" style="overflow-y: auto; max-height: 380px;">
                        </div>

                        <div id="replyIndicator" class="alert alert-info py-2 px-3 mb-2 rounded-3 border-0 shadow-sm" style="display: none; font-size: 11px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div id="replyIndicatorContent"></div>
                                <i class="fa-solid fa-xmark cursor-pointer" onclick="cancelReply()"></i>
                            </div>
                        </div>

                        <div class="comment-input-pill bg-white shadow-sm border d-flex align-items-center px-3 py-2 rounded-pill">
                            <input type="text" id="commentInput" class="border-0 flex-grow-1 outline-none" style="font-size: 13px; outline: none;" placeholder="Escreva um comentário...">
                            <button onclick="sendComment()" class="btn btn-outline-primary btn-send-circle rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-paper-plane" style="font-size: 12px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>