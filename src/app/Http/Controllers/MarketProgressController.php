<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\MarketProgress;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MarketProgressController extends Controller
{
    
    public function index()
    {
        $marketProgress = MarketProgress::latest()->get();
        return view('pages.market-progress.market-progress', compact('marketProgress'));
    }
    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        MarketProgress::create([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->back()->with("success", "Data berhasil ditambahkan!");
    }

    /**
     * Display the specified resource.
     */
    public function show(MarketProgress $marketProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MarketProgress $marketProgress)
    {
        return view('pages.market-progress.market-progress-edit', compact('marketProgress'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MarketProgress $marketProgress)
    {
        $marketProgress->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->route('market-progress.index')->with("success", "Data berhasil diperbaharui!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketProgress $marketProgress)
    {
        $marketProgress->delete();
        return redirect()->back()->with("success", "Data berhasil dihapus");
    }
}
