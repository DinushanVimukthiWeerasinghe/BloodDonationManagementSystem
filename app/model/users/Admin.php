<?php

namespace App\model\users;

use App\model\database\dbModel;

class Admin extends Person
{

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'NIC' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'address1' => [self::RULE_REQUIRED],
            'address2' => [self::RULE_REQUIRED],
            'city' => [self::RULE_REQUIRED],
            'postalCode' => [self::RULE_REQUIRED],
            'userImage' => [self::RULE_REQUIRED],
            'userType' => [self::RULE_REQUIRED],
            'status' => [self::RULE_REQUIRED],
        ];
    }

    public function attributes(): array
    {
        return [
            'username',
            'firstname',
            'lastname',
            'email',
            'NIC',
            'password',
            'address1',
            'address2',
            'city',
            'postalCode',
            'userImage',
            'userType',
            'status',
        ];
    }

    public function labels(): array
    {
        // TODO: Implement labels() method.
    }
}