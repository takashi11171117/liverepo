<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\ReportTag;
use App\Models\User;
use App\Repositories\Contracts\AdminRepository;
use App\Repositories\RepositoryAbstract;
use App\Scoping\Scopes\AdminSearchScope;
use DB;
use Illuminate\Database\Eloquent\Collection;

class EloquentAdminRepository extends RepositoryAbstract implements AdminRepository
{
    public function entity()
    {
        return Admin::class;
    }

    public function paginate(int $perPage = 10)
    {
        return $this->entity
            ->withScopes([
                's'    => new AdminSearchScope()
            ])
            ->paginate($perPage);
    }

    public function findListByMonth(string $month)
    {
        return $this->entity->select(DB::raw("count(*) as count, strftime('%Y-%m-%d', published_at) as formatted_published_at"))
                            ->status((config('const.REPORT_STATUS'))['publish'])
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

    public function save(User $user, array $properties, int $id)
    {
        $model = $this->entity->firstOrNew(['id' => $id])
                              ->user()
                              ->associate($user)
                              ->fill($properties);

        $id === 0 ? $model->save() : $model->update();

        return $model;
    }

    public function draft(int $id)
    {
        $model = $this->find($id);
        $params = array(
            'status' => (config('const.REPORT_STATUS'))['draft']
        );
        return $model->fill($params)->save();
    }

    public function delete(int $id)
    {
        $model = $this->find($id);
        $params = array(
            'status' => (config('const.REPORT_STATUS'))['trash']
        );
        $model->fill($params)->save();
        return $model->delete();
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
        $report->report_images()->create(['path' => $path]);
    }
}