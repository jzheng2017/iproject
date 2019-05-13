<?php

namespace EenmaalAndermaal\Configuration;

use EenmaalAndermaal\App;

class Config
{

    private $config = [];

    /**
     * Config constructor.
     * @param string $configFile
     */
    public function __construct(string $configFile)
    {
        $filePath = BASEPATH . "config/" . $configFile . ".php";
        $localFilePath = BASEPATH . "config/" . $configFile . ".local.php";
        /** @noinspection PhpIncludeInspection */
        $this->config = file_exists($localFilePath) ? include $localFilePath : include $filePath;
    }

    public function get($key)
    {
        $keys = explode('.', $key);
        $version = App::getApp()->isProduction() ? "production" : "dev";
        if (isset($this->config[$version][$keys[0]])) {
            if (count($keys) > 1) {
                return $this->getByKeys($keys, $this->config[$version][$keys[0]], 1);
            } else {
                return $this->config[$version][$keys[0]];
            }
        } else {
            return false;
        }
    }

    private function getByKeys($keys, $result, $index)
    {
        if (isset($result[$keys[$index]])) {
            if (count($keys) - 1 > $index) {
                return $this->getByKeys($keys, $result[$index], ++$index);
            } else {
                return $result[$keys[$index]];
            }
        } else {
            return false;
        }
    }
}