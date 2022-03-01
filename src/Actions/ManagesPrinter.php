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

        $this->post('printer', ['json' => $data]);

        return $this;
    }

    public function home($axes)
    {
        $this->post('printer', ['json' => ['command' => 'home', 'axes' => $axes]]);

        return $this;
    }

    public function feedrate($factor)
    {
        $this->post('printer', ['json' => ['command' => 'feedrate', 'factor' => $factor]]);

        return $this;
    }
}
