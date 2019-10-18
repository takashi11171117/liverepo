<?php

namespace App\Http\Controllers\Front;

use App\Http\Resources\Front\ReportTagIndexResource;
use App\Repositories\Contracts\ReportTagRepository;
use App\Http\Resources\Front\ReportTagResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportTagController extends Controller
{
    protected $report_tags;

    public function __construct(ReportTagRepository $report_tags)
    {
        $this->report_tags = $report_tags;
    }

    public function index()
    {
        return ReportTagIndexResource::collection(
            $this->report_tags->paginate(100)
        );
    }

    public function show(string $name): ReportTagResource
    {
        return new ReportTagResource(
            $this->report_tags->findWhereFirst('name', $name)
        );
    }

    public function tagify(): AnonymousResourceCollection
    {
        // TODO
        return ReportTagResource::collection(
            $this->report_tags->tagify()
        );
    }
}
