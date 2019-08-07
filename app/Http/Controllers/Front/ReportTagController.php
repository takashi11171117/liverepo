<?php

namespace App\Http\Controllers\Front;

use App\Http\Resources\Front\ReportTagResource;
use App\Models\ReportTag;
use App\Scoping\Scopes\ReportTagSearchScope;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportTagController extends Controller
{
    public function tagify(Request $request)
    {
        $tags = ReportTag::withScopes($this->scopes())->limit(10)->get();

        return ReportTagResource::collection($tags);
    }

    protected function scopes()
    {
        return [
            'tag' => new ReportTagSearchScope()
        ];
    }
}
