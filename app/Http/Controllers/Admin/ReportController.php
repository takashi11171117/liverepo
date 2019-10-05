<?php

namespace App\Http\Controllers\Admin;

use App\Events\FrontReportPostEvent;
use App\Http\Requests\Admin\Report\Post;
use App\Http\Requests\Admin\Report\Put;
use App\Http\Resources\Admin\ReportIndexResourse;
use App\Http\Resources\Admin\ReportResourse;
use App\Repositories\Contracts\ReportRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    protected $reports;

    public function __construct(ReportRepository $reports)
    {
        $this->reports = $reports;
    }

    /**
     * @param Request $request
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return ReportIndexResourse::collection(
            $this->reports->paginate(
                $request->input('per_page') ?? 20
            )
        );
    }

    /**
     * @throws \Throwable
     */
    public function store(Post $request): void
    {
        event(new FrontReportPostEvent($request));
    }

    public function show(int $id): ReportResourse
    {
        return new ReportResourse($this->reports->findWithRelations($id));
    }

    /**
     * @throws \Throwable
     */
    public function update(Put $request, int $id): void
    {
        event(new FrontReportPostEvent($request, $id));
    }

    public function destroy(int $id): void
    {
        $this->reports->delete($id);
    }
}
