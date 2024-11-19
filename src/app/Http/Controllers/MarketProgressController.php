<?php

namespace App\Http\Controllers;

use App\Models\MarketProgress;
use Illuminate\Http\Request;

class MarketProgressController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-market-progress', ['only' => ['store']]);
        $this->middleware('permission:read-market-progress', ['only' => ['index']]);
        $this->middleware('permission:edit-market-progress', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-market-progress', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $metadata = [
            'title' => 'Market Progress',
            'description' => 'Data Management',
            'submenu' => 'market-progress',
        ];
        $marketProgress = MarketProgress::latest()->get();
        return view('pages.market-progress.market-progress', compact('marketProgress','metadata'));
    }
    
    public function create()
    {
        abort(404);
    }
    
    public function store(Request $request)
    {
        MarketProgress::create([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->back()->with("success", "Data berhasil ditambahkan!");
    }
    
    public function show(MarketProgress $marketProgress)
    {
        abort(404);
    }
    
    public function edit(MarketProgress $marketProgress)
    {
        $metadata = [
            'title' => 'Edit Market Progress',
            'description' => 'Data Management',
            'submenu' => 'market-progress',
        ];
        return view('pages.market-progress.market-progress-edit', compact('marketProgress', 'metadata'));
    }
    
    public function update(Request $request, MarketProgress $marketProgress)
    {
        $marketProgress->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->route('market-progress.index')->with("success", "Data berhasil diperbaharui!");
    }
    
    public function destroy(MarketProgress $marketProgress)
    {
        $marketProgress->delete();
        return redirect()->back()->with("success", "Data berhasil dihapus");
    }
}
