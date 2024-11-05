<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Workplan;
use App\Models\MarketProgress;
use Illuminate\Http\Request;
use App\Models\ProgressWorkplan;

class ProgressWorkplanController extends Controller
{
    
    public function index()
    {
        //
    }
    
    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {
        $now = Carbon::now();
        $year = $now->format('y');
        $month = $now->format('m');

        $latestProgressWorkplan = ProgressWorkplan::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->orderByDesc('code_progress')
            ->first();

        if ($latestProgressWorkplan) {
            $latestCode = substr($latestProgressWorkplan->code_progress, -3);
            $newCode = str_pad((int)$latestCode + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newCode = '001';
        }

        $fullCode = "PW-{$year}{$month}{$newCode}";

        Workplan::find($request->workplan_id)->update([
            'market_progress_id' => $request->market_progress,
            'status' => 1, //progress
            'code_latest_progress' => $fullCode
        ]);

        $workplan = Workplan::find($request->workplan_id);

        ProgressWorkplan::create([
            'code_progress' => $fullCode,
            'date_progress' => $request->date_progress,
            'user_id' => $workplan->sales_id,
            'customer_id' => $workplan->customer_id,
            'workplan_id' => $request->workplan_id,
            'market_progress_id' => $request->market_progress,
            'issue' => $request->issue,
            'next_action' => $request->next_action,
        ]);

        return redirect()->back()->with('success', 'Progress workplan telah ditambahkan!');
    }
    
    public function show(string $id)
    {
        //
    }
    
    public function edit(ProgressWorkplan $progressWorkplan)
    {
        $marketProgress = MarketProgress::get();
        return view('pages.workplan.progress.progress-edit', compact('progressWorkplan','marketProgress'));
    }
    
    public function update(Request $request, ProgressWorkplan $progressWorkplan)
    {
        $workplan = Workplan::find($progressWorkplan->workplan_id);
        //check if code progress from workplan and progress workplan same, then update
        if($workplan->code_latest_progress == $progressWorkplan->code_progress) $workplan->update(['market_progress_id' => $request->market_progress]);
        $progressWorkplan->update([
            'date_progress' => $request->date_progress,
            'market_progress_id' => $request->market_progress,
            'issue' => $request->issue,
            'next_action' => $request->next_action,
        ]);

        return redirect()->route('workplan.edit', $progressWorkplan->workplan_id)->with('success', 'Progress workplan telah diperbaharui!');
    }

    public function destroy(ProgressWorkplan $progressWorkplan)
    {
        try {
            $data = Workplan::find($progressWorkplan->workplan_id);
            //check if code progress from workplan and progress workplan not same, then delete
            if($data->code_latest_progress != $progressWorkplan->code_progress) {
                $progressWorkplan->delete();
                return redirect()->back()->with('success', 'Progress workplan telah dihapus!');
            } else {
                return redirect()->back()->with('error', 'Data terbaru tidak dapat di hapus!');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
