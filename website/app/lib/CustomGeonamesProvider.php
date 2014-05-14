<?php

namespace Geocoder\Provider;

use Geocoder\Exception\InvalidCredentialsException;
use Geocoder\Exception\NoResultException;
use Geocoder\Exception\UnsupportedException;
use Geocoder\HttpAdapter\HttpAdapterInterface;

class CustomGeonamesProvider extends GeonamesProvider
{
    /**
     * @var string
     */
    const GEOCODE_ENDPOINT_URL = 'http://api.geonames.org/searchJSON?q=%s&maxRows=%d&style=full&username=%s';

    /**
     * @var string
     */
    const REVERSE_ENDPOINT_URL = 'http://api.geonames.org/findNearbyPlaceNameJSON?lat=%F&lng=%F&style=full&maxRows=%d&username=%s&radius=%s';

    private $radius = 5;


    /**
     * @var string
     */
    protected $username = null;

    /**
     * @param HttpAdapterInterface $adapter  An HTTP adapter.
     * @param string               $username Username login (Free registration at http://www.geonames.org/login)
     * @param string               $locale   A locale (optional).
     */
    public function __construct(HttpAdapterInterface $adapter, $username, $locale = null)
    {
        parent::__construct($adapter, $locale);
        $this->username = $username;
    }

    /**
     * {@inheritDoc}
     */
    public function getGeocodedData($address)
    {
        if (null === $this->username) {
            throw new InvalidCredentialsException('No Username provided');
        }

        // This API doesn't handle IPs
        if (filter_var($address, FILTER_VALIDATE_IP)) {
            throw new UnsupportedException('The GeonamesProvider does not support IP addresses.');
        }

        $query = sprintf(self::GEOCODE_ENDPOINT_URL, urlencode($address), $this->getMaxResults(), $this->username);

        return $this->executeQuery($query);
    }

    /**
     * Added $radius argument
     */
    public function getReversedData(array $coordinates)
    {
        if (null === $this->username) {
            throw new InvalidCredentialsException('No Username provided');
        }
        $query = sprintf(self::REVERSE_ENDPOINT_URL, $coordinates[0], $coordinates[1], $this->getMaxResults(), $this->username, $this->radius);
        return $this->executeQuery($query);
    }

    public function setRadius($radius) {
        $this->radius = $radius;
    }

}
