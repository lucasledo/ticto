<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $page       = $request->input('page', 1);
        $perPage    = 20;
        $offset     = ($page - 1) * $perPage;

        $sql = 'SELECT
                    tr.id,
                    employee_person.name AS employee_name,
                    employee_person.position AS position,
                    TIMESTAMPDIFF(YEAR, employee_person.birthdate, CURDATE()) AS age,
                    administrator_person.name AS administrator_name,
                    DATE_FORMAT(tr.time_recorded_at, "%d/%m/%Y %H:%i:%s") AS time_recorded_at
                FROM time_records tr
                JOIN employees employee ON tr.employee_id = employee.id
                JOIN people employee_person ON employee.person_id = employee_person.id
                JOIN administrators admin ON employee.administrator_id = admin.id
                JOIN people administrator_person ON admin.person_id = administrator_person.id
                WHERE 1=1';

        $where = '';

        if ($request->filled('start_date')) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d 00:00:00');
            $where .= " AND tr.time_recorded_at >= '{$start_date}'";
        }

        if ($request->filled('end_date')) {
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d 23:59:59');
            $where .= " AND tr.time_recorded_at <= '{$end_date}'";
        }

        $sql .= $where . " ORDER BY tr.time_recorded_at DESC LIMIT {$perPage} OFFSET {$offset}";
        $timeRecords = DB::select($sql);

        $countSql = 'SELECT COUNT(*) as total FROM time_records tr
                     JOIN employees employee ON tr.employee_id = employee.id
                     JOIN people employee_person ON employee.person_id = employee_person.id
                     JOIN administrators admin ON employee.administrator_id = admin.id
                     JOIN people administrator_person ON admin.person_id = administrator_person.id
                     WHERE 1=1 ' . $where;

        $totalCount  = DB::select($countSql)[0]->total;

        $records = [
            'current_page'  => (int)$page,
            'data'          => $timeRecords,
            'first_page_url'=> route('reports.index', array_merge($request->all(), ['page' => 1])),
            'from'          => $offset + 1,
            'last_page'     => (int)ceil($totalCount / $perPage),
            'last_page_url' => route('reports.index', array_merge($request->all(), ['page' => (int)ceil($totalCount / $perPage)])),
            'next_page_url' => (int)ceil($totalCount / $perPage) > $page ? route('reports.index', array_merge($request->all(), ['page' => $page + 1])) : null,
            'path'          => route('reports.index'),
            'per_page'      => (int)$perPage,
            'prev_page_url' => $page > 1 ? route('reports.index', array_merge($request->all(), ['page' => $page - 1])) : null,
            'to'            => $offset + count($timeRecords),
            'total'         => $totalCount,
        ];

        if($request->ajax() ||$request->wantsJson()){
            return response()->json($records);
        }

        return view('admin.reports.index', compact('records'));
    }
}
