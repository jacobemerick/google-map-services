<?php

/**
 * This is the main class for Google Geocoding Service
 * @url https://developers.google.com/maps/documentation/geocoding/
 * For licensing and examples:
 *
 * @see https://github.com/jacobemerick/google-map-services
 *
 * @author jacobemerick (http://home.jacobemerick.com/)
 * @version 1.0 (2013-11-23)
 */

namespace GoogleMapAPI\Service;

// @todo autoloader, maybe
include_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'AbstractGoogleMapService.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'GoogleMapServiceInterface.php';

use GoogleMapAPI\AbstractGoogleMapService as AbstractService;
use GoogleMapAPI\GoogleMapServiceInterface as ServiceInterface;

class GeocodeService extends AbstractService implements ServiceInterface
{

    /**
     * Address variable for 'normal' geocoding
     */
    protected $address;

    /**
     * Array to hold onto a single coordinate for reverse geocoding
     * Coordinate is saved as a lat/long pair
     */
    protected $coordinate = array();

    /**
     * Placeholder construct
     */
    public function __construct() {}

    /**
     * The name of the service as per Google
     * @url https://developers.google.com/maps/documentation/webservices/#WebServices
     *
     * @return  string  acceptable service name for the request
     */
    public function getServiceName()
    {
        return 'geocode';
    }

    /**
     * Set address for normal geocoding
     *
     * @param   string  $address    address for geocoding
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Set a new coordinate pair for reverse geocoding
     * @url https://developers.google.com/maps/documentation/geocoding/#ReverseGeocoding
     *
     * @param   float   $latitude   latitude in decimal format
     * @param   flat    $longitude  longitude in decimal format
     */
    public function setCoordinate($latitude, $longitude)
    {
        $this->coordinate = array($latitude, $longitude);
    }

    /**
     * Format the URL query string with all the parameters
     * Note: this does not validate the parameters
     * @url https://developers.google.com/maps/documentation/geocoding/#GeocodingRequests
     *
     * @return  string  query string for the request
     */
    public function getQueryString()
    {
        $query = array(
            'sensor' => ($this->has_sensor) ? 'true' : 'false',
        );
        
        if (isset($this->address) && strlen($this->address) > 0) {
            $query['address'] = $this->address;
        }
        
        if (isset($this->coordinate) && count($this->coordinate) == 2) {
            $query['latlng'] = $this->formatCoordinateParameter(array($this->coordinate));
        }
        
        return http_build_query($query);
    }

}
