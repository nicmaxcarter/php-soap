<?php

$soapclient = new SoapClient('https://services.omnitracs.com/qtracsWebWS/services/QTWebSvcs/wsdl/QTWebSvcs.wsdl');

function getFunctions()
{
    global $soapclient;

    $array = $soapclient->__getFunctions();

    // foreach ($array as $item) {
    //     echo '<pre>';
    //     echo $item;
    // }

    printResponse($array);
}
function getTypes()
{
    global $soapclient;

    $array = $soapclient->__getTypes();

    foreach ($array as $item) {
        echo '<pre>';
        echo $item;
    }
}

function printResponse($response)
{
    foreach ($response as $item) {
        echo '<pre>';
        print_r($item);
    }
}

function getHolidaysAvailable()
{

    global $soapclient;

    // $response = $soapclient->GetHolidaysAvailable();

    // $temp = json_decode(json_encode($response), true);

    // echo $temp['GetHolidaysAvailable']['CountryCode']['5'];

    $response = $soapclient->__soapCall('GetHolidaysAvailable', array('parameters' => array('countryCode' => 'Scotland')));

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
        'location' => 'https://services.omnitracs.com/qtracsWebWS/services/QTWebSvcs/wsdl/QTWebSvcs.wsdl',
        'soap_version' => SOAP_1_2,
        'trace' => 1,
        'SOAPAction' => '');

    $client = new SoapClient($wsdl, $options);

    // Add the WSS username token headers
    AddWSSUsernameToken($client, 'max@CDSTTRANSP', 'FedEx19$');

    // $headerbody = array(
    //     'wsse:Security soap:mustUnderstand="1"' => array(

    //     ),
    // );

    // $header = new SOAPHeader($ns, 'RequestorCredentials', $headerbody);
    try {
        $response = $client->exportVehicleIdentification();
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
    // printResponse($response);

    echo '<br><br><br>';

    echo "REQUEST:<br/>" . htmlentities(str_ireplace('><', ">\n<", $client->__getLastRequest())) . "<br/>";

}

function AddWSSUsernameToken($client, $username, $password)
{
    $wssNamespace = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";

    $username = new SoapVar($username,
        XSD_STRING,
        null, null,
        'Username',
        $wssNamespace);

    $password = new SoapVar($password,
        XSD_STRING,
        null, null,
        'Password',
        $wssNamespace);

    $usernameToken = new SoapVar(array($username, $password),
        SOAP_ENC_OBJECT,
        null, null, 'UsernameToken',
        $wssNamespace);

    $usernameToken = new SoapVar(array($usernameToken),
        SOAP_ENC_OBJECT,
        null, null, null,
        $wssNamespace);

    $wssUsernameTokenHeader = new SoapHeader($wssNamespace, 'Security', $usernameToken);

    $client->__setSoapHeaders($wssUsernameTokenHeader);
}

// getFunctions();
// getTypes();
// getHolidaysAvailable();
exportVehicles();
