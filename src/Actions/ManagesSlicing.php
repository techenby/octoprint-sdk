<?php

namespace TechEnby\OctoPrint\Actions;

trait ManagesSlicing
{
    public function slicers()
    {
        return $this->get('slicing');
    }

    public function slicerProfiles($slicer)
    {
        return $this->get("slicing/{$slicer}/profiles");
    }

    public function slicerProfile($slicer, $key)
    {
        return $this->get("slicing/{$slicer}/profiles/{$key}");
    }

    public function createSlicerProfile($slicer, $key, $data)
    {
        return $this->put("slicing/{$slicer}/profiles/{$key}", ['json' => $data]);
    }

    public function updateSlicerProfile($slicer, $key, $data)
    {
        return $this->patch("slicing/{$slicer}/profiles/{$key}", ['json' => $data]);
    }

    public function deleteSlicerProfile($slicer, $key)
    {
        $this->delete("slicing/{$slicer}/profiles/{$key}");
    }
}
