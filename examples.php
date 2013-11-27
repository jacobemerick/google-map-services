<?php

include 'src/service/ElevationService.php';

// example - get the elevation of a single point
$request = new GoogleMapAPI\Service\ElevationService();
$request->addCoordinate(47.12113, -88.56942);
$response = $request->fetchJSON();

$json = json_decode($response);
if ($json->status == 'OK') {
    $elevation = $json->results[0]->elevation;
}

// example - get the elevation of a set of points in SimpleXML
$request = new GoogleMapAPI\Service\ElevationService();
$request->addCoordinate(44.51916, -88.01983);
$request->addCoordinate(44.26193, -88.41538);
$request->addCoordinate(44.02471, -88.54261);
$response = $request->fetchXML();

$xml = simplexml_load_string($response);
if ($xml->status == 'OK') {
    $elevation_list = array();
    foreach ($xml->result as $result) {
        array_push($elevation_list, (float) $result->elevation);
    }
}


include 'src/service/GeocodeService.php';

// example - get the latlng of an address
$request = new GoogleMapAPI\Service\GeocodeService();
$request->setAddress('Skanee, MI');
$response = $request->fetchJSON();

$json = json_decode($response);
if ($json->status == 'OK') {
    $coordinate = $json->results[0]->geometry->location;
}

// example (reverse geocode) - get the address of a coordinate
$request = new GoogleMapAPI\Service\GeocodeService();
$request->setCoordinate(46.78584, -87.72877);
$response = $request->fetchXML();

$xml = simplexml_load_string($response);
if ($xml->status == 'OK') {
    $address = $xml->result[0]->formatted_address;
}


include 'src/service/DistanceMatrixService.php';

// example - fetch a single distance result
$request = new GoogleMapAPI\Service\DistanceMatrixService();
$request->addOrigin('Houghton, MI');
$request->addDestination('Marquette, MI');
$response = $request->fetchJSON();

$json = json_decode($response);
if ($json->status == 'OK') {
    if ($json->rows[0]->elements[0]->status == 'OK') {
        $distance = $json->rows[0]->elements[0]->distance->text;
    }
}

// example - determining the closest city
$destination_array = array(
    "L'Anse, MI",
    'Ontonagon, MI',
    'Mohawk, MI',
);

$request = new GoogleMapAPI\Service\DistanceMatrixService();
$request->addOrigin('Houghton, MI');
foreach ($destination_array as $destination) {
    $request->addDestination($destination);
}
$response = $request->fetchXML();

$xml = simplexml_load_string($response);
if ($xml->status == 'OK') {
    $distance_array = array();
    foreach ($xml->row[0]->element as $element) {
        if ($element->status == 'OK') {
            array_push($distance_array, (string) $element->distance->value);
        }
    }
    
    asort($distance_array);
    reset($distance_array);
    $closest_destination_key = key($distance_array);
    $closest_destination = $destination_array[$closest_destination_key];
}