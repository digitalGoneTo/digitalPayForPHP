<?php
const MERCHANT_ID = "your merchant ID";
const SERVICE_URL = "https://www.digitalpaypro.com/testapi"; //"https://www.digitalpaypro.com/api" prod environment
const SECRET_KEY = "your secret key";

createOrder();
//getInfo();
//notifyUrl();
function createOrder()
{
    $amount = "10"; //
    $outOrderNo = "yourOrderId";
    $merchantId = MERCHANT_ID; // your merchantId
    $array["merchantId"] = $merchantId;
    $array["outOrderNo"] = $outOrderNo;
    $array["amount"] = $amount;
    $sign = sign($array);
    $url = SERVICE_URL . "/api/order/createOrder?" . getStringBuilder($array) . "&sign=" . $sign;
    echo file_get_contents($url);
}

function getInfo()
{
    $outOrderNo = "yourOrderId";
    $merchantId = MERCHANT_ID; // your merchantId
    $array["merchantId"] = $merchantId;
    $array["outOrderNo"] = $outOrderNo;
    $sign = sign($array);
    $url = SERVICE_URL . "/api/order/getInfo?" . getStringBuilder($array) . "&sign=" . $sign;
    echo file_get_contents($url);
}


function notifyUrl()
{
    $arrayJson = file_get_contents('php://input');

    $array = json_decode($arrayJson,true);
    $sign = $array["sign"];
    unset($array["sign"]);
    if (!checkSign($array, $sign)) {
        //sign error!
        echo "sign error!";
        return;
    }

    // TODO  your demo
    echo "success";
}

function checkSign($array, $sign)
{
    $sign1 = sign($array);
    if ($sign == $sign1) {
        return true;
    }
    return false;
}


function getStringBuilder($array)
{
    ksort($array);
    $i = 0;
    $str = "";
    foreach ($array as $key => $value) {
        if (!empty($value)) {
            $value = trim($value);
            if ($i != 0) {
                $str .= "&";
            }
            $str .= $key . "=" . $value;
        }
        $i++;
    }
    return $str;
}

function sign($array)
{
    $str = getStringBuilder($array);
    return md5($str . SECRET_KEY);
}