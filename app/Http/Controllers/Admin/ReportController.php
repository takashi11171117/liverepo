<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Report;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 20;
        if ($request->input('per_page') !== null) {
            $perPage = (int) $request->input('per_page');
        }

        $query = Report::query();
        if (!empty($request->input('s'))) {
            $s = $request->input('s');
            $query->where('title','like','%' . $s . '%', 'or');
            $query->where('content','like','%' . $s . '%', 'or');
        }

        $reports = $query->paginate($perPage);

        return response()->json($reports, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $report = new Report;

        $report->fill($request->all())->save();

        return response()->json($report, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Report::find($id);
        return response()->json($admin, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $report = Report::find($id);

        $report->fill($request->all())->save();

        return response()->json($report, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Report::destroy($id);

        $args = [];

        $query = $request->query();

        if (array_key_exists('page', $query)) {
            $args['page'] = $request->page;
        }

        if (array_key_exists('per_page', $query)) {
            $args['per_page'] = $request->per_page;
        }

        if (array_key_exists('s', $query)) {
            $args['s'] = $request->s;
        }

        return redirect()->route('admin.report.index', $args, 301);
    }
}
