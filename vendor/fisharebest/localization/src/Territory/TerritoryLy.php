<?php

namespace Fisharebest\Localization\Territory;

/**
 * Class AbstractTerritory - Representation of the territory LY - Libya.
 *
 * @author    Greg Roach <fisharebest@gmail.com>
 * @copyright (c) 2018 Greg Roach
 * @license   GPLv3+
 */
class TerritoryLy extends AbstractTerritory implements TerritoryInterface
{
    public function code()
    {
        return 'LY';
    }

    public function firstDay()
    {
        return 6;
    }

    public function weekendStart()
    {
        return 5;
    }

    public function weekendEnd()
    {
        return 6;
    }
}
