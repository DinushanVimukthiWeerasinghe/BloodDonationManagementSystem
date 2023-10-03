<?php

namespace App\model\Blog;

class Blog extends \App\model\database\dbModel
{
    public const BLOG_PUBLISHED = 0;
    public const BLOG_DRAFT = 1;
    protected string $Blog_ID='';
    protected string $Blog_Title='';
    protected string $Blog_Content='';
    protected string $Blog_Image='';
    protected string $Blog_Date='';
    protected string $Blog_Status='';

    /**
     * @param string $Blog_Date
     * @param string $Blog_Status
     */
    public function __construct()
    {
        $this->Blog_Date = date('Y-m-d');
        $this->Blog_Status = self::BLOG_PUBLISHED;
    }

    /**
     * @return string
     */
    public function getBlogID(): string
    {
        return $this->Blog_ID;
    }

    /**
     * @param string $Blog_ID
     */
    public function setBlogID(string $Blog_ID): void
    {
        $this->Blog_ID = $Blog_ID;
    }

    /**
     * @return string
     */
    public function getBlogTitle(): string
    {
        return $this->Blog_Title;
    }

    /**
     * @param string $Blog_Title
     */
    public function setBlogTitle(string $Blog_Title): void
    {
        $this->Blog_Title = $Blog_Title;
    }

    /**
     * @return string
     */
    public function getBlogContent(): string
    {
        return $this->Blog_Content;
    }

    /**
     * @param string $Blog_Content
     */
    public function setBlogContent(string $Blog_Content): void
    {
        $this->Blog_Content = $Blog_Content;
    }

    /**
     * @return string
     */
    public function getBlogImage(): string
    {
        return $this->Blog_Image;
    }

    /**
     * @param string $Blog_Image
     */
    public function setBlogImage(string $Blog_Image): void
    {
        $this->Blog_Image = $Blog_Image;
    }

    /**
     * @return string
     */
    public function getBlogDate(): string
    {
        return $this->Blog_Date;
    }

    /**
     * @param string $Blog_Date
     */
    public function setBlogDate(string $Blog_Date): void
    {
        $this->Blog_Date = $Blog_Date;
    }

    /**
     * @return string
     */
    public function getBlogStatus(): string
    {
        return $this->Blog_Status;
    }

    /**
     * @param string $Blog_Status
     */
    public function setBlogStatus(string $Blog_Status): void
    {
        $this->Blog_Status = $Blog_Status;
    }








    public function labels(): array
    {
        return [
            'Blog_ID'=>'Blog ID',
            'Blog_Title'=>'Blog Title',
            'Blog_Content'=>'Blog Content',
            'Blog_Image'=>'Blog Image',
            'Blog_Date'=>'Blog Date',
            'Blog_Status'=>'Blog Status'
        ];
    }

    public function rules(): array
    {
        return [
            'Blog_ID'=>[self::RULE_REQUIRED],
            'Blog_Title'=>[self::RULE_REQUIRED],
            'Blog_Content'=>[self::RULE_REQUIRED],
            'Blog_Image'=>[self::RULE_REQUIRED],
            'Blog_Date'=>[self::RULE_REQUIRED],
            'Blog_Status'=>[self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'blog';
    }

    public static function tableName(): string
    {
        return 'Blogs';
    }

    public static function PrimaryKey(): string
    {
        return 'Blog_ID';
    }

    public function attributes(): array
    {
        return [
            'Blog_ID',
            'Blog_Title',
            'Blog_Content',
            'Blog_Image',
            'Blog_Date',
            'Blog_Status'
        ];
    }
}