<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Report;
use Storage;
use DB;

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
     * @param Request $request
     * @return mixed
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $params = $request->all();
        $report = new Report;
        $images = $request->file('images');

        DB::beginTransaction();
        try {
            $report->fill($params)->save();

            $disk = Storage::disk('s3');

            $file = $images[0];
            $extension = $images[0]->getClientOriginalExtension();
            $filename = $report->id . '_01' . ".$extension";

            $image = \Image::make($file)
                           ->resize(1024, null, function ($constraint) {
                               $constraint->aspectRatio();
                           });
            $disk->put('report_images/' . $filename, (string) $image->encode());

            $image = \Image::make($file)
                           ->fit(300, 300);
            $disk->put('report_images/thumb-' . $filename, (string) $image->encode());

            $report->report_images()->create(['path'=> $filename]);
            DB::commit();

            return response()->json($report, 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(null, 200);
        }
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
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Throwable
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();
        $report = Report::find($id);
        $images = $request->file('images');

        DB::beginTransaction();
        try {
            $report->fill($params)->save();

            $disk = Storage::disk('s3');

            $file = $images[0];
            $extension = $images[0]->getClientOriginalExtension();
            $filename = $report->id . '_01' . ".$extension";

            $image = \Image::make($file)
                           ->resize(1024, null, function ($constraint) {
                               $constraint->aspectRatio();
                           });
            $disk->put('report_images/' . $filename, (string) $image->encode());

            $image = \Image::make($file)
                           ->fit(300, 300);
            $disk->put('report_images/thumb-' . $filename, (string) $image->encode());

            $report->report_images()->create(['path'=> $filename]);
            DB::commit();

            return response()->json($report, 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(null, 200);
        }
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
