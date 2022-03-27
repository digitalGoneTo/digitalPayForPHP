Welcome to digital pay for PHP.

[Chinese API](./README_en.md)

## Environmental requirements
* 1.example demo requires 'PHP 7.0' or above;
* 2. Before using the example demo, you need to complete some preparations for the developer, including applying to become a merchant, obtaining the merchant key, setting the callback address, etc.
* 3. After the preparation work is completed, pay attention to save the following information, which will be used as the input for using the demo later:
    * 'Merchant ID=>merchantId', 'Payment background address=>SERVICE_URL', 'Merchant key=>SECRET_KEY'
## quick start
Clone this repository code to local
The following code shows you the steps to call the API using the example demo:
* 1. Set the global parameters (the global only needs to be set once)
* 2. Initiate an API call
* 3. Handle the response or exception
## Note that this is part of the code, please download the complete code to run
```injectablephp
const MERCHANT_ID = "your merchant ID";
const SERVICE_URL = "https://www.digitalpaypro.com/testapi"; //"https://www.digitalpaypro.com/api" prod environment
const SECRET_KEY = "your secret key";

````
```injectablephp
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

    // TODO your demo
    echo "success";
}

````
## Supported API list
| Capability category | Scenario category | Interface method name | OpenAPI address to call |
|----------|-----------------|--------------------|-------------------|
| base | order | createOrder | /api/order/createOrder |
| base | order | getInfo | /api/order/getInfo |

> Note: APIs for more high-frequency scenarios are being updated continuously, so stay tuned.

## Price tag principle

* 1. Get all POST content, excluding byte-type parameters, such as files, byte streams, remove the sign field, and remove parameters with empty values;
* 2. Sort in ascending order according to the key value ASCII code of the first character (in ascending alphabetical order), if the same character is encountered, it will be sorted in ascending order according to the key value ASCII code of the second character, and so on;
* 3. Combine the sorted parameters and their corresponding values ​​into the format of parameter=parameter value, and connect these parameters with the & character, and then splicing your merchant key at the end, the generated string at this time is to be signed string;
* 4. The string to be signed is encrypted by MD5, and the value of the signature string sign is generated;


You can also go to [API Doc](./APIDocEn.md) to view detailed usage instructions for each API.