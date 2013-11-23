<?php

/**
 * This is the main class for Google Elevation Service
 * @url https://developers.google.com/maps/documentation/elevation/
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

class ElevationService extends AbstractService implements ServiceInterface
{

    /**
     * Array to hold onto coordinates
     * Coordinates will be saved as lat/long pairs
     */
    protected $coordinate_array = array();

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
        return 'elevation';
    }

    /**
     * Add a new coordinate pair to the coordinate array
     *
     * @param   float   $latitude   latitude in decimal format
     * @param   flat    $longitude  longitude in decimal format
     */
    public function addCoordinate($latitude, $longitude)
    {
        $coordinate = array($latitude, $longitude);
        array_push($this->coordinate_array, $coordinate);
    }

    /**
     * Format the URL query string with all the parameters
     * Note: this does not validate the parameters
     * @url https://developers.google.com/maps/documentation/elevation/#ElevationRequests
     *
     * @return  string  query string for the request
     */
    public function getQueryString()
    {
        $query = array(
            'locations' => $this->formatCoordinateParameter($this->coordinate_array),
            'sensor' => ($this->has_sensor) ? 'true' : 'false',
        );
        
        return http_build_query($query);
    }

}
