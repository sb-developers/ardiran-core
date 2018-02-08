<?php

namespace Ardiran\Core\View;

use Illuminate\View\FileViewFinder as IlluminateFileViewFinder;

class FileViewFinder extends IlluminateFileViewFinder{

    /**
     * Return a list of found views.
     *
     * @return array
     */
    public function getViews(){
        return $this->views;
    }

}