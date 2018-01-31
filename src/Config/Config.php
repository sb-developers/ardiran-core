<?php

namespace Ardiran\Core\Config;

use Illuminate\Config\Repository;
use Symfony\Component\Finder\Finder;

class Config extends Repository{

    public function loadConfigurationFiles($path, $environment = null){
        $this->configPath = $path;

        foreach ($this->getConfigurationFiles() as $fileKey => $path) {
            $this->set($fileKey, require $path);
        }

        foreach ($this->getConfigurationFiles($environment) as $fileKey => $path) {
            $envConfig = require $path;

            foreach ($envConfig as $envKey => $value) {
                $this->set($fileKey.'.'.$envKey, $value);
            }
        }
    }

    protected function getConfigurationFiles($environment = null){
        $path = $this->configPath;

        if ($environment) {
            $path .= '/' . $environment;
        }

        if (!is_dir($path)) {
            return [];
        }

        $files = [];
        $phpFiles = Finder::create()->files()->name('*.php')->in($path)->depth(0);

        foreach ($phpFiles as $file) {
            $files[basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }

}