<?php

namespace TechEnby\OctoPrint\Actions;

use TechEnby\OctoPrint\Resources\Job;

trait ManagesJobs
{
    public function job()
    {
        return new Job($this->get('job'));
    }

    public function start()
    {
        return $this->post('job', ['json' => ['command' => 'start']]);
    }

    public function cancel()
    {
        return $this->post('job', ['json' => ['command' => 'cancel']]);
    }

    public function restart()
    {
        return $this->post('job', ['json' => ['command' => 'restart']]);
    }

    public function pause($action = 'toggle')
    {
        return $this->post('job', ['json' => ['command' => 'pause', 'action' => $action]]);
    }
}
