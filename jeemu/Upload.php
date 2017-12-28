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
    private $uploadPath = '../upload';
    private $file;
    private $errorMsg='';
    private $clientFilename;
    private $clientMediaType;
    private $size;
    private $suffix;

    public function __construct($file, string $path = '')
    {

        $this->file = current($file);
        if ($this->file['error'] !== 0) {
            $this->codeToMessage($file['error']);
            return;
        }
        if ($path) {
            $this->uploadPath = $path;
        }
        $this->uploadPath .= date('/Y/m/d/') . randStr(5);
        if (!is_dir($this->uploadPath)) {
            createPath($this->uploadPath);
        }
        $this->clientFilename = $this->file['name'];
        $this->clientMediaType = $this->file['type'];
        $this->size = $this->file['size'];
        $this->suffix = pathinfo($this->clientFilename)['basename'];
    }

    private function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $this->errorMsg = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->errorMsg = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->errorMsg = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->errorMsg = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->errorMsg = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $this->errorMsg = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $this->errorMsg = "File upload stopped by extension";
                break;

            default:
                $this->errorMsg = "Unknown upload error";
                break;
        }
    }

    public function getClientFilename():string
    {
        return $this->clientFilename;
        // TODO: Implement getClientFilename() method.
    }

    public function getClientMediaType():string
    {
        return $this->clientMediaType;
        // TODO: Implement getClientMediaType() method.
    }

    public function getError(): string
    {
        return $this->errorMsg;
        // TODO: Implement getError() method.
    }

    public function getSize():int
    {
        return $this->size;
        // TODO: Implement getSize() method.
    }

    public function getStream()
    {
        // TODO: Implement getStream() method.
    }

    public function moveTo($targetPath = ''): string
    {
        if (!is_uploaded_file($this->file['tmp_name'])) {
            $this->errorMsg = '非法文件';
            return '';
        }
        $filename= $this->uploadPath . '/' . uniqid().$this->suffix;
        if (move_uploaded_file($this->file['tmp_name'], $filename)){
            return $filename;
        }
        $this->errorMsg = '上传出错';
        return '';
        // TODO: Implement moveTo() method.
    }
}