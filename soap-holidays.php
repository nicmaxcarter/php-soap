<?php

$soapclient = new SoapClient('http://www.holidaywebservice.com/HolidayService_v2/HolidayService2.asmx?wsdl', array("trace" => 1, "exception" => 0));

function getFunctions()
{
    global $soapclient;

    $array = $soapclient->__getFunctions();

    foreach ($array as $item) {
        echo '<pre>';
        echo $item;
    }
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

// function getHolidaysAvailable($code) {

//     global $soapclient;

//     $countryCode = array('countryCode' => $code);

//     $response = $soapclient->__call('GetHolidaysAvailable', array('parameters' => $countryCode));

//     // foreach ( $response as $item ) {
//     //     echo '<pre>';
//     //     print_r($item);
//     // }

//     echo "REQUEST:<br/>" . htmlentities(str_ireplace('><', ">\n<", $soapclient->__getLastRequest())) . "<br/>";
// }
function getHolidaysAvailable($code)
{

    global $soapclient;

    $countryCode = array('countryCode' => $code, );

    $response = $soapclient->GetHolidaysAvailable($countryCode);

    printResponse($response);

    echo "REQUEST:<br/>" . htmlentities(str_ireplace('><', ">\n<", $soapclient->__getLastRequest())) . "<br/>";
}

function test()
{
    try {
        global $soapclient;
        $response = $soapclient->GetCountriesAvailable();

        var_dump($response);
        echo '<br><br><br>';
        $array = json_decode(json_encode($response), true);
        print_r($array);
        echo '<br><br><br>';
        echo $array['GetCountriesAvailableResult']['CountryCode']['5']['Description'];
        echo '<br><br><br>';
        foreach ($array as $item) {
            echo '<pre>';
            var_dump($item);
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

// getFunctions();

// getTest();
// test();
// getTypes();
getHolidaysAvailable('Scotland');
