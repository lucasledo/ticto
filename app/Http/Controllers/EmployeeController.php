<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    protected $service;

    public function __construct(EmployeeService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::paginate(20);
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employees.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            $this->service->createEmployee($request->validated(), Auth::user());

            if(request()->ajax()) {
                return response()->json(['message' => 'Funcionário cadastrado com sucesso!'], 201);
            }

            return redirect()->route('employees.index')->with('success', 'Funcionário cadastrado com sucesso!');

        } catch (\Throwable $th) {
            report($th);

            if(request()->ajax()) {
                return response()->json(['error' => 'Erro ao cadastrar funcionário.'], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Erro ao cadastrar funcionário.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('admin.employees.form', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            $this->service->updateEmployee($employee, $request->validated());

            if(request()->ajax()) {
                return response()->json(['message' => 'Funcionário atualizado com sucesso!'], 201);
            }

            return redirect()->route('employees.index')->with('success', 'Funcionário atualizado com sucesso!');

        } catch (\Throwable $th) {
            report($th);

            if(request()->ajax()) {
                return response()->json(['error' => 'Erro ao cadastrar funcionário.'], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Erro ao cadastrar funcionário.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {

            $this->service->deleteEmployee($employee);

            if(request()->ajax()) {
                return response()->json(['message' => 'Funcionário removido com sucesso!'], 201);
            }

            return redirect()->route('employees.index')->with('success', 'Funcionário removido com sucesso!');

        } catch (\Throwable $th) {
            report($th);

            if(request()->ajax()) {
                return response()->json(['error' => 'Erro ao remover funcionário.'], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Erro ao remover funcionário.');
        }
    }
}
