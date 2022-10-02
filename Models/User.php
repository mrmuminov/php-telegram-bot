<?php

namespace Models;

/**
 * @property integer $id
 * @property integer $chat_id
 * @property string $step
 * @property string $phone
 * @property string $username
 * @property string $language
 * @property integer $created_at
 * @property string $status
 */
class User extends BaseModel
{
    public static function tableName(): string
    {
        return '{{%user}}';
    }
}