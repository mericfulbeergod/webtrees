<?php
/**
 * webtrees: online genealogy
 * Copyright (C) 2019 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace Fisharebest\Webtrees\Census;

use Fisharebest\Webtrees\Individual;
use Mockery;

/**
 * Test harness for the class CensusColumnSexMK
 */
class CensusColumnSexMKTest extends \Fisharebest\Webtrees\TestCase
{
    /**
     * Delete mock objects
     *
     * @return void
     */
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @covers \Fisharebest\Webtrees\Census\CensusColumnSexMK
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     *
     * @return void
     */
    public function testMale(): void
    {
        $individual = Mockery::mock(Individual::class);
        $individual->shouldReceive('sex')->andReturn('M');

        $census = Mockery::mock(CensusInterface::class);

        $column = new CensusColumnSexMK($census, '', '');

        $this->assertSame('M', $column->generate($individual, $individual));
    }

    /**
     * @covers \Fisharebest\Webtrees\Census\CensusColumnSexMK
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     *
     * @return void
     */
    public function testFeale(): void
    {
        $individual = Mockery::mock(Individual::class);
        $individual->shouldReceive('sex')->andReturn('F');

        $census = Mockery::mock(CensusInterface::class);

        $column = new CensusColumnSexMK($census, '', '');

        $this->assertSame('K', $column->generate($individual, $individual));
    }

    /**
     * @covers \Fisharebest\Webtrees\Census\CensusColumnSexMK
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     *
     * @return void
     */
    public function testUnknownSex(): void
    {
        $individual = Mockery::mock(Individual::class);
        $individual->shouldReceive('sex')->andReturn('U');

        $census = Mockery::mock(CensusInterface::class);

        $column = new CensusColumnSexMK($census, '', '');

        $this->assertSame('', $column->generate($individual, $individual));
    }
}
