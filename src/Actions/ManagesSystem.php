<?php

namespace TechEnby\OctoPrint\Actions;

trait ManagesSystem
{
    public function systemCommands()
    {
        return $this->get('system/commands');
    }

    public function systemCommand($source)
    {
        return $this->get("system/commands/{$source}");
    }

    public function runSystemCommand($source, $action)
    {
        $this->post("system/commands/{$source}/{$action}");
    }
}
