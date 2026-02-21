import './bootstrap';
import $ from 'jquery';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
window.$ = window.jQuery = $;

$(document).ready(function() {
    const $html = $('html');
    const $icon = $('#theme-icon');

    function updateUI(theme) {
        $icon.text(theme === 'dark' ? '\u2600' : '\u{1F319}');
    }

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    updateUI($html.attr('data-bs-theme'));

    $('#theme-master-toggle').on('click', function() {
        const currentTheme = $html.attr('data-bs-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        $html.attr('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateUI(newTheme);
    });
});

window.setupDashboard = function(token) {
    const modalElement = document.getElementById('boardModal');
    const bsModal = modalElement ? new bootstrap.Modal(modalElement) : null;

    $('#openModalBtn').on('click', function() {
        $('#boardSlug').val('');
        $('#boardName').val('');
        $('#modalTitle').text('Novo Projeto');
        $('#submitBtn').text('Criar');
        if (bsModal) bsModal.show();
    });

    $('#formNewBoard').on('submit', function(e) {
        e.preventDefault();
        const slug = $('#boardSlug').val();
        const name = $('#boardName').val();
        const url = slug ? `/boards/${slug}` : "/boards";
        const method = slug ? "PATCH" : "POST";

        $.ajax({
            url: url,
            method: method,
            data: { name: name, _token: token },
            success: () => location.reload(),
            error: (xhr) => alert('Erro: ' + xhr.responseText)
        });
    });
};

window.editBoard = function(id, name, slug) {
    $('#boardSlug').val(slug);
    $('#boardName').val(name);
    $('#modalTitle').text('Editar Quadro');
    $('#submitBtn').text('Salvar');
    const modal = new bootstrap.Modal('#boardModal');
    modal.show();
};

window.deleteBoard = function(slug, token) {
    if (confirm('Deseja excluir este quadro?')) {
        $.ajax({
            url: `/boards/${slug}`,
            method: "DELETE",
            data: { _token: token },
            success: () => location.reload(),
            error: () => alert('Erro ao excluir.')
        });
    }
};

window.initKanban = function(boardId, csrfToken, palette) {
    let currentTaskObj = null;
    let replyingToId = null;
    const authId = $('#current_user_id').val();
    const catModal = new bootstrap.Modal('#categoryModal');
    const taskModal = new bootstrap.Modal('#createTaskModal');
    const detailsModal = new bootstrap.Modal('#taskDetailsModal');

    window.closeTaskModal = function() {
        detailsModal.hide();
    };

    const renderPalette = (containerId, type) => {
        let html = '';
        palette.forEach(color => {
            html += `
                <label class="color-option me-1">
                    <input type="radio" name="${type}_color" value="${color}" class="btn-check" onchange="$('#${type}Color').val('${color}')">
                    <div class="color-swatch" style="background-color: ${color}; width:28px; height:28px; border-radius:50%; cursor:pointer; border:2px solid #00000000;"></div>
                </label>`;
        });
        $(`#${containerId}`).html(html);
    };

    renderPalette('catPaletteContainer', 'cat');
    renderPalette('taskPaletteContainer', 'newTask');

    window.deleteTask = function(id) {
        if (confirm('Deseja realmente apagar este card?')) {
            $.ajax({
                url: `/tasks/${id}`,
                type: 'POST',
                data: { _method: 'DELETE', _token: csrfToken },
                success: function() {
                    $(`.task-card[data-id="${id}"]`).fadeOut(300, function() { $(this).remove(); });
                    detailsModal.hide();
                },
                error: () => alert('Erro ao excluir.')
            });
        }
    };

    function refreshComments() {
        $.get(`/tasks/${currentTaskObj.id}/json`, (task) => {
            let html = task.comments.length ? '' : '<p class="text-center text-muted small py-4">Sem mensagens ainda.</p>';
            const mainComments = task.comments.filter(c => !c.parent_id).sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
            mainComments.forEach(c => { html += renderCommentNode(c, task.comments, 0); });
            $('#commentsList').html(html);
            $(`#task-comm-count-${currentTaskObj.id}`).text(task.comments.length);
            cancelReply();
            const list = document.getElementById('commentsList');
            if(list) list.scrollTop = list.scrollHeight;
        });
    }

    function renderCommentNode(comment, allComments, level) {
        const isMe = String(comment.user_id) === String(authId);
        const time = new Date(comment.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const replies = allComments.filter(r => r.parent_id === comment.id).sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        let actions = !isMe ? `<i class="fa-solid fa-reply action-icon me-2" onclick="setReply(${comment.id}, '${comment.user.name}')"></i>` : '';
        if (isMe && replies.length === 0) {
            actions += `<i class="fa-solid fa-pencil action-icon me-2" onclick="enableCommentEdit(${comment.id})"></i>
                        <i class="fa-solid fa-trash-can action-icon text-danger" onclick="deleteComment(${comment.id})"></i>`;
        }
        const badgeHtml = comment.parent_id ? `<div class="reply-to-badge">&#10551; Resposta para <strong>${allComments.find(c => c.id === comment.parent_id)?.user.name}</strong></div>` : '';
        let nodeHtml = `<div class="${level > 0 ? 'comment-node reply-node' : 'comment-node'} ${isMe ? 'my-comment' : ''} mb-3">
                ${badgeHtml}<div class="comment-bubble">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="comment-user">${comment.user.name}</span>
                        <span class="comment-date">${time}</span>
                    </div>
                    <div id="comment-body-${comment.id}" class="comment-text-content text-break">${comment.body}</div>
                    <div class="mt-2 d-flex align-items-center justify-content-end" style="height: 14px;">${actions}</div>
                </div></div>`;
        replies.forEach(reply => { nodeHtml += renderCommentNode(reply, allComments, level + 1); });
        return nodeHtml;
    }

    window.enableCommentEdit = (id) => {
        const $box = $(`#comment-body-${id}`);
        const currentText = $box.text();
        $box.html(`
            <textarea id="edit-area-${id}" class="form-control form-control-sm border-0 shadow-sm mb-2" rows="2" style="font-size: 12px;">${currentText}</textarea>
            <div class="d-flex gap-2 justify-content-end">
                <button onclick="refreshComments()" class="btn btn-outline-secondary btn-xs text-muted p-0" style="text-decoration:none; font-size:10px;">Cancelar</button>
                <button onclick="saveCommentEdit(${id})" class="btn btn-outline-primary btn-xs px-2" style="font-size:10px; padding:2px 8px;">Salvar</button>
            </div>
        `);
        $(`#edit-area-${id}`).focus();
    };

    window.saveCommentEdit = (id) => {
        const body = $(`#edit-area-${id}`).val().trim();
        if(!body) return;
        $.ajax({ url: `/comments/${id}`, type: 'PATCH', data: { body, _token: csrfToken }, success: () => refreshComments() });
    };

    window.setReply = (id, name) => {
        replyingToId = id;
        $('#replyIndicator').html(`
            <div class="d-flex justify-content-between align-items-center w-100">
                <span><i class="fa-solid fa-reply me-2"></i>Respondendo a <b>${name}</b></span>
                <i class="fa-solid fa-xmark cursor-pointer" onclick="cancelReply()"></i>
            </div>
        `).fadeIn(200);
        $('#commentInput').focus();
    };

    window.cancelReply = () => {
        replyingToId = null;
        $('#replyIndicator').hide();
    };

    window.sendComment = () => {
        const body = $('#commentInput').val().trim();
        if(!body) return;
        $.post(`/tasks/${currentTaskObj.id}/comments`, { body, parent_id: replyingToId, _token: csrfToken }, () => {
            $('#commentInput').val('');
            refreshComments();
        });
    };

    window.deleteComment = (id) => {
        if(confirm('Apagar esta mensagem?')) $.post(`/comments/${id}`, { _method: 'DELETE', _token: csrfToken }, () => refreshComments());
    };

    window.openCategoryModal = () => { $('#editCatId').val(''); $('#categoryForm')[0].reset(); $('#catModalTitle').text('Nova Coluna'); catModal.show(); };
    window.editCategory = (cat) => { $('#editCatId').val(cat.id); $('#catName').val(cat.name); $('#catColor').val(cat.color); $('#catModalTitle').text('Editar Coluna'); catModal.show(); };

    window.deleteCategory = (id, count) => {
        if (count > 0) return alert('Remova os cards antes de excluir a coluna.');
        if (confirm('Excluir esta coluna?')) $.post(`/categories/${id}`, { _method: 'DELETE', _token: csrfToken }, () => location.reload());
    };

    window.addTask = (id) => { $('#taskCategoryId').val(id); $('#createTaskForm')[0].reset(); taskModal.show(); };

    window.openTaskDetails = (task) => {
        currentTaskObj = task;
        const isOwner = String(task.user_id) === String(authId);
        $('#editTaskTitle').val(task.title).prop('disabled', !isOwner);
        $('#editTaskDescription').val(task.description).prop('disabled', !isOwner);
        $('#btnSaveTask').toggle(isOwner);
        let paletteHtml = '';
        palette.forEach(color => {
            paletteHtml += `
                <label class="color-option me-1">
                    <input type="radio" name="editTask_color" value="${color}" class="btn-check" ${color === task.color ? 'checked' : ''} ${!isOwner ? 'disabled' : ''} onchange="updateTaskColor('${color}')">
                    <div class="color-swatch" style="background-color: ${color}; width:28px; height:28px; border-radius:50%; cursor:pointer; border:2px solid #00000000;"></div>
                </label>`;
        });
        $('#editTaskPalette').html(paletteHtml);
        $('#editTaskColor').val(task.color);
        updateTaskColor(task.color);
        refreshComments();
        detailsModal.show();
    };

    window.saveTaskDetails = () => {
        $.ajax({
            url: `/tasks/${currentTaskObj.id}`,
            type: 'PATCH',
            data: {
                title: $('#editTaskTitle').val(),
                description: $('#editTaskDescription').val(),
                color: $('#editTaskColor').val(),
                _token: csrfToken
            },
            success: () => location.reload()
        });
    };

    window.updateTaskColor = (color) => {
        $('#editTaskColor').val(color);
        $('#taskModalAccent').css('background-color', color);
        const modalContent = document.querySelector('#taskDetailsModal .modal-content');
        if (modalContent) modalContent.style.setProperty('border', `3px solid ${color}`, 'important');
    };

    $('#categoryForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editCatId').val();
        $.ajax({
            url: id ? `/categories/${id}` : "/categories",
            type: id ? 'PATCH' : 'POST',
            data: { name: $('#catName').val(), color: $('#catColor').val(), board_id: boardId, _token: csrfToken },
            success: () => location.reload()
        });
    });

    $('#createTaskForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        $.post("/tasks", {
            title: $('#newTaskTitle').val(),
            description: $('#newTaskDescription').val(),
            color: $('#newTaskColor').val(),
            category_id: $('#taskCategoryId').val(),
            _token: csrfToken
        }, () => location.reload());
    });
};