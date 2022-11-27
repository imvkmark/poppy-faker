<?php

namespace Poppy\Faker\Provider;

class Company extends Base
{
    protected static array $formats = [
        '{{lastName}} {{companySuffix}}',
    ];

    protected static array $companySuffix = ['Ltd'];

    protected static array $jobTitleFormat = [
        '{{word}}',
    ];

    /**
     * @return string
     * @example 'Acme Ltd'
     *
     */
    public function company()
    {
        $format = static::randomElement(static::$formats);

        return $this->generator->parse($format);
    }

    /**
     * @return string
     * @example 'Ltd'
     *
     */
    public static function companySuffix()
    {
        return static::randomElement(static::$companySuffix);
    }

    /**
     * @return string
     * @example 'Job'
     *
     */
    public function jobTitle()
    {
        $format = static::randomElement(static::$jobTitleFormat);

        return $this->generator->parse($format);
    }
}
