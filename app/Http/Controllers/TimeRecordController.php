<?php

namespace App\Http\Controllers;

use App\Models\TimeRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            TimeRecord::create([
                'employee_id'       => Auth::user()->person->employee->id,
                'ip'                => $request->ip(),
                'user_agent'        => $request->userAgent(),
                'time_recorded_at'  => now()
            ]);

            return back()->with('success', 'Ponto registrado com sucesso!');
        } catch (\Throwable $th) {
            report($th);

            if($request->ajax()){
                return response()->json(['error' => 'Erro ao registrar ponto.'], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Erro ao registrar ponto.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TimeRecord $timeRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeRecord $timeRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimeRecord $timeRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeRecord $timeRecord)
    {
        //
    }
}
