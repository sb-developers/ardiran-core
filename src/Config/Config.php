<?php

namespace Ardiran\Core\Config;

use Illuminate\Config\Repository;
use Symfony\Component\Finder\Finder;

class Config extends Repository{

    /**
     * Load all the configuration files in the repository.
     *
     * @param string $path The path of the directory where the configuration files are.
     * @return void
     */
    public function loadConfigurationFiles($path){

        foreach ($this->getConfigurationFiles($path) as $fileKey => $path) {
            $this->set($fileKey, require $path);
        }

    }

    /**
     * Returns the configuration array of a file.
     *
     * @param string $path The path of the configuration file.
     * @return void
     */
    private function getConfigurationFiles($path){

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