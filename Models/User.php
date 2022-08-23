<?php

namespace Models;


use Enums\StatusEnum;

class User extends BaseModel
{
    public ?int $id;
    public int $chat_id;
    public ?string $step;
    public ?string $language;
    public string $status;
    public int $created_at;

    public static function create(
        int        $chat_id,
        ?int       $id = null,
        ?string    $step = null,
        ?string    $language = null,
        ?int       $created_at = null,
        StatusEnum $status = StatusEnum::ACTIVE,
    ): User
    {
        $model = new self();
        if (!empty($id)) {
            $model->id = $id;
        }
        $model->chat_id = $chat_id;
        $model->step = $step;
        $model->language = $language;
        $model->status = $status->label();
        $model->created_at = $created_at;
        return $model;
    }

    public function attributes(): array
    {
        return [
            'id' => $this->id,
            'chat_id' => $this->chat_id,
            'step' => $this->step,
            'language' => $this->language,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }

    public static function tableName(): string
    {
        return 'user';
    }
}