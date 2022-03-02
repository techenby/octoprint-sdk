<?php

namespace TechEnby\OctoPrint\Actions;

use TechEnby\OctoPrint\Resources\File;

trait ManagesFiles
{
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

    public function file($location, $path)
    {
        return new File($this->get("files/$location/$path"));
    }

    public function selectFile($location, $path, $print = false)
    {
        $this->post("files/{$location}/{$path}", ['json' => ['command' => 'select', 'print' => $print]]);

        return $this;
    }

    public function unselectFile($location, $path)
    {
        $this->post("files/{$location}/{$path}", ['json' => ['command' => 'unselect']]);

        return $this;
    }

    public function sliceFile($location, $path, $data)
    {
        return $this->post("files/{$location}/{$path}", ['json' => array_merge(['command' => 'slice'], $data)]);
    }

    public function copyFile($location, $path, $destination)
    {
        return $this->post("files/{$location}/{$path}", ['json' => ['command' => 'copy', 'destination' => $destination]]);
    }

    public function moveFile($location, $path, $destination)
    {
        return $this->post("files/{$location}/{$path}", ['json' => ['command' => 'move', 'destination' => $destination]]);
    }

    public function deleteFile($location, $path)
    {
        $this->delete("files/{$location}/{$path}");
    }

}
