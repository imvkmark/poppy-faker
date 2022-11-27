<?php

namespace Poppy\Faker\Provider;

class Address extends Base
{
    protected static array $citySuffix = ['Ville'];

    protected static array $streetSuffix = ['Street'];

    protected static array $cityFormats = [
        '{{firstName}}{{citySuffix}}',
    ];

    protected static array $streetNameFormats = [
        '{{lastName}} {{streetSuffix}}',
    ];

    protected static array $streetAddressFormats = [
        '{{buildingNumber}} {{streetName}}',
    ];

    protected static array $addressFormats = [
        '{{streetAddress}} {{postcode}} {{city}}',
    ];

    protected static array $buildingNumber = ['%#'];

    protected static array $postcode = ['#####'];

    protected static array $country = [];

    /**
     * @example 'Sashabury'
     */
    public function city()
    {
        $format = static::randomElement(static::$cityFormats);

        return $this->generator->parse($format);
    }

    /**
     * @example 'Crist Parks'
     */
    public function streetName()
    {
        $format = static::randomElement(static::$streetNameFormats);

        return $this->generator->parse($format);
    }

    /**
     * @example '791 Crist Parks'
     */
    public function streetAddress()
    {
        $format = static::randomElement(static::$streetAddressFormats);

        return $this->generator->parse($format);
    }

    /**
     * @example '791 Crist Parks, Sashabury, IL 86039-9874'
     */
    public function address()
    {
        $format = static::randomElement(static::$addressFormats);

        return $this->generator->parse($format);
    }

    /**
     * @example 'town'
     */
    public static function citySuffix()
    {
        return static::randomElement(static::$citySuffix);
    }

    /**
     * @example 'Avenue'
     */
    public static function streetSuffix()
    {
        return static::randomElement(static::$streetSuffix);
    }

    /**
     * @example '791'
     */
    public static function buildingNumber()
    {
        return static::numerify(static::randomElement(static::$buildingNumber));
    }

    /**
     * @example 86039-9874
     */
    public static function postcode()
    {
        return static::toUpper(static::bothify(static::randomElement(static::$postcode)));
    }

    /**
     * @example 'Japan'
     */
    public static function country():string
    {
        return static::randomElement(static::$country);
    }

    /**
     * 经纬度范围由于采取的数据是有限的,这里需要给予限制
     * @param float|int $min
     * @param float|int $max
     * @return float Uses signed degrees format (returns a float number between -90 and 90)
     * @example '77.147489'
     */
    public static function latitude($min = -85.05, $max = 85.05): float
    {
        return static::randomFloat(6, $min, $max);
    }

    /**
     * @param float|int $min
     * @param float|int $max
     * @return float Uses signed degrees format (returns a float number between -180 and 180)
     * @example '86.211205'
     */
    public static function longitude($min = -180, $max = 180)
    {
        return static::randomFloat(6, $min, $max);
    }

    /**
     * @return array  [latitude, longitude]
     * @example array('77.147489', '86.211205')
     */
    public static function localCoordinates()
    {
        return [
            'latitude'  => static::latitude(),
            'longitude' => static::longitude(),
        ];
    }
}
