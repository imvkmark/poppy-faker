<?php

declare(strict_types = 1);

namespace Poppy\Faker\JsonSchema;


use InvalidArgumentException;
use LogicException;
use Poppy\Faker\Factory;
use Poppy\Faker\Provider\Base;
use Poppy\Faker\Provider\DateTime;
use Poppy\Faker\Provider\Internet;
use Poppy\Faker\Provider\Lorem;
use SplFileInfo;
use stdClass;

final class Faker
{
    /**
     * type-fake method map
     *
     * @var array
     */
    private $fakers = [
        'null'    => 'fakeNull',
        'boolean' => 'fakeBoolean',
        'integer' => 'fakeInteger',
        'number'  => 'fakeNumber',
        'string'  => 'fakeString',
        'array'   => 'fakeArray',
        'object'  => 'fakeObject',
    ];

    /**
     * @var string
     */
    private $schemaDir;

    /**
     * Create fake data with JSON schema
     *
     * @param SplFileInfo|stdClass $schema       Data structure written in JSON Schema
     * @param stdClass|null        $parentSchema parent schema when it is subschema
     * @param string|null          $schemaDir    forced directory in object loop
     *
     * @throws UnsupportedTypeException Throw when unsupported type specified
     */
    public function generate($schema, stdClass $parentSchema = null, string $schemaDir = null)
    {
        if ($schema instanceof SplFileInfo) {
            $file = (string) $schema->getRealPath();
            if (file_exists($file)) {
                $this->schemaDir = dirname($file);
            }
            $schema = json_decode((string) file_get_contents($file));
        }
        if (!$schema instanceof stdClass) {
            throw new InvalidArgumentException(gettype($schema));
        }
        $schema = $this->resolveOf($schema);
        if (property_exists($schema, '$ref')) {
            $currentDir = $schemaDir ?? $this->schemaDir;

            return (new Ref($this, $currentDir))($schema, $parentSchema);
        }
        $type = is_array($schema->type) ? Base::randomElement($schema->type) : $schema->type;

        if (isset($schema->enum)) {
            return Base::randomElement($schema->enum);
        }

        if (isset($schema->const)) {
            return Base::randomElement([$schema->const]);
        }

        if (!isset($this->fakers[$type])) {
            throw new UnsupportedTypeException($type);
        }

        $faker = [$this, $this->fakers[$type]];
        if (is_callable($faker)) {
            return call_user_func($faker, $schema);
        }

        throw new LogicException;
    }

    public function mergeObject()
    {
        $merged  = [];
        $objList = func_get_args();

        foreach ($objList as $obj) {
            $merged = array_merge($merged, (array) $obj);
        }

        return (object) $merged;
    }

    public function getMaximum($schema): int
    {
        $offset = ($schema->exclusiveMaximum ?? false) ? 1 : 0;

        return (int) ($schema->maximum ?? mt_getrandmax()) - $offset;
    }

    public function getMinimum($schema): int
    {
        $offset = ($schema->exclusiveMinimum ?? false) ? 1 : 0;

        return (int) ($schema->minimum ?? -mt_getrandmax()) + $offset;
    }

    public function resolveDependencies(stdClass $schema, array $keys): array
    {
        $resolved     = [];
        $dependencies = $schema->dependencies ?? new stdClass();

        foreach ($keys as $key) {
            $resolved = array_merge($resolved, [$key], $dependencies->{$key} ?? []);
        }

        return $resolved;
    }

    public function getRandomSchema()
    {
        $fakerNames = array_keys($this->fakers);

        return (object) [
            'type' => Base::randomElement($fakerNames),
        ];
    }

    public function resolveOf(stdClass $schema): stdClass
    {
        if (isset($schema->allOf)) {
            return call_user_func_array([$this, 'mergeObject'], $schema->allOf);
        }
        if (isset($schema->anyOf)) {
            return call_user_func_array([$this, 'mergeObject'], Base::randomElements($schema->anyOf));
        }
        if (isset($schema->oneOf)) {
            return Base::randomElement($schema->oneOf);
        }

        return $schema;
    }

    public function getMultipleOf($schema): int
    {
        return $schema->multipleOf ?? 1;
    }

    public function getInternetFakerInstance(): Internet
    {
        return new Internet(Factory::create());
    }

    public function getFormattedValue($schema)
    {
        switch ($schema->format) {
            // Date representation, as defined by RFC 3339, section 5.6.
            case 'date-time':
                return DateTime::dateTime()->format(DATE_RFC3339);
            // Internet email address, see RFC 5322, section 3.4.1.
            case 'email':
                return $this->getInternetFakerInstance()->safeEmail();
            // Internet host name, see RFC 1034, section 3.1.
            case 'hostname':
                return $this->getInternetFakerInstance()->domainName();
            // IPv4 address, according to dotted-quad ABNF syntax as defined in RFC 2673, section 3.2.
            case 'ipv4':
                return $this->getInternetFakerInstance()->ipv4();
            // IPv6 address, as defined in RFC 2373, section 2.2.
            case 'ipv6':
                return $this->getInternetFakerInstance()->ipv6();
            // A universal resource identifier (URI), according to RFC3986.
            case 'uri':
                return $this->getInternetFakerInstance()->url();
            default:
                throw new UnsupportedTypeException("Unsupported type: {$schema->format}");
        }
    }

    /**
     * @return string[] Property names
     */
    public function getProperties(stdClass $schema): array
    {
        $requiredKeys   = $schema->required ?? [];
        $optionalKeys   = array_keys((array) ($schema->properties ?? new stdClass()));
        $maxProperties  = $schema->maxProperties ?? count($optionalKeys) - count($requiredKeys);
        $pickSize       = Base::numberBetween(0, min(count($optionalKeys), $maxProperties));
        $additionalKeys = $this->resolveDependencies($schema, Base::randomElements($optionalKeys, $pickSize));
        $propertyNames  = array_unique(array_merge($requiredKeys, $additionalKeys));

        $additionalProperties = $schema->additionalProperties ?? true;
        $patternProperties    = $schema->patternProperties ?? new stdClass();
        $patterns             = array_keys((array) $patternProperties);
        while (count($propertyNames) < ($schema->minProperties ?? 0)) {
            $name = $additionalProperties ? Lorem::word() : Lorem::regexify(Base::randomElement($patterns));
            if (!in_array($name, $propertyNames, true)) {
                $propertyNames[] = $name;
            }
        }

        return $propertyNames;
    }

    private function fakeNull()
    {
        return null;
    }

    private function fakeBoolean(): bool
    {
        return Base::randomElement([true, false]);
    }

    private function fakeInteger(stdClass $schema): int
    {
        $minimum    = $this->getMinimum($schema);
        $maximum    = $this->getMaximum($schema);
        $multipleOf = $this->getMultipleOf($schema);

        return Base::numberBetween($minimum, $maximum) * $multipleOf;
    }

    private function fakeNumber(stdClass $schema)
    {
        $minimum    = $this->getMinimum($schema);
        $maximum    = $this->getMaximum($schema);
        $multipleOf = $this->getMultipleOf($schema);

        return Base::randomFloat(null, $minimum, $maximum) * $multipleOf;
    }

    private function fakeString(stdClass $schema): string
    {
        if (isset($schema->format)) {
            return $this->getFormattedValue($schema);
        }
        if (isset($schema->pattern)) {
            return Lorem::regexify($schema->pattern);
        }
        $min = $schema->minLength ?? 1;
        $max = $schema->maxLength ?? max(5, $min + 1);
        if ($max < 5) {
            return substr(Lorem::text(5), 0, $max);
        }
        $lorem = Lorem::text($max);

        if (mb_strlen($lorem) < $min) {
            $lorem = str_repeat($lorem, $min);
        }

        return mb_substr($lorem, 0, $max);
    }

    private function fakeArray(stdClass $schema): array
    {
        if (!isset($schema->items)) {
            $subschemas = [$this->getRandomSchema()];
            // List
        }
        elseif (is_object($schema->items)) {
            $subschemas = [$schema->items];
            // Tuple
        }
        elseif (is_array($schema->items)) {
            $subschemas = $schema->items;
        }
        else {
            throw new InvalidItemsException;
        }

        $dummies    = [];
        $itemSize   = Base::numberBetween(($schema->minItems ?? 0), $schema->maxItems ?? count($subschemas));
        $subschemas = array_slice($subschemas, 0, $itemSize);
        $dir        = $this->schemaDir;
        for ($i = 0; $i < $itemSize; $i++) {
            $subschema = $subschemas[$i % count($subschemas)];
            $dummies[] = $this->generate($subschema, $schema, $dir);
        }
        $this->schemaDir = $dir;

        return ($schema->uniqueItems ?? false) ? array_unique($dummies) : $dummies;
    }

    private function fakeObject(stdClass $schema): stdClass
    {
        $dir           = $this->schemaDir;
        $properties    = $schema->properties ?? new stdClass();
        $propertyNames = $this->getProperties($schema);

        $dummy     = new stdClass();
        $schemaDir = $this->schemaDir;
        foreach ($propertyNames as $key) {
            if (isset($properties->{$key})) {
                $subschema = $properties->{$key};
            }
            else {
                $subschema = $this->getAdditionalPropertySchema($schema, $key) ?: $this->getRandomSchema();
            }

            $dummy->{$key} = $this->generate($subschema, $schema, $schemaDir);
        }
        $this->schemaDir = $dir;

        return $dummy;
    }

    private function getAdditionalPropertySchema(stdClass $schema, $property)
    {
        $patternProperties    = $schema->patternProperties ?? new stdClass();
        $additionalProperties = $schema->additionalProperties ?? true;

        foreach ($patternProperties as $pattern => $sub) {
            if (preg_match("/{$pattern}/", $property)) {
                return $sub;
            }
        }

        if (is_object($additionalProperties)) {
            return $additionalProperties;
        }
    }
}
