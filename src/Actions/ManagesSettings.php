<?php

namespace TechEnby\OctoPrint\Actions;

trait ManagesSettings
{
    public function settings()
    {
        return $this->get('settings');
    }

    public function updateSettings($data)
    {
        return $this->post('settings', ['json' => $data]);
    }
}
