<?php

namespace Models;

interface ModelInterface
{
    public static function tableName(): string;

    public function attributes(): array;
}