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

namespace Yasumi\Provider;

use Yasumi\Exception\UnknownLocaleException;
use Yasumi\Holiday;

/**
 * Provider for all holidays in Turkey.
 *
 * @see https://en.wikipedia.org/wiki/Public_holidays_in_Turkey
 */
class Turkey extends AbstractProvider
{
    use CommonHolidays;

    /** {@inheritdoc} */
    public const ID = 'TR';

    /**
     * Start dates of the Islamic feasts in the Gregorian calendar, 1970 - 2037.
     *
     * Turkey observes two Islamic public holidays: the Ramadan Feast (Ramazan Bayrami, 1 Shawwal, three days) and the
     * Sacrifice Feast (Kurban Bayrami, 10 Dhu al-Hijjah, four days). Both are established by Law No. 2429 on National
     * Holidays and General Holidays.
     *
     * These dates cannot be derived reliably by conversion. Turkey has determined its own calendar by calculation
     * rather than by moon sighting since 1978, and the Presidency of Religious Affairs (Diyanet Isleri Baskanligi)
     * publishes the resulting dates years in advance. Converting through the Islamic calendars available in ICU
     * reproduces those published dates only in part: measured over this range, "islamic-umalqura" (the closest of the
     * three) agrees on 120 of 140 dates, "islamic" on 61 and "islamic-civil" on 60. Every one of the 20 remaining
     * differences is exactly one day, and the agreement does not improve for recent years (87 percent for 1970-1999,
     * 86 percent for 2000-2026, 83 percent for 2027-2037). A one-day error shifts a whole block of public holidays,
     * so the dates are listed here rather than calculated, in the same way SouthKorea lists the Korean lunar dates.
     *
     * A feast falls twice in the same Gregorian year whenever it lands in early January, which is why each year maps
     * to a list of start dates: the Ramadan Feast in 2000 and 2033, the Sacrifice Feast in 1974 and 2006.
     *
     * The dates for 2019-2026 are taken from the calendars published by the Presidency of Religious Affairs. The
     * remaining years are taken from the data set maintained in spatie/holidays (MIT licensed), which agrees with
     * those published calendars on all sixteen dates where the two overlap. The Sacrifice Feast of 2015 is the one
     * exception: it follows the date curated in python-holidays, which records it as an explicit correction, where
     * spatie/holidays carries the date a conversion produces.
     *
     * @see https://vakithesaplama.diyanet.gov.tr/dinigunler.php - Presidency of Religious Affairs, religious days
     * @see https://www.mevzuat.gov.tr/mevzuatmetin/1.5.2429.pdf - Law No. 2429 on National and General Holidays
     * @see https://github.com/spatie/holidays/blob/main/src/Countries/Turkey.php
     * @see https://github.com/vacanza/holidays/blob/dev/holidays/countries/turkey.py
     */
    public const ISLAMIC_HOLIDAY = [
        'ramadanFeast' => [
            1970 => ['12-01'], 1971 => ['11-20'], 1972 => ['11-08'], 1973 => ['10-28'], 1974 => ['10-17'],
            1975 => ['10-06'], 1976 => ['09-25'], 1977 => ['09-15'], 1978 => ['09-04'], 1979 => ['08-24'],
            1980 => ['08-12'], 1981 => ['08-01'], 1982 => ['07-22'], 1983 => ['07-12'], 1984 => ['06-30'],
            1985 => ['06-20'], 1986 => ['06-09'], 1987 => ['05-29'], 1988 => ['05-17'], 1989 => ['05-06'],
            1990 => ['04-26'], 1991 => ['04-16'], 1992 => ['04-04'], 1993 => ['03-24'], 1994 => ['03-13'],
            1995 => ['03-03'], 1996 => ['02-20'], 1997 => ['02-09'], 1998 => ['01-29'], 1999 => ['01-19'],
            2000 => ['01-08', '12-27'], 2001 => ['12-16'], 2002 => ['12-05'], 2003 => ['11-25'], 2004 => ['11-14'],
            2005 => ['11-03'], 2006 => ['10-23'], 2007 => ['10-12'], 2008 => ['09-30'], 2009 => ['09-20'],
            2010 => ['09-09'], 2011 => ['08-30'], 2012 => ['08-19'], 2013 => ['08-08'], 2014 => ['07-28'],
            2015 => ['07-17'], 2016 => ['07-05'], 2017 => ['06-25'], 2018 => ['06-15'], 2019 => ['06-04'],
            2020 => ['05-24'], 2021 => ['05-13'], 2022 => ['05-02'], 2023 => ['04-21'], 2024 => ['04-10'],
            2025 => ['03-30'], 2026 => ['03-20'], 2027 => ['03-09'], 2028 => ['02-26'], 2029 => ['02-14'],
            2030 => ['02-04'], 2031 => ['01-24'], 2032 => ['01-14'], 2033 => ['01-03', '12-23'], 2034 => ['12-12'],
            2035 => ['12-01'], 2036 => ['11-19'], 2037 => ['11-09'],
        ],
        'sacrificeFeast' => [
            1970 => ['02-17'], 1971 => ['02-06'], 1972 => ['01-27'], 1973 => ['01-15'], 1974 => ['01-04', '12-24'],
            1975 => ['12-13'], 1976 => ['12-02'], 1977 => ['11-22'], 1978 => ['11-11'], 1979 => ['10-31'],
            1980 => ['10-19'], 1981 => ['10-08'], 1982 => ['09-27'], 1983 => ['09-17'], 1984 => ['09-06'],
            1985 => ['08-26'], 1986 => ['08-16'], 1987 => ['08-05'], 1988 => ['07-24'], 1989 => ['07-13'],
            1990 => ['07-03'], 1991 => ['06-23'], 1992 => ['06-11'], 1993 => ['06-01'], 1994 => ['05-21'],
            1995 => ['05-10'], 1996 => ['04-28'], 1997 => ['04-18'], 1998 => ['04-07'], 1999 => ['03-28'],
            2000 => ['03-16'], 2001 => ['03-05'], 2002 => ['02-22'], 2003 => ['02-11'], 2004 => ['02-01'],
            2005 => ['01-20'], 2006 => ['01-10', '12-31'], 2007 => ['12-20'], 2008 => ['12-08'], 2009 => ['11-27'],
            2010 => ['11-16'], 2011 => ['11-06'], 2012 => ['10-25'], 2013 => ['10-15'], 2014 => ['10-04'],
            2015 => ['09-24'], 2016 => ['09-12'], 2017 => ['09-01'], 2018 => ['08-21'], 2019 => ['08-11'],
            2020 => ['07-31'], 2021 => ['07-20'], 2022 => ['07-09'], 2023 => ['06-28'], 2024 => ['06-16'],
            2025 => ['06-06'], 2026 => ['05-27'], 2027 => ['05-16'], 2028 => ['05-05'], 2029 => ['04-24'],
            2030 => ['04-13'], 2031 => ['04-02'], 2032 => ['03-22'], 2033 => ['03-11'], 2034 => ['03-01'],
            2035 => ['02-18'], 2036 => ['02-07'], 2037 => ['01-26'],
        ],
    ];

    /** Number of days each of the Islamic feasts lasts. */
    private const ISLAMIC_HOLIDAY_LENGTH = [
        'ramadanFeast' => 3,
        'sacrificeFeast' => 4,
    ];

    /**
     * @throws \InvalidArgumentException
     * @throws UnknownLocaleException
     * @throws \Exception
     */
    public function initialize(): void
    {
        $this->timezone = 'Europe/Istanbul';

        // Add common holidays
        $this->addHoliday($this->newYearsDay($this->year, $this->timezone, $this->locale));
        $this->addNationalSovereigntyDay();
        $this->addLabourDay();
        $this->addCommemorationOfAtaturk();
        $this->addDemocracyDay();
        $this->addVictoryDay();
        $this->addRepublicDay();
        $this->addRamadanFeast();
        $this->addSacrificeFeast();
    }

    public function getSources(): array
    {
        return [
            'https://en.wikipedia.org/wiki/Public_holidays_in_Turkey',
            'https://tr.wikipedia.org/wiki/T%C3%BCrkiye%27deki_resm%C3%AE_tatiller',
            'https://www.mevzuat.gov.tr/mevzuatmetin/1.5.2429.pdf',
        ];
    }

    /**
     * @throws \Exception
     */
    protected function addLabourDay(): void
    {
        $this->addHoliday(new Holiday('labourDay', [
            'tr' => 'Emek ve Dayanışma Günü',
        ], new \DateTime("{$this->year}-05-01", new \DateTimeZone($this->timezone)), $this->locale));
    }

    /**
     * Commemoration of the first opening of the Grand National Assembly of Turkey at Ankara in 1920.
     * Dedicated to the children.
     *
     * Not sure if 1920 is the first year of celebration as above source mentions Law No. 3466 that "May 19" was
     * made official June 20, 1938.
     *
     * @see https://en.wikipedia.org/wiki/Commemoration_of_Atat%C3%BCrk,_Youth_and_Sports_Day
     *
     * @throws \Exception
     */
    protected function addCommemorationOfAtaturk(): void
    {
        if (1920 > $this->year) {
            return;
        }

        $this->addHoliday(new Holiday('commemorationAtaturk', [
            'tr' => 'Atatürk’ü Anma, Gençlik ve Spor Bayramı',
        ], new \DateTime("{$this->year}-05-19", new \DateTimeZone($this->timezone)), $this->locale));
    }

    /**
     * National Sovereignty and Children's Day (Turkish: Ulusal Egemenlik ve Çocuk Bayramı) is a public holiday in
     * Turkey commemorating the foundation of the Grand National Assembly of Turkey, on 23 April 1920.
     * Since 1927, the holiday has also been celebrated as a children's day.
     *
     * @see https://en.wikipedia.org/wiki/National_Sovereignty_and_Children%27s_Day
     *
     * @throws \Exception
     */
    protected function addNationalSovereigntyDay(): void
    {
        if (1922 > $this->year) {
            return;
        }

        $holidayName = 'Ulusal Egemenlik Bayramı';

        // In 1981 this day was officially named 'Ulusal Egemenlik ve Çocuk Bayramı'
        if (1981 <= $this->year) {
            $holidayName = 'Ulusal Egemenlik ve Çocuk Bayramı';
        }

        $this->addHoliday(new Holiday('nationalSovereigntyDay', [
            'tr' => $holidayName,
        ], new \DateTime("{$this->year}-04-23", new \DateTimeZone($this->timezone)), $this->locale));
    }

    /**
     * The Democracy and National Unity Day of Turkey (Turkish: Demokrasi ve Milli Birlik Günü) is one of the public
     * holidays in Turkey, commemorating the national unity against the coup d'état attempt for democracy in 2016.
     *
     * @see https://en.wikipedia.org/wiki/Democracy_and_National_Unity_Day
     *
     * @throws \Exception
     */
    protected function addDemocracyDay(): void
    {
        if (2017 > $this->year) {
            return;
        }

        $this->addHoliday(new Holiday('democracyDay', [
            'tr' => 'Demokrasi ve Millî Birlik Günü',
        ], new \DateTime("{$this->year}-07-15", new \DateTimeZone($this->timezone)), $this->locale));
    }

    /**
     * Victory Day (Turkish: Zafer Bayramı), also known as Turkish Armed Forces Day, is a public holiday in Turkey
     * commemorating the decisive victory in the Battle of Dumlupınar, on 30 August 1922.
     *
     * @see https://en.wikipedia.org/wiki/Victory_Day_(Turkey)
     *
     * @throws \Exception
     */
    protected function addVictoryDay(): void
    {
        if (1923 > $this->year) {
            return;
        }

        $holidayType = Holiday::TYPE_OFFICIAL;

        // Victory Day has been celebrated as an official holiday since 1926, and was first celebrated on 30 August
        // 1923.
        if (1923 <= $this->year && 1926 > $this->year) {
            $holidayType = Holiday::TYPE_OBSERVANCE;
        }

        $this->addHoliday(new Holiday('victoryDay', [
            'tr' => 'Zafer Bayramı',
        ], new \DateTime("{$this->year}-08-30", new \DateTimeZone($this->timezone)), $this->locale, $holidayType));
    }

    /**
     * Republic Day (Turkish: Cumhuriyet Bayramı) is a public holiday in Turkey commemorating the proclamation of the
     * Republic of Turkey, on 29 October 1923. The annual celebrations start at 1:00 pm on 28 October and continue for
     * 35 hours.
     *
     * Note: the start of the celebrations the preceding day at 1:00pm is not covered in this library.
     *
     * @see https://en.wikipedia.org/wiki/Republic_Day_(Turkey)
     *
     * @throws \Exception
     */
    protected function addRepublicDay(): void
    {
        if (1924 > $this->year) {
            return;
        }

        $this->addHoliday(new Holiday('republicDay', [
            'tr' => 'Cumhuriyet Bayramı',
        ], new \DateTime("{$this->year}-10-29", new \DateTimeZone($this->timezone)), $this->locale));
    }

    /**
     * The Ramadan Feast (Turkish: Ramazan Bayramı) marks the end of Ramadan and lasts three days, starting on
     * 1 Shawwal.
     *
     * Note: the holiday legally starts at 1:00 pm on the preceding day (Arife). As with Republic Day, that half day
     * is not covered in this library.
     *
     * @see https://en.wikipedia.org/wiki/Eid_al-Fitr
     *
     * @throws \InvalidArgumentException
     * @throws UnknownLocaleException
     * @throws \Exception
     */
    protected function addRamadanFeast(): void
    {
        $this->addIslamicHoliday('ramadanFeast', [
            'en' => 'Ramadan Feast',
            'tr' => 'Ramazan Bayramı',
        ]);
    }

    /**
     * The Sacrifice Feast (Turkish: Kurban Bayramı) lasts four days, starting on 10 Dhu al-Hijjah.
     *
     * Note: the holiday legally starts at 1:00 pm on the preceding day (Arife). As with Republic Day, that half day
     * is not covered in this library.
     *
     * @see https://en.wikipedia.org/wiki/Eid_al-Adha
     *
     * @throws \InvalidArgumentException
     * @throws UnknownLocaleException
     * @throws \Exception
     */
    protected function addSacrificeFeast(): void
    {
        $this->addIslamicHoliday('sacrificeFeast', [
            'en' => 'Sacrifice Feast',
            'tr' => 'Kurban Bayramı',
        ]);
    }

    /**
     * Adds every day of the given feast that falls in the year of this provider.
     *
     * A feast is a consecutive block of days identified by its start date. Such a block is not necessarily contained
     * in a single Gregorian year: the Sacrifice Feast starting on 31 December 2006 runs until 3 January 2007. Each
     * day is therefore added to the year it actually falls in and keeps its position within the block, so the first
     * three days of 2007 are the second, third and fourth day of that feast.
     *
     * A year holds two blocks of the same feast whenever one of them falls in early January. The days of the second
     * block are prefixed to keep the holiday keys unique, for example 'secondSacrificeFeast1'.
     *
     * Years outside the range of self::ISLAMIC_HOLIDAY yield no holidays.
     *
     * @param array<string, string> $translations
     *
     * @throws \InvalidArgumentException
     * @throws UnknownLocaleException
     * @throws \Exception
     */
    private function addIslamicHoliday(string $key, array $translations): void
    {
        $length = self::ISLAMIC_HOLIDAY_LENGTH[$key];
        $timezone = new \DateTimeZone($this->timezone);

        // A block starting at the end of December continues into the next year, so the preceding year is considered
        // as well.
        $blocks = [];
        foreach ([$this->year - 1, $this->year] as $startYear) {
            foreach (self::ISLAMIC_HOLIDAY[$key][$startYear] ?? [] as $start) {
                $days = [];
                for ($day = 1; $day <= $length; ++$day) {
                    $date = new \DateTime("{$startYear}-{$start}", $timezone);
                    $date->add(new \DateInterval('P' . ($day - 1) . 'D'));

                    if ((int) $date->format('Y') === $this->year) {
                        $days[$day] = $date;
                    }
                }

                if ([] !== $days) {
                    $blocks[] = $days;
                }
            }
        }

        foreach ($blocks as $index => $days) {
            $prefix = 0 === $index ? $key : 'second' . ucfirst($key);

            foreach ($days as $day => $date) {
                $this->addHoliday(new Holiday($prefix . $day, $translations, $date, $this->locale));
            }
        }
    }
}
