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

use Fisharebest\Webtrees\Date;
use Fisharebest\Webtrees\Fact;
use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Individual;
use Illuminate\Support\Collection;
use Mockery;

/**
 * Test harness for the class CensusColumnMarriedWithinYear
 */
class CensusColumnMarriedWithinYearTest extends \Fisharebest\Webtrees\TestCase
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
     * @covers \Fisharebest\Webtrees\Census\CensusColumnMarriedWithinYear
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     *
     * @return void
     */
    public function testMarriedWithinYear(): void
    {
        $fact = Mockery::mock(Fact::class);
        $fact->shouldReceive('date')->andReturn(new Date('01 DEC 1859'));

        $family = Mockery::mock(Family::class);
        $family->shouldReceive('facts')->with(['MARR'])->andReturn(new Collection([$fact]));

        $individual = Mockery::mock(Individual::class);
        $individual->shouldReceive('spouseFamilies')->andReturn(new Collection([$family]));

        $census = Mockery::mock(CensusInterface::class);
        $census->shouldReceive('censusDate')->andReturn('01 JUN 1860');

        $column = new CensusColumnMarriedWithinYear($census, '', '');

        $this->assertSame('Y', $column->generate($individual, $individual));
    }

    /**
     * @covers \Fisharebest\Webtrees\Census\CensusColumnMarriedWithinYear
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     *
     * @return void
     */
    public function testMarriedOverYearBeforeTheCensus(): void
    {
        $fact = Mockery::mock(Fact::class);
        $fact->shouldReceive('date')->andReturn(new Date('01 JAN 1859'));

        $family = Mockery::mock(Family::class);
        $family->shouldReceive('facts')->with(['MARR'])->andReturn(new Collection([$fact]));

        $individual = Mockery::mock(Individual::class);
        $individual->shouldReceive('spouseFamilies')->andReturn(new Collection([$family]));

        $census = Mockery::mock(CensusInterface::class);
        $census->shouldReceive('censusDate')->andReturn('01 JUN 1860');

        $column = new CensusColumnMarriedWithinYear($census, '', '');

        $this->assertSame('', $column->generate($individual, $individual));
    }

    /**
     * @covers \Fisharebest\Webtrees\Census\CensusColumnMarriedWithinYear
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     *
     * @return void
     */
    public function testMarriedAfterTheCensus(): void
    {
        $fact = Mockery::mock(Fact::class);
        $fact->shouldReceive('date')->andReturn(new Date('02 JUN 1860'));

        $family = Mockery::mock(Family::class);
        $family->shouldReceive('facts')->with(['MARR'])->andReturn(new Collection([$fact]));

        $individual = Mockery::mock(Individual::class);
        $individual->shouldReceive('spouseFamilies')->andReturn(new Collection([$family]));

        $census = Mockery::mock(CensusInterface::class);
        $census->shouldReceive('censusDate')->andReturn('01 JUN 1860');

        $column = new CensusColumnMarriedWithinYear($census, '', '');

        $this->assertSame('', $column->generate($individual, $individual));
    }

    /**
     * @covers \Fisharebest\Webtrees\Census\CensusColumnMarriedWithinYear
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     *
     * @return void
     */
    public function testNoMarriage(): void
    {
        $family = Mockery::mock(Family::class);
        $family->shouldReceive('facts')->with(['MARR'])->andReturn(new Collection());

        $individual = Mockery::mock(Individual::class);
        $individual->shouldReceive('spouseFamilies')->andReturn(new Collection([$family]));

        $census = Mockery::mock(CensusInterface::class);
        $census->shouldReceive('censusDate')->andReturn('01 JUN 1860');

        $column = new CensusColumnMarriedWithinYear($census, '', '');

        $this->assertSame('', $column->generate($individual, $individual));
    }

    /**
     * @covers \Fisharebest\Webtrees\Census\CensusColumnMarriedWithinYear
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     *
     * @return void
     */
    public function testNoSpouseFamily(): void
    {
        $individual = Mockery::mock(Individual::class);
        $individual->shouldReceive('spouseFamilies')->andReturn(new Collection());

        $census = Mockery::mock(CensusInterface::class);
        $census->shouldReceive('censusDate')->andReturn('01 JUN 1860');

        $column = new CensusColumnMarriedWithinYear($census, '', '');

        $this->assertSame('', $column->generate($individual, $individual));
    }
}
