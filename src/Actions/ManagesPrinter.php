<?php

namespace TechEnby\OctoPrint\Actions;

use TechEnby\OctoPrint\Resources\Printer;

trait ManagesPrinter
{
    public function printer()
    {
        return new Printer($this->get('printer'));
    }

    public function jog($x = 0, $y = 0, $z = 0, $absolute = null, $speed = null)
    {
        $default = ['command' => 'jog', 'x' => $x, 'y' => $y, 'z' => $z, ];

        if($absolute !== null && $speed !== null) {
            $data = array_merge($default, ['absolute' => $absolute], ['speed' => $speed]);
        } elseif($absolute !== null) {
            $data = array_merge($default, ['absolute' => $absolute]);
        } elseif($speed !== null) {
            $data = array_merge($default, ['speed' => $speed]);
        }

        $this->post('printer/printhead', ['json' => $data]);

        return $this;
    }

    public function home($axes)
    {
        $this->post('printer/printhead', ['json' => ['command' => 'home', 'axes' => $axes]]);

        return $this;
    }

    public function feedrate($factor)
    {
        $this->post('printer/printhead', ['json' => ['command' => 'feedrate', 'factor' => $factor]]);

        return $this;
    }

    public function targetToolTemps($targets)
    {
        $this->post('printer/tool', ['json' => ['command' => 'target', 'targets' => $targets]]);

        return $this;
    }

    public function offsetToolTemps($offsets)
    {
        $this->post('printer/tool', ['json' => ['command' => 'offset', 'offsets' => $offsets]]);

        return $this;
    }

    public function selectTool($tool)
    {
        $this->post('printer/tool', ['json' => ['command' => 'select', 'tool' => $tool]]);

        return $this;
    }

    public function extrude($amount, $speed = null)
    {
        if($speed) {
            $this->post('printer/tool', ['json' => ['command' => 'extrude', 'amount' => $amount, 'speed' => $speed]]);
        } else {
            $this->post('printer/tool', ['json' => ['command' => 'extrude', 'amount' => $amount]]);
        }

        return $this;
    }

    public function retract($amount, $speed = null)
    {
        return $this->extrude(-$amount, $speed);
    }

    public function flowrate($factor)
    {
        $this->post('printer/tool', ['json' => ['command' => 'flowrate', 'factor' => $factor]]);

        return $this;
    }

    public function tool()
    {
        return $this->get('printer/tool');
    }

    public function targetBedTemp($target)
    {
        $this->post('printer/bed', ['json' => ['command' => 'target', 'target' => $target]]);

        return $this;
    }

    public function offsetBedTemp($offset)
    {
        $this->post('printer/bed', ['json' => ['command' => 'offset', 'offset' => $offset]]);

        return $this;
    }

    public function bed()
    {
        return $this->get('printer/bed')['bed'];
    }

    public function targetChamberTemp($target)
    {
        $this->post('printer/chamber', ['json' => ['command' => 'target', 'target' => $target]]);

        return $this;
    }

    public function offsetChamberTemp($offset)
    {
        $this->post('printer/chamber', ['json' => ['command' => 'offset', 'offset' => $offset]]);

        return $this;
    }

    public function chamber()
    {
        return $this->get('printer/chamber')['chamber'];
    }

    public function initSD()
    {
        $this->post('printer/sd', ['json' => ['command' => 'init']]);

        return $this;
    }

    public function refreshSD()
    {
        $this->post('printer/sd', ['json' => ['command' => 'refresh']]);

        return $this;
    }

    public function releaseSD()
    {
        $this->post('printer/sd', ['json' => ['command' => 'release']]);

        return $this;
    }

    public function sd()
    {
        return $this->get('printer/sd');
    }
}
