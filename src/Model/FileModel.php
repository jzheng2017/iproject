<?php


namespace EenmaalAndermaal\Model;


use EenmaalAndermaal\App;

class FileModel extends Model
{
    public $fileName;
    public $extension;
    public $path;

    protected $directories = [];


    public function setFile(array $file, string $relativePath, string $customName = ""): bool
    {
        if ($file['size'] > 0) {
            $path = BASEPATH . App::getApp()->getConfig()->get('website.file.location') . $relativePath;
            $nameArray = explode(".", $file['name']);
            $extension = end($nameArray);
            $filename = empty($customName) ? $file['name'] : $customName . "." . $extension;
            $nameArray = explode(".", $filename);
            array_pop($nameArray);
            $name = join(".", $nameArray);
            $newName = $name;

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            if (file_exists($path . "/" . $filename)) {
                $newPath = $path . "/" . $filename;
                $i = 1;
                while (file_exists($newPath)) {
                    $newPath = $path . "/" . $name . "-$i." . $extension;
                    $newName = $name . "-$i";
                    $i++;
                }
            }

            $destination = $path . "/" . $newName . "." . $extension;

            if (copy($file['tmp_name'], $destination)) {
                if (!file_exists($destination)) {
                    return false;
                } else {
                    $this->extension = $extension;
                    $this->fileName = $newName . "." . $extension;
                    $this->path = $relativePath;
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * @return string the field used as primary key for the entity
     */
    public function getIdentifier()
    {
        // TODO: Implement getIdentifier() method.
    }

    /**
     *
     * @return string the start of the API path, for example rubrieken
     */
    protected function getBaseApiPath(): string
    {
        // TODO: Implement getBaseApiPath() method.
    }
}