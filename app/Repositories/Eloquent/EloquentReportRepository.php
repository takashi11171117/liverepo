<?php

namespace App\Repositories\Eloquent;

use App\Models\Report;
use App\Models\ReportTag;
use App\Models\User;
use App\Repositories\Contracts\ReportRepository;
use App\Repositories\RepositoryAbstract;
use App\Scoping\Scopes\ByCreatedAtScope;
use App\Scoping\Scopes\ReportSearchScope;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentReportRepository extends RepositoryAbstract implements ReportRepository
{
    public function entity()
    {
        return Report::class;
    }

    public function find(int $id)
    {
        $model = $this->entity->with(['report_images', 'report_tags', 'user', 'report_comments'])
                              ->withCount('followers')
                              ->status(config('const.PUBLISH'))
                              ->find($id);

        if (!$model) {
            throw (new ModelNotFoundException())->setModel(
                get_class($this->entity->getModel()), $id
            );
        }

        return $model;
    }

    public function paginate(int $perPage = 10)
    {
        return $this->entity
            ->withScopes([
                'date' => new ByCreatedAtScope(),
                's'    => new ReportSearchScope()
            ])
            ->with(['report_images'])
            ->orderBy('published_at', 'desc')
            ->status(config('const.PUBLISH'))
            ->paginate($perPage);
    }

    public function findListByMonth(string $month)
    {
        return $this->entity->select(DB::raw("count(*) as count, strftime('%Y-%m-%d', published_at) as formatted_published_at"))
                            ->status(config('const.PUBLISH'))
                            ->whereRaw("strftime('%Y-%m', published_at) = :month", ['month' => $month])
                            ->groupBy('formatted_published_at')
                            ->orderBy('formatted_published_at', 'desc')
                            ->get();
    }

    public function findListByDate(string $date): Collection
    {
        $temp_tags = DB::select('SELECT rt.id FROM reports rp
          INNER JOIN report_report_tag rrt
          ON rp.id = rrt.report_id
          INNER JOIN report_tags rt
          ON rrt.report_tag_id = rt.id
          WHERE published_at LIKE ?
          AND rt.taxonomy = "place"
          GROUP BY rt.id', ["%$date%"]);

        $tags = [];
        foreach ($temp_tags as $tag) {
            $tags[] = $tag->id;
        }

        return ReportTag::with([
            'reports',
        ])->whereIn('id', $tags)
                        ->get();
    }

    public function save(User $user, array $properties)
    {
        $report = new Report();
        $report->user()->associate($user)->fill($properties)->save();

        return $report;
    }

    public function syncReportTag(Report $report, array $tags): void
    {
        $tags = array_map(function ($tag) {
            $fTag = ReportTag::firstOrCreate(['name' => $tag['name'], 'taxonomy' => $tag['taxonomy']]);
            return $fTag->id;
        }, $tags);
        $report->report_tags()->sync($tags);
    }

    public function createImages(Report $report, string $path): void
    {
        $report->report_images()->create(['path'=> $path]);
    }
}