<?php

namespace App\Services\Model\Traits;

trait CrudService
{
    public function save(array $data, $modelObj)
    {
        $model = get_class($modelObj);

        $modelObj = $model::updateOrCreate([
            'id' => optional($modelObj)->id,
        ], $data);

        return $modelObj;
    }
}
