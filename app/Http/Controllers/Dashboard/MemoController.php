<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Memo;
use Illuminate\Http\Request;
use Redot\Http\Controllers\Controller;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.memos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.memos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
            'content' => ['nullable', 'string'],
            'attachments' => ['nullable', 'json'],
        ]);

        // Append the authenticated admin id to the memo
        $validated['admin_id'] = auth('admins')->id();

        Memo::create($validated);

        return $this->created(__('Memo'), 'dashboard.memos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Memo $memo)
    {
        return view('dashboard.memos.show', [
            'memo' => $memo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Memo $memo)
    {
        return view('dashboard.memos.edit', [
            'memo' => $memo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Memo $memo)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
            'content' => ['nullable', 'string'],
            'attachments' => ['nullable', 'json'],
        ]);

        $memo->update($validated);

        return $this->updated(__('Memo'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Memo $memo)
    {
        $memo->delete();

        return $this->deleted(__('Memo'));
    }
}
