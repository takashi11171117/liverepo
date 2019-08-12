<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FollowReport;
use App\Models\Report;
use Illuminate\Http\Request;

class FollowReportController extends Controller
{
    public function store(Request $request)
    {
        $followedReport = Report::findOrFail($request->input('id'));
        FollowReport::firstOrCreate([
            'user_id' => \Auth::id(),
            'report_id' => $followedReport->id,
        ]);
        return response()->json(['result' => true]);
    }

    public function destroy($id)
    {
        $followedReport = Report::findOrFail($id);
        $user = \Auth::user();
        $user->followReports()->detach($followedReport->id);
        return response()->json(['result' => true]);
    }

    public function isFollowing($id)
    {
        $user = \Auth::user();
        $follow = $user->followReports()->where('report_id', $id)->first(['id']);
        return response()->json(['result' => (boolean) $follow]);
    }
}
