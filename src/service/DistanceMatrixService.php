<?php

/**
 * This is the main class for Google Distance Matrix Service
 * @url https://developers.google.com/maps/documentation/distancematrix/
 * For licensing and examples:
 *
 * @see https://github.com/jacobemerick/google-map-services
 *
 * @author jacobemerick (http://home.jacobemerick.com/)
 * @version 1.0 (2013-11-27)
 */

namespace GoogleMapAPI\Service;

// @todo autoloader, maybe
include_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'AbstractGoogleMapService.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'GoogleMapServiceInterface.php';

use GoogleMapAPI\AbstractGoogleMapService as AbstractService;
use GoogleMapAPI\GoogleMapServiceInterface as ServiceInterface;

class DistanceMatrixService extends AbstractService implements ServiceInterface
{

    /**
     * Arry to hold onto all origins passed in
     * Each origin can be a string address or lat/long pair
     */
    protected $origin_array = array();

    /**
     * Arry to hold onto all destinations passed in
     * Each destination can be a string address or lat/long pair
     */
    protected $destination_array = array();

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
        return 'distancematrix';
    }

    /**
     * Add a new origin for the request, either a street address or coordinate
     * Note: if you are passing in coordinate, make sure there is no whitespace (or use addCoordinateOrigin)
     *
     * @param   string  $origin    origin for the request
     */
    public function addOrigin($origin)
    {
        array_push($this->origin_array, $origin);
    }

    /**
     * Add a new coordinate to the origin array
     * Note: this is just a helper to correctly format coordinates before adding to origin array
     *
     * @param   float   $latitude   latitude in decimal format
     * @param   flat    $longitude  longitude in decimal format
     */
    public function addCoordinateOrigin($latitude, $longitude)
    {
        $origin = $this->formatCoordinateParameters(array($latitude, $longitude));
        $this->addOrigin($origin);
    }

    /**
     * Add a new destination for the request, either a street address or coordinate
     * Note: if you are passing in coordinate, make sure there is no whitespace (or use addCoordinateDestination)
     *
     * @param   string  $destination    destination for the request
     */
    public function addDestination($destination)
    {
        array_push($this->destination_array, $destination);
    }

    /**
     * Add a new coordinate to the destination array
     * Note: this is just a helper to correctly format coordinates before adding to destination array
     *
     * @param   float   $latitude   latitude in decimal format
     * @param   flat    $longitude  longitude in decimal format
     */
    public function addCoordinateDestination($latitude, $longitude)
    {
        $destination = $this->formatCoordinateParameter(array($latitude, $longitude));
        $this->addDestination($destination);
    }

    /**
     * Format the URL query string with all the parameters
     * Note: this does not validate the parameters
     * @url https://developers.google.com/maps/documentation/distancematrix/#DistanceMatrixRequests
     *
     * @return  string  query string for the request
     */
    public function getQueryString()
    {
        $query = array(
            'sensor' => ($this->has_sensor) ? 'true' : 'false',
        );
        
        if (count($this->origin_array) > 0) {
            $query['origins'] = $this->formatArgumentArray($this->origin_array);
        }
        
        if (count($this->destination_array) > 0) {
            $query['destinations'] = $this->formatArgumentArray($this->destination_array);
        }
        
        return http_build_query($query);
    }

}
