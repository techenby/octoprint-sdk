<?php

namespace Tests\Actions;

use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesFilesTest extends TestCase
{
    public function test_getting_all_files()
    {
        $octoPrint = new OctoPrint('http://eevee.local', 'D868EB9BF75B48E88BCDF73FCD9DCAA9');

        $this->assertCount(3, $octoPrint->files());
    }

    public function test_getting_specific_file()
    {
        $octoPrint = new OctoPrint('http://eevee.local', 'D868EB9BF75B48E88BCDF73FCD9DCAA9');

        $file = $octoPrint->file('local', 'Testing/CHEP_bed_level_points.gcode');

        $this->assertEquals('CHEP_bed_level_points.gcode', $file->name);
        $this->assertEquals('machinecode', $file->type);

    }
}
