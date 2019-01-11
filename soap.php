<?php

// Special class required
require './WSSoapClient.php';

// Global Variables
$wsdl = 'https://services.omnitracs.com/qtracsWebWS/services/QTWebSvcs/wsdl/QTWebSvcs.wsdl';
$endpoint = 'https://services.omnitracs.com/qtracsWebWS/services/QTWebSvcs';

$options = array(
    'location' => $GLOBALS['endpoint'],
    'soap_version' => SOAP_1_1,
    'trace' => 1,
    'SOAPAction' => '');

$username = 'max@CDSTTRANSP';
$password = 'FedEx19$';
$companyId = 'CDSTTRANSP';

$client = new WSSoapClient($wsdl, $options);

// Preview Functions
function getFunctions()
{
    global $soapclient;
    $array = $soapclient->__getFunctions();
    printResponse($array);
}

// Preview function and their parameters
function getTypes()
{
    global $soapclient;
    $array = $soapclient->__getTypes();
    printResponse($array);
}

// Print response from SOAP request
function printResponse($response)
{
    foreach ($response as $item) {
        echo '<pre>';
        print_r($item);
    }
}

// Print out the last request in XML format
function printLastRequest($client)
{
    echo "<br/><br/><br/>REQUEST:<br/>" . htmlentities(str_ireplace('><', ">\n<", $client->__getLastRequest())) . "<br/>";
}

function exportVehicles($client, $numOfVehicles)
{
    // Add the WSS username token headers
    $client->__setUsernameToken($client, $GLOBALS['username'], $GLOBALS['password']);

    $params = array();
    $params[] = new SoapVar($GLOBALS['companyId'], XSD_STRING, null, null, 'companyId');
    $params[] = new SoapVar(array('id' => '', 'scac' => ''), SOAP_ENC_OBJECT, 'AssetIdentifier', 'http://datatype.qtracswebws', 'AssetIdentifier');
    $params[] = new SoapVar($numOfVehicles, XSD_INT, null, null, 'numOfVehicles');

    try {
        $response = $client->exportVehicleIdentification(new SoapVar($params, SOAP_ENC_OBJECT));
        printResponse($response);
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }

    printLastRequest($client);

}

// getFunctions();
// getTypes();
// getHolidaysAvailable();
exportVehicles($client, 2);
