<?php

namespace TechEnby\OctoPrint\Actions;

use TechEnby\OctoPrint\Resources\File;

trait ManagesFiles
{
    /**
     * Get the collection of files.
     *
     * @return \Laravel\Forge\Resources\File[]
     */
    public function files($recursive = true, $location = null)
    {
        if($location) {
            return $this->transformCollection(
                $this->get("files/{$location}", ['query' => ['recursive' => $recursive]])['files'], File::class
            );
        }

        return $this->transformCollection(
            $this->get('files', ['query' => ['recursive' => $recursive]])['files'], File::class
        );
    }

    /**
     * Get a file instance.
     *
     * @param  string  $path
     * @return \TechEnby\OctoPrint\Resources\File
     */
    public function file($location, $path)
    {
        return new File($this->get("files/$location/$path"));
    }
}
