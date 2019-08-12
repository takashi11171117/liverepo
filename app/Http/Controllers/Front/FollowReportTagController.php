<?php

namespace App\Http\Controllers\Front;

use App\Models\FollowReportTag;
use App\Models\ReportTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowReportTagController extends Controller
{
    public function store(Request $request)
    {
        $followedReportTag = ReportTag::findOrFail($request->input('id'));
        FollowReportTag::firstOrCreate([
            'user_id' => \Auth::id(),
            'report_tag_id' => $followedReportTag->id,
        ]);
        return response()->json(['result' => true]);
    }

    public function destroy($id)
    {
        $followedReportTag = ReportTag::findOrFail($id);
        $user = \Auth::user();
        $user->followReportTags()->detach($followedReportTag->id);
        return response()->json(['result' => true]);
    }

    public function isFollowing($id)
    {
        $user = \Auth::user();
        $follow = $user->followReportTags()->where('report_tag_id', $id)->first(['id']);
        return response()->json(['result' => (boolean) $follow]);
    }
}
