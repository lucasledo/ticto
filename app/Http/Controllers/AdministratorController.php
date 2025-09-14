<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdministratorRequest;
use App\Http\Requests\UpdateAdministratorRequest;
use App\Models\Administrator;
use App\Services\AdministratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministratorController extends Controller
{
    protected $service;

    public function __construct(AdministratorService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $administrators = Administrator::paginate(20);

        if(request()->ajax() || request()->wantsJson()) {
            return $administrators;
        }

        return view('admin.administrators.index', compact('administrators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.administrators.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdministratorRequest $request)
    {
        try {
            $this->service->create($request->validated(), Auth::user());

            if(request()->ajax() || request()->wantsJson()) {
                return response()->json(['message' => 'Administrador cadastrado com sucesso!'], 201);
            }

            return redirect()->route('administrators.index')->with('success', 'Administrador cadastrado com sucesso!');

        } catch (\Throwable $th) {
            report($th);

            if(request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Erro ao cadastrar administrador.'], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Erro ao cadastrar administrador.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Administrator $administrator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Administrator $administrator)
    {
        return view('admin.administrators.form', compact('administrator'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdministratorRequest $request, Administrator $administrator)
    {
        try {
            $this->service->update($administrator, $request->validated());

            if(request()->ajax() || request()->wantsJson()) {
                return response()->json(['message' => 'Administrador atualizado com sucesso!'], 201);
            }

            return redirect()->route('administrators.index')->with('success', 'Administrador atualizado com sucesso!');

        } catch (\Throwable $th) {
            report($th);

            if(request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Erro ao cadastrar administrador.'], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Erro ao cadastrar administrador.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrator $administrator)
    {
       try {
            $this->service->delete($administrator);

            if(request()->ajax() || request()->wantsJson()) {
                return response()->json(['message' => 'Administrador removido com sucesso!'], 201);
            }

            return redirect()->route('administrators.index')->with('success', 'Administrador removido com sucesso!');

        } catch (\Throwable $th) {
            report($th);

            if(request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Erro ao remover administrador.'], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Erro ao remover administrador.');
        }
    }
}
