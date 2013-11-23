<?php

/**
 * This is the main interface for all included Google Map Web Services
 * For licensing and examples:
 *
 * @see https://github.com/jacobemerick/google-map-services
 *
 * @author jacobemerick (http://home.jacobemerick.com/)
 * @version 1.0 (2013-11-23)
 */

namespace GoogleMapAPI;

interface GoogleMapServiceInterface
{

    /**
     * URL endpoint for API requests
     * Note: the Time Zone API must use the secure version
     */
    const UNSECURE_ENDPOINT = 'http://maps.googleapis.com/maps/api/%s/%s?%s';
    const SECURE_ENDPOINT = 'https://maps.googleapis.com/maps/api/%s/%s?%s';

    /**
     * Placeholder construct - we don't need anything instantiated
     */
    public function __construct();

    /**
     * Type of service for the API to handle
     */
    public function getServiceName();

    /**
     * Query string build method
     */
    public function getQueryString();

}
