<?php

namespace App\Http\Controllers\Front;

use App\Models\ReportComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportCommentController extends Controller
{
    public function store(Request $request)
    {
        $args = $request->only('body', 'report_id');
        $args['user_id'] = \Auth::id();

        ReportComment::create($args);

        return response()->json(['result' => true]);
    }
}
