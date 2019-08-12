<?php

namespace App\Http\Controllers\Front;

use App\Http\Resources\Front\ReportResource;
use App\Http\Resources\Front\ReportTagIndexResource;
use App\Http\Resources\Front\ReportTagResource;
use App\Models\ReportTag;
use App\Scoping\Scopes\ReportTagSearchScope;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportTagController extends Controller
{
    public function index()
    {
        $tags = ReportTag::paginate(100);

        return ReportTagIndexResource::collection($tags);
    }

    /**
     * @param $id
     * @return ReportTagResource
     */
    public function show(string $name)
    {
        $report_tag  = ReportTag::where('name', $name)->firstOrFail();

        return new ReportTagResource($report_tag);
    }

    public function tagify(Request $request)
    {
        $tags = ReportTag::withScopes($this->scopes())->limit(10)->get();

        return ReportTagIndexResource::collection($tags);
    }

    protected function scopes()
    {
        return [
            'tag' => new ReportTagSearchScope()
        ];
    }
}
