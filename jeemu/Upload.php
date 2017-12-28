<?php
/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/28
 * Time: 15:23
 */

namespace Jeemu;


use Psr\Http\Message\UploadedFileInterface;

class Upload implements UploadedFileInterface
{
    private $uploadPath = '../runtime';
    private $file;
    public function __construct($file,string $path = '')
    {
        $this->file = $file;
        if ($path){
            $this->uploadPath = $path;
        }
        if (!is_dir($this->uploadPath)){
            createPath($this->uploadPath);
        }
        var_dump($this->file);
    }

    public function getClientFilename()
    {
        // TODO: Implement getClientFilename() method.
    }

    public function getClientMediaType()
    {
        // TODO: Implement getClientMediaType() method.
    }

    public function getError()
    {
        // TODO: Implement getError() method.
    }

    public function getSize()
    {
        // TODO: Implement getSize() method.
    }

    public function getStream()
    {
        // TODO: Implement getStream() method.
    }

    public function moveTo($targetPath)
    {
        return
        // TODO: Implement moveTo() method.
    }
}