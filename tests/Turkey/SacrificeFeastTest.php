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

class SacrificeFeastTest extends TurkeyBaseTestCase implements HolidayTestCase
{
    public const HOLIDAY = 'sacrificeFeast';

    /** The first year for which the provider lists the feast. */
    public const FIRST_KNOWN_YEAR = 1970;

    /** The last year for which the provider lists the feast. */
    public const LAST_KNOWN_YEAR = 2037;

    /** The number of days the feast lasts. */
    private const LENGTH = 4;

    /**
     * The start dates published by the Presidency of Religious Affairs.
     *
     * @return array<array{int, string}>
     */
    public static function startDateProvider(): array
    {
        return [
            [2022, '2022-07-09'],
            [2023, '2023-06-28'],
            [2024, '2024-06-16'],
            [2025, '2025-06-06'],
            [2026, '2026-05-27'],
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
     * The feast falls twice in 1974 and in 2006, because it lands in early January in those years. The days of the
     * second occurrence carry their own keys.
     *
     * @throws \Exception
     */
    public function testFeastFallingTwiceInTheSameYear(): void
    {
        $this->assertHoliday(
            self::REGION,
            self::HOLIDAY . '1',
            1974,
            new \DateTime('1974-01-04', new \DateTimeZone(self::TIMEZONE))
        );

        $this->assertHoliday(
            self::REGION,
            'secondSacrificeFeast1',
            1974,
            new \DateTime('1974-12-24', new \DateTimeZone(self::TIMEZONE))
        );

        $this->assertHoliday(
            self::REGION,
            self::HOLIDAY . '1',
            2006,
            new \DateTime('2006-01-10', new \DateTimeZone(self::TIMEZONE))
        );

        $this->assertHoliday(
            self::REGION,
            'secondSacrificeFeast1',
            2006,
            new \DateTime('2006-12-31', new \DateTimeZone(self::TIMEZONE))
        );
    }

    /**
     * The feast starting on 31 December 2006 runs until 3 January 2007. Its remaining days belong to 2007 and keep
     * their position within the feast, so 1 January 2007 is its second day.
     *
     * @throws \Exception
     */
    public function testFeastRunningIntoTheNextYear(): void
    {
        $timezone = new \DateTimeZone(self::TIMEZONE);

        // The feast starts in 2006 and only its first day belongs to that year.
        $this->assertHoliday(self::REGION, 'secondSacrificeFeast1', 2006, new \DateTime('2006-12-31', $timezone));
        $this->assertNotHoliday(self::REGION, 'secondSacrificeFeast2', 2006);

        // Its remaining days belong to 2007.
        $this->assertHoliday(self::REGION, self::HOLIDAY . '2', 2007, new \DateTime('2007-01-01', $timezone));
        $this->assertHoliday(self::REGION, self::HOLIDAY . '3', 2007, new \DateTime('2007-01-02', $timezone));
        $this->assertHoliday(self::REGION, self::HOLIDAY . '4', 2007, new \DateTime('2007-01-03', $timezone));
        $this->assertNotHoliday(self::REGION, self::HOLIDAY . '1', 2007);

        // The feast later in 2007 is the second one of that year.
        $this->assertHoliday(self::REGION, 'secondSacrificeFeast1', 2007, new \DateTime('2007-12-20', $timezone));
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
                [self::LOCALE => 'Kurban Bayramı']
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
