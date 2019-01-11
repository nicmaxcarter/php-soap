<?php

$soapclient = new SoapClient('https://services.omnitracs.com/qtracsWebWS/services/QTWebSvcs/wsdl/QTWebSvcs.wsdl');

function getFunctions()
{
    global $soapclient;
    $array = $soapclient->__getFunctions();
    printResponse($array);
}
function getTypes()
{
    global $soapclient;
    $array = $soapclient->__getTypes();
    printResponse($array);
}

function printResponse($response)
{
    foreach ($response as $item) {
        echo '<pre>';
        print_r($item);
    }
}

function exportVehicles()
{
    $wsdl = "https://services.omnitracs.com/qtracsWebWS/services/QTWebSvcs/wsdl/QTWebSvcs.wsdl";

    // Or 'soap_version' => SOAP_1_1 if your using SOAP 1.1
    $options = array(
        'location' => 'https://services.omnitracs.com:443/qtracsWebWS/services/QTWebSvcs',
        'soap_version' => SOAP_1_1,
        'trace' => 1,
        'SOAPAction' => '');

    $client = new SoapClient($wsdl, $options);

    // Add the WSS username token headers
    addHeader($client, 'max@CDSTTRANSP', 'FedEx19$');


    try {
        $response = $client->exportVehicleIdentification();
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
    // printResponse($response);

    echo '<br><br><br>';

    echo "REQUEST:<br/>" . htmlentities(str_ireplace('><', ">\n<", $client->__getLastRequest())) . "<br/>";

}


function addHeader($client){
    $namespace = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
    $name = 'Security';

}




// getFunctions();
// getTypes();
// getHolidaysAvailable();
exportVehicles();
