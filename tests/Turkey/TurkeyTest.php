<?php

declare(strict_types = 1);

/**
 * This file is part of the 'Yasumi' package.
 *
 * The easy PHP Library for calculating holidays.
 *
 * Copyright (c) 2015 - 2026 AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me at sachatelgenhof dot com>
 */

namespace Yasumi\tests\Turkey;

use Yasumi\Holiday;
use Yasumi\Provider\Turkey;
use Yasumi\tests\ProviderTestCase;

class TurkeyTest extends TurkeyBaseTestCase implements ProviderTestCase
{
    /**
     * Years in which one of the Islamic feasts falls twice, or runs across the turn of the year. The holiday keys
     * differ in those years, which is covered by the test cases of the feasts themselves.
     */
    private const IRREGULAR_YEARS = [1974, 2000, 2006, 2007, 2033];

    /**
     * @var int year random year number used for all tests in this Test Case
     */
    protected int $year;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        do {
            $this->year = static::generateRandomYear();
        } while (\in_array($this->year, self::IRREGULAR_YEARS, true));
    }

    public function testOfficialHolidays(): void
    {
        $holidays = [
            'newYearsDay',
            'labourDay',
        ];

        /*
         * Not sure if 1920 is the first year of celebration as above source mentions Law No. 3466 that "May 19" was
         * made official June 20, 1938.
         * @see: https://en.wikipedia.org/wiki/Commemoration_of_Atat%C3%BCrk,_Youth_and_Sports_Day
         */
        if (1920 <= $this->year) {
            $holidays[] = 'commemorationAtaturk';
        }

        if (1922 <= $this->year) {
            $holidays[] = 'nationalSovereigntyDay';
        }

        if (2017 <= $this->year) {
            $holidays[] = 'democracyDay';
        }

        if (1926 <= $this->year) {
            $holidays[] = 'victoryDay';
        }

        if (1923 < $this->year) {
            $holidays[] = 'republicDay';
        }

        // The Islamic feasts are only defined for the years listed in the provider.
        if (isset(Turkey::ISLAMIC_HOLIDAY['ramadanFeast'][$this->year])) {
            $holidays = array_merge($holidays, ['ramadanFeast1', 'ramadanFeast2', 'ramadanFeast3']);
        }

        if (isset(Turkey::ISLAMIC_HOLIDAY['sacrificeFeast'][$this->year])) {
            $holidays = array_merge(
                $holidays,
                ['sacrificeFeast1', 'sacrificeFeast2', 'sacrificeFeast3', 'sacrificeFeast4']
            );
        }

        $this->assertDefinedHolidays($holidays, self::REGION, $this->year, Holiday::TYPE_OFFICIAL);
    }

    public function testObservedHolidays(): void
    {
        $holidays = [];

        if (1923 <= $this->year && 1926 > $this->year) {
            $holidays[] = 'victoryDay';
        }

        $this->assertDefinedHolidays($holidays, self::REGION, $this->year, Holiday::TYPE_OBSERVANCE);
    }

    public function testSeasonalHolidays(): void
    {
        $this->assertDefinedHolidays([], self::REGION, $this->year, Holiday::TYPE_SEASON);
    }

    public function testBankHolidays(): void
    {
        $this->assertDefinedHolidays([], self::REGION, $this->year, Holiday::TYPE_BANK);
    }

    public function testOtherHolidays(): void
    {
        $this->assertDefinedHolidays([], self::REGION, $this->year, Holiday::TYPE_OTHER);
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function testSources(): void
    {
        $this->assertSources(self::REGION, 3);
    }
}
