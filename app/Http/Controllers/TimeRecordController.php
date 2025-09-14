<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Employee;
use App\Models\TimeRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TimeRecord::select([
            'id',
            'employee_id',
            'time_recorded_at',
        ])->with([
            'employee' => function ($q) {
                $q->select(['id', 'person_id', 'administrator_id']);
            },
            'employee.person' => function ($q) {
                $q->select(['id', 'name', 'position', 'birthdate', 'user_id']);
            },
            'employee.person.user' => function ($q) {
                $q->select(['id', 'email']);
            },
            'employee.administrator' => function ($q) {
                $q->select(['id', 'person_id']);
            },
            'employee.administrator.person' => function ($q) {
                $q->select(['id', 'name']);
            },
        ]);

        if ($request->filled('start_date')) {
            $query->whereDate('time_recorded_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('time_recorded_at', '<=', $request->end_date);
        }
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        if ($request->filled('administrator_id')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('administrator_id', $request->administrator_id);
            });
        }

        $timeRecords = $query->orderBy('time_recorded_at', 'DESC')->paginate(20)->withQueryString();

        $employees      = Employee::with('person')->get();
        $administrators = Administrator::with('person')->get();

        if($request->ajax() || $request->wantsJson()){
            return $timeRecords;
        }

        return view('admin.time_record.index', compact('timeRecords', 'employees', 'administrators'));
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
