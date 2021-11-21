<?php

namespace Classes;

class Loading
{
    private $baseDir = "images/";
    private $dir;
    private $newFileName;
    private $uploadFileNeme;
    private $imageFileType;

    public function __construct($dir = 'post')
    {
        $this->dir = $dir;
        $this->uploadFileNeme = basename($_FILES[$this->dir]["name"]);
        $this->imageFileType = strtolower(pathinfo($this->uploadFileNeme,PATHINFO_EXTENSION));
        $this->newFileName = $this->baseDir . $dir . '/' . md5(basename($this->uploadFileNeme)) . '.' . $this->imageFileType;
        $this->validate();
    }
    private function validate()
    {
        if ($this->imageFileType != "jpg" && $this->imageFileType != "png" && $this->imageFileType != "jpeg") {
            throw new \Exception('Допустимый тип загрузки файлов: jpg, png, jpeg');
        }
        if ($_FILES[$this->dir]['size'] > 500000) {
            throw new \Exception('Файл слишком большой');
        }
        if (file_exists($this->newFileName)) {
            throw new \Exception('Файл с таким именем существует');
        }
    }

    public function upload(): string
    {
        if (move_uploaded_file($_FILES[$this->dir]["tmp_name"], $this->newFileName)) {
            return $this->newFileName;
        } else {
            throw new \Exception('Ошибка загрузки файла');
        }
    }
}
