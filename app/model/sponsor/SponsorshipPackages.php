<?php

namespace App\model\sponsor;

class SponsorshipPackages extends \App\model\database\dbModel
{
    protected string $Package_ID='';
    protected string $Package_Name='';
    protected string $Package_Price='';
    protected string $Package_Description='';
    protected string $Package_Image='';
    protected string $Created_By='';
    protected string $Created_At='';
    protected ?string $Updated_By='';
    protected ?string $Updated_At='';

    /**
     * @return string
     */
    public function getPackageDescription(): string
    {
        return $this->Package_Description;
    }

    /**
     * @param string $Package_Description
     */
    public function setPackageDescription(string $Package_Description): void
    {
        $this->Package_Description = $Package_Description;
    }

    /**
     * @return string
     */
    public function getPackageImage(): string
    {
        return $this->Package_Image;
    }

    /**
     * @param string $Package_Image
     */
    public function setPackageImage(string $Package_Image): void
    {
        $this->Package_Image = $Package_Image;
    }

    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->Created_By;
    }

    /**
     * @param string $Created_By
     */
    public function setCreatedBy(string $Created_By): void
    {
        $this->Created_By = $Created_By;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->Created_At;
    }

    /**
     * @param string $Created_At
     */
    public function setCreatedAt(string $Created_At): void
    {
        $this->Created_At = $Created_At;
    }

    /**
     * @return string
     */
    public function getUpdatedBy(): string
    {
        return $this->Updated_By;
    }

    /**
     * @param string $Updated_By
     */
    public function setUpdatedBy(string $Updated_By): void
    {
        $this->Updated_By = $Updated_By;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->Updated_At;
    }

    /**
     * @param string $Updated_At
     */
    public function setUpdatedAt(string $Updated_At): void
    {
        $this->Updated_At = $Updated_At;
    }



    public function labels(): array
    {
        return [
            'Package_ID' => 'Package ID',
            'Package_Name' => 'Package Name',
            'Package_Price' => 'Package Price',
            'Package_Description' => 'Package Description',
            'Package_Image' => 'Package Image',
            'Created_By' => 'Created By',
            'Created_At' => 'Created At',
            'Updated_By' => 'Updated By',
            'Updated_At' => 'Updated At',
        ];
    }

    public function rules(): array
    {
        return [
            'Package_Name' => [self::RULE_REQUIRED],
            'Package_Price' => [self::RULE_REQUIRED],
            'Package_Description' => [self::RULE_REQUIRED],
            'Package_Image' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'Sponsorship_Packages';
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
            'Package_Description',
            'Package_Image',
            'Created_By',
            'Created_At',
            'Updated_By',
            'Updated_At',

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