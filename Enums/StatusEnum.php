<?php

namespace Enums;

enum StatusEnum: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case DELETED = 'DELETED';

    public function label(): string
    {
        return StatusEnum::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            StatusEnum::ACTIVE => 'ACTIVE',
            StatusEnum::INACTIVE => 'INACTIVE',
            StatusEnum::DELETED => 'DELETED',
        };
    }
}
