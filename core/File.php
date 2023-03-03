<?php

namespace Core;

class File
{
    public $name='';
    public $type='';
    private $tmp_name='';
    public $error=[];
    public $size=0;
    public $extension='';
    public $path='';
    public $file='';
    protected $pathPrefix='';

    /**
     * @param mixed|string $pathPrefix
     */
    public function setPathPrefix(mixed $pathPrefix): void
    {
        $this->pathPrefix = $pathPrefix;
    }



    /**
     * @param mixed $string
     */
    public function __construct(mixed $string, $prefix = ''){
        $this->name=$string['name'];
        $this->type=$string['type'];
        $this->tmp_name=$string['tmp_name'];
        $this->error=$string['error'];
        $this->size=$string['size'];
        $this->pathPrefix=$prefix;
        if ($prefix===''){
            $this->path=Application::$ROOT_DIR.'/public/upload/';
        }else{
            $this->path=Application::$ROOT_DIR.'/public/upload/'.$prefix.'/';
        }
        $this->extension=pathinfo($this->name,PATHINFO_EXTENSION);
        $this->file=$string;
    }

    public function GenerateFileName(string $prefix=''): string
    {
        $this->name= $prefix.uniqid().'.'.$this->extension;
        return '/public/upload/'.$this->pathPrefix.'/'.$this->name;
    }

    public function saveFile(): bool
    {
            $filePath=$this->path.$this->name;
            if (!is_dir($this->path)){
                mkdir($this->path,0777,true);
            }
            if(move_uploaded_file($this->tmp_name,$filePath)){
                return true;
            }
            return false;
    }

    public function deleteFile(): void
    {
        if(file_exists($this->path)){
            unlink($this->path);
        }
    }

    public function getFileName(): string
    {
        return '/public/upload/'.$this->pathPrefix.'/'.$this->name;
    }

    public function getFileType()
    {
        return $this->type;
    }

    public function getFileTmpName()
    {
        return $this->tmp_name;
    }

    public function getFileError()
    {
        return $this->error;
    }

    public function getFileSize()
    {
        return $this->size;
    }

    public function cropFile(int $int, int $int1): void
    {
        $im=move_uploaded_file($this->tmp_name,$this->path);
        $image = imagecreatefromjpeg($this->path);
        $size = min(imagesx($image), imagesy($image));
        $im2 = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => 250, 'height' => 150]);

    }

    public function setFileName(string $fileName)
    {
        $this->name=$fileName;
    }

    public function getExtension()
    {
        return $this->extension;
    }
}