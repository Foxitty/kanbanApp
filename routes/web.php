<?php

use App\Http\Controllers\KanbanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Board;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redireciona a raiz para o dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {

    //Dashboard
    Route::get('/dashboard', function () {
        $boards = Board::with('user')->latest()->get();
        return view('kanban.dashboard', compact('boards'));
    })->name('dashboard');

    //Perfil     
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Quadro
    Route::post('/boards', function (Request $request) {
        $request->validate(['name' => 'required|string|max:255']);

        $board = Board::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '_'),
            'user_id' => auth()->id()
        ]);

        return response()->json($board);
    })->name('boards.store');
    Route::patch('/boards/{board}', function (Request $request, Board $board) {
        if ($board->user_id !== auth()->id()) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        $request->validate(['name' => 'required|string|max:255']);

        $board->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '_')
        ]);

        return response()->json($board);
    })->name('boards.update');
    Route::delete('/boards/{board}', function (Board $board) {
        if ($board->user_id !== auth()->id()) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        $board->delete();
        return response()->json(['success' => true]);
    })->name('boards.destroy');

    // Reordenar Cards/Colunas
    Route::post('/kanban/reorder', [KanbanController::class, 'reorder'])->name('kanban.reorder');

    //Coluna
    Route::get('/kanban/{board}', [KanbanController::class, 'index'])->name('kanban.index');
    Route::post('/categories', [KanbanController::class, 'storeCategory'])->name('categories.store');
    Route::patch('/categories/{category}', [KanbanController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [KanbanController::class, 'destroyCategory'])->name('categories.destroy');

    //Card
    Route::post('/tasks', [KanbanController::class, 'storeTask'])->name('tasks.store');
    Route::patch('/tasks/{task}', [KanbanController::class, 'updateTask'])->name('tasks.update');
    Route::delete('/tasks/{task}', [KanbanController::class, 'destroyTask'])->name('tasks.destroy');
    Route::get('/tasks/{task}/json', [App\Http\Controllers\KanbanController::class, 'showTask']);

    //comentario
    Route::post('/tasks/{task}/comments', [KanbanController::class, 'storeComment'])->name('comments.store');
    Route::patch('/comments/{comment}', [KanbanController::class, 'updateComment'])->name('comments.update');
    Route::delete('/comments/{comment}', [KanbanController::class, 'destroyComment'])->name('comments.destroy');
});

require __DIR__ . '/auth.php';
