<?php

namespace Poppy\Faker\Provider;

class Person extends Base
{
    const GENDER_MALE   = 'male';
    const GENDER_FEMALE = 'female';

    protected static array $titleFormat = [
        '{{titleMale}}',
        '{{titleFemale}}',
    ];

    protected static array $firstNameFormat = [
        '{{firstNameMale}}',
        '{{firstNameFemale}}',
    ];

    protected static array $maleNameFormats = [
        '{{firstNameMale}} {{lastName}}',
    ];

    protected static array $femaleNameFormats = [
        '{{firstNameFemale}} {{lastName}}',
    ];

    protected static array $firstNameMale = [
        'John',
    ];

    protected static array $firstNameFemale = [
        'Jane',
    ];

    protected static array $lastName = ['Doe'];

    protected static array $titleMale = ['Mr.', 'Dr.', 'Prof.'];

    protected static array $titleFemale = ['Mrs.', 'Ms.', 'Miss', 'Dr.', 'Prof.'];

    /**
     * @param string|null $gender 'male', 'female' or null for any
     * @return string
     * @example 'John Doe'
     */
    public function name($gender = null)
    {
        if ($gender === static::GENDER_MALE) {
            $format = static::randomElement(static::$maleNameFormats);
        }
        elseif ($gender === static::GENDER_FEMALE) {
            $format = static::randomElement(static::$femaleNameFormats);
        }
        else {
            $format = static::randomElement(array_merge(static::$maleNameFormats, static::$femaleNameFormats));
        }

        return $this->generator->parse($format);
    }

    /**
     * @param string|null $gender 'male', 'female' or null for any
     * @return string
     * @example 'John'
     */
    public function firstName($gender = null)
    {
        if ($gender === static::GENDER_MALE) {
            return static::firstNameMale();
        }
        elseif ($gender === static::GENDER_FEMALE) {
            return static::firstNameFemale();
        }

        return $this->generator->parse(static::randomElement(static::$firstNameFormat));
    }

    public static function firstNameMale()
    {
        return static::randomElement(static::$firstNameMale);
    }

    public static function firstNameFemale()
    {
        return static::randomElement(static::$firstNameFemale);
    }

    /**
     * @return string
     * @example 'Doe'
     */
    public function lastName()
    {
        return static::randomElement(static::$lastName);
    }

    /**
     * @param string|null $gender 'male', 'female' or null for any
     * @return string
     * @example 'Mrs.'
     */
    public function title($gender = null)
    {
        if ($gender === static::GENDER_MALE) {
            return static::titleMale();
        }
        elseif ($gender === static::GENDER_FEMALE) {
            return static::titleFemale();
        }

        return $this->generator->parse(static::randomElement(static::$titleFormat));
    }

    /**
     * @example 'Mr.'
     */
    public static function titleMale()
    {
        return static::randomElement(static::$titleMale);
    }

    /**
     * @example 'Mrs.'
     */
    public static function titleFemale()
    {
        return static::randomElement(static::$titleFemale);
    }
}
