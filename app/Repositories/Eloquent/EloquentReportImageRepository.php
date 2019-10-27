<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ReportImageRepository;
use App\Repositories\RepositoryAbstract;
use App\Models\ReportImage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentReportImageRepository extends RepositoryAbstract implements ReportImageRepository
{
    public function entity()
    {
        return ReportImage::class;
    }

    public function findByName(string $name)
    {
        $model = $this->entity->where('path','LIKE','%'.$name.'%')->first();

        if (!$model) {
            throw (new ModelNotFoundException())->setModel(
                get_class($this->entity->getModel())
            );
        }

        return $model;
    }
}