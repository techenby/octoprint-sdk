<?php

namespace TechEnby\OctoPrint\Actions;

use TechEnby\OctoPrint\Resources\Printer;

trait ManagesPrinter
{
    public function printer()
    {
        return new Printer($this->get('printer'));
    }
}
