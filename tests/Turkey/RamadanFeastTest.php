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

use PHPUnit\Framework\Attributes\DataProvider;
use Yasumi\Holiday;
use Yasumi\tests\HolidayTestCase;
use Yasumi\Yasumi;

class RamadanFeastTest extends TurkeyBaseTestCase implements HolidayTestCase
{
    public const HOLIDAY = 'ramadanFeast';

    /** The first year for which the provider lists the feast. */
    public const FIRST_KNOWN_YEAR = 1970;

    /** The last year for which the provider lists the feast. */
    public const LAST_KNOWN_YEAR = 2037;

    /** The number of days the feast lasts. */
    private const LENGTH = 3;

    /**
     * The start dates published by the Presidency of Religious Affairs.
     *
     * @return array<array{int, string}>
     */
    public static function startDateProvider(): array
    {
        return [
            [2022, '2022-05-02'],
            [2023, '2023-04-21'],
            [2024, '2024-04-10'],
            [2025, '2025-03-30'],
            [2026, '2026-03-20'],
        ];
    }

    /**
     * @throws \Exception
     */
    #[DataProvider('startDateProvider')]
    public function testHoliday(int $year, string $start): void
    {
        $date = new \DateTime($start, new \DateTimeZone(self::TIMEZONE));

        for ($day = 1; $day <= self::LENGTH; ++$day) {
            $this->assertHoliday(self::REGION, self::HOLIDAY . $day, $year, $date);
            $date = (clone $date)->add(new \DateInterval('P1D'));
        }
    }

    /**
     * The feast falls twice in 2000 and in 2033, because it lands in early January in those years. The days of the
     * second occurrence carry their own keys.
     *
     * @throws \Exception
     */
    public function testFeastFallingTwiceInTheSameYear(): void
    {
        $occurrences = [
            2000 => ['2000-01-08', '2000-12-27'],
            2033 => ['2033-01-03', '2033-12-23'],
        ];

        foreach ($occurrences as $year => [$first, $second]) {
            foreach ([self::HOLIDAY => $first, 'secondRamadanFeast' => $second] as $key => $start) {
                $date = new \DateTime($start, new \DateTimeZone(self::TIMEZONE));

                for ($day = 1; $day <= self::LENGTH; ++$day) {
                    $this->assertHoliday(self::REGION, $key . $day, $year, $date);
                    $date = (clone $date)->add(new \DateInterval('P1D'));
                }
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function testHolidayBeforeFirstKnownYear(): void
    {
        $this->assertNotHoliday(
            self::REGION,
            self::HOLIDAY . '1',
            static::generateRandomYear(Yasumi::YEAR_LOWER_BOUND, self::FIRST_KNOWN_YEAR - 1)
        );
    }

    /**
     * @throws \Exception
     */
    public function testHolidayAfterLastKnownYear(): void
    {
        $this->assertNotHoliday(
            self::REGION,
            self::HOLIDAY . '1',
            static::generateRandomYear(self::LAST_KNOWN_YEAR + 1, Yasumi::YEAR_UPPER_BOUND)
        );
    }

    /**
     * @throws \Exception
     */
    public function testTranslation(): void
    {
        for ($day = 1; $day <= self::LENGTH; ++$day) {
            $this->assertTranslatedHolidayName(
                self::REGION,
                self::HOLIDAY . $day,
                2025,
                [self::LOCALE => 'Ramazan Bayramı']
            );
        }
    }

    /**
     * @throws \Exception
     */
    public function testHolidayType(): void
    {
        for ($day = 1; $day <= self::LENGTH; ++$day) {
            $this->assertHolidayType(self::REGION, self::HOLIDAY . $day, 2025, Holiday::TYPE_OFFICIAL);
        }
    }
}
