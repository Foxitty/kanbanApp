<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function index()
    {
        $boards = Board::with('user')->get();

        return view('dashboard', compact('boards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $board = Board::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'board' => $board
        ]);
    }
}
