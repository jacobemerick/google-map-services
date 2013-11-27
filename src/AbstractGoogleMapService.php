<?php

/**
 * This is the abstract class for all Google Map Services
 * For licensing and examples:
 *
 * @see https://github.com/jacobemerick/google-map-services
 *
 * @author jacobemerick (http://home.jacobemerick.com/)
 * @version 1.1 (2013-11-27)
 */

namespace GoogleMapAPI;

abstract class AbstractGoogleMapService
{

    /**
     * Flag on whether or not the requesting device has a sensor
     * Note: the 'sensor' parameter is a required field for the API
     */
    protected $has_sensor = false;

    /**
     * Flag on whether or not to use SSL for the API endpoint
     * Note: time zone requires a secure request
     */
    protected $use_secure_endpoint = false;

    /**
     * Format the URL endpoint with all the parameters
     *
     * @param   string  $output_format  google output format (currently json or xml)
     * @return  string  full url endpoint for the request
     */
    protected function getURLEndpoint($output_format)
    {
        $endpoint = ($this->use_secure_endpoint) ? GoogleMapServiceInterface::SECURE_ENDPOINT : GoogleMapServiceInterface::UNSECURE_ENDPOINT;
        $service = $this->getServiceName();
        $query_string = $this->getQueryString();
        
        return sprintf($endpoint, $service, $output_format, $query_string);
    }

    /**
     * Helper method to format the coordinates for the final url parameter
     * Structured in such a way to handle a single point or multiple points
     *
     * @param   array   $coordinate_array   array of lat/long pairs
     * @return  string  list of locations formatted for the googles
     */
    protected function formatCoordinateParameter($coordinate_array)
    {
        $coordinate_list = array();
        foreach ($coordinate_array as $coordinate) {
            array_push($coordinate_list, implode(',', $coordinate));
        }
        return $this->formatArgumentArray($coordinate_list);
    }

    /**
     * Helper method to encode multiple parameters as a single argument
     * Basically implodes on a pipe, as per Google's spec
     *
     * @param   array   $argument_array     array of arguments for encoding
     * @return  string  list of arguments encoded for Google
     */
    protected function formatArgumentArray(array $argument_array)
    {
        return implode('|', $argument_array);
    }

    /**
     * Fetch the response as a JSON string
     *
     * @return  string  json response from the googles
     */
    public function fetchJSON()
    {
        $url = $this->getURLEndpoint('json');
        return $this->executeRequest($url);
    }

    /**
     * Fetch the response as a XML string (yes, a string, you'll need to do the SimpleXML)
     *
     * @return  string  xml response from the googles
     */
    public function fetchXML()
    {
        $url = $this->getURLEndpoint('xml');
        return $this->executeRequest($url);
    }

    /**
     * Actual request execution step via the curl
     * Accepts fully built and parameterized endpoint and asks google for information
     *
     * @param   $url    string  full endpoint for the service request
     * @return  string  string response from the request
     */
    protected function executeRequest($url)
    {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        return curl_exec($handle);
    }

}
