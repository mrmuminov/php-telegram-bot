<?php

namespace Repositories;

use Models\BaseModel;

interface RepositoryInterface
{
    public static function beforeSave(): void;

    public static function afterSave(): void;

    public static function beforeDelete(): void;

    public static function afterDelete(): void;

    public function save(self $model);

    public function delete(self $model);
}