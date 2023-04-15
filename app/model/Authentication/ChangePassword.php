<?php

namespace App\model\Authentication;

class ChangePassword extends \App\model\database\dbModel
{
    protected string $User_ID='';
    protected string $Code_ID='';


    public function labels(): array
    {
        // TODO: Implement labels() method.
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
    }

    public static function getTableShort(): string
    {
        // TODO: Implement getTableShort() method.
    }

    public static function tableName(): string
    {
        // TODO: Implement tableName() method.
    }

    public static function PrimaryKey(): string
    {
        // TODO: Implement PrimaryKey() method.
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
    }
}