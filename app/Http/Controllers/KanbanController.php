<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Category;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;

class KanbanController extends Controller
{
    public function index(Board $board)
    {
        $board->load([
            'categories' => function ($q) {
                $q->orderBy('position');
            },
            'categories.tasks' => function ($q) {
                $q->orderBy('position');
            },
            'categories.tasks.user',
            'categories.tasks.comments.user'
        ]);

        return view('kanban.index', compact('board'));
    }

    public function showTask(Task $task)
    {
        return response()->json(
            $task->load([
                'user',
                'comments' => function ($q) {
                    $q->with('user', 'replies.user')
                        ->orderBy('created_at');
                }
            ])
        );
    }

    public function storeCategory(Request $request)
    {
        $lastPosition = Category::where('board_id', $request->board_id)
            ->max('position');

        $category = Category::create([
            'name' => $request->name,
            'color' => $request->color ?? '#6366f1',
            'board_id' => $request->board_id,
            'position' => ($lastPosition ?? 0) + 1
        ]);

        return response()->json($category);
    }

    public function updateCategory(Request $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
            'color' => $request->color
        ]);

        return response()->json($category);
    }

    public function destroyCategory(Category $category)
    {
        if ($category->tasks()->count() > 0) {
            return response()->json(['error' => 'Coluna não vazia'], 400);
        }

        $category->delete();

        return response()->json(['success' => true]);
    }

    public function storeTask(Request $request)
    {
        $lastPosition = Task::where('category_id', $request->category_id)
            ->max('position');

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'color' => $request->color,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
            'position' => ($lastPosition ?? 0) + 1
        ]);

        return response()->json($task);
    }

    public function updateTask(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'color' => $request->color
        ]);

        return response()->json($task);
    }

    public function destroyTask(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        $task->delete();

        return response()->json(['success' => true]);
    }

    public function reorder(Request $request)
    {
        foreach ($request->categories as $colIndex => $categoryData) {

            Category::where('id', $categoryData['id'])
                ->update(['position' => $colIndex + 1]);

            foreach ($categoryData['tasks'] as $taskIndex => $taskId) {
                Task::where('id', $taskId)->update([
                    'category_id' => $categoryData['id'],
                    'position' => $taskIndex + 1
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function storeComment(Request $request, Task $task)
    {
        $comment = $task->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id ?: null
        ]);

        return response()->json($comment->load('user'));
    }

    public function updateComment(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        $comment->update(['body' => $request->body]);

        return response()->json($comment->load('user'));
    }

    public function destroyComment(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        $comment->delete();

        return response()->json(['success' => true]);
    }
}
