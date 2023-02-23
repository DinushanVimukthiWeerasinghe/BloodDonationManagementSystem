<?php

namespace App\model\sponsor;

class sponsorship_packages extends \App\model\database\dbModel
{
    protected string $Package_ID='';
    protected string $Package_Name='';
    protected string $Package_Price='';

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

    public function GetAttributesValue($attributes)
    {
        return $this->{$attributes};
    }

    public static function tableName(): string
    {
        // TODO: Implement tableName() method.
        return 'sponsorship_packages';
    }

    public static function PrimaryKey(): string
    {
        // TODO: Implement PrimaryKey() method.
        return 'Package_ID';

    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
        return [
            'Package_ID',
            'Package_Name',
            'Package_Price',
        ];
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->Package_Name;
    }

    /**
     * @param string $Package_Name
     */
    public function setPackageName(string $Package_Name): void
    {
        $this->Package_Name = $Package_Name;
    }

    /**
     * @return string
     */
    public function getPackagePrice(): string
    {
        return $this->Package_Price;
    }

    /**
     * @param string $Package_Price
     */
    public function setPackagePrice(string $Package_Price): void
    {
        $this->Package_Price = $Package_Price;
    }

    public function getPackageID(): string
    {
        return $this->Package_ID;
    }

    /**
     * @param string $Package_ID
     */
    public function setPackageID(string $Package_ID): void
    {
        $this->Package_ID = $Package_ID;
    }


}