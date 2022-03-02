<?php

namespace TechEnby\OctoPrint\Actions;

trait ManagesTimelapses
{
    public function timelapses($unrendered = false)
    {
        return $this->get('timelapse', ['query' => ['unrendered' => $unrendered]])['files'];
    }

    public function timelapseConfig()
    {
        return $this->get('timelapse')['config'];
    }

    public function deleteTimelapse($filename, $unrendered = false)
    {
        if($unrendered) {
            return $this->delete("timelapse/unrendered/{$filename}")['unrendered'];
        }

        return $this->delete("timelapse/{$filename}")['files'];
    }

    public function renderTimelapse($name)
    {
        return $this->post("timelapse/unrendered/{$name}")['files'];
    }

    public function updateTimelapseSettings($data)
    {
        return $this->post("timelapse", ['json' => $data])['config'];
    }
}
