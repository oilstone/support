<?php

namespace App\Services\Countries;

use Illuminate\Support\Collection;
use Oilstone\GlobalClasses\MakeGlobal;
use PragmaRX\Countries\Package\Countries as Resolver;

/**
 * Class Countries
 * @package App\Services\Countries
 */
class Countries extends MakeGlobal
{
    /**
     * @var Countries
     */
    protected static $instance;

    /**
     * @var Resolver
     */
    protected $resolver;

    /**
     * Countries constructor.
     */
    public function __construct()
    {
        $this->resolver = new Resolver();
    }

    /**
     * @return Countries
     */
    public static function instance(): Countries
    {
        return static::$instance;
    }

    /**
     * @return array
     */
    public function countryNameList(): array
    {
        /** @var Collection $countries */
        /** @noinspection PhpUndefinedMethodInspection */
        $countries = $this->resolver->all();

        return $countries->pluck('name.common')->sortBy(function ($country) {
            return $country === 'United Kingdom' ? -1 : $country;
        })->toArray();
    }

    /**
     * @param string $countryName
     * @return null|string
     */
    public function countryCodeFromName(string $countryName): ?string
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->resolver->where('name.common', $countryName)->first()['cca2'] ?? null;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->resolver->{$name}(...$arguments);
    }
}