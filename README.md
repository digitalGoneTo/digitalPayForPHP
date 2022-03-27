歡迎使用digital pay for PHP.

[English API](./README_en.md)

## 環境要求
* 1.example demo 需要配合'PHP 7.0'  或其以上版本;
* 2.使用 example demo之前 您需要先完成開發者一些準備工作,包括申請成爲商戶,獲取商戶密鑰,設置回調地址等.
* 3.準備工作完成之後,注意保存如下信息,後續將作爲使用demo的輸入:
  * '商戶ID=>merchantId'、'支付後臺地址=>SERVICE_URL'、'商戶密鑰=>SECRET_KEY'
 ## 快速開始
 克隆此倉庫代碼到本地
 以下代碼向您展示使用example demo 調用API步驟:
 * 1.設置全局參數(全局只需要設置一次) 
 * 2.發起API調用
 * 3.處理響應或異常
 ## 注意此為部分代碼 請下載完整代碼運行
```injectablephp
const MERCHANT_ID = "your merchant ID";
const SERVICE_URL = "https://www.digitalpaypro.com/testapi"; //"https://www.digitalpaypro.com/api" prod environment
const SECRET_KEY = "your secret key";

```
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

    // TODO  your demo
    echo "success";
}

```
## 支持的API列表
| 能力類別   | 場景類別         | 接口方法名稱           | 調用的OpenAPI地址                                         |
|-----------|-----------------|-----------------------|-----------------------------------------------------------|
| base      | order           | createOrder            | /api/order/createOrder                                        |
| base      | order           | getInfo               | /api/order/getInfo                                        |

> 注：更多高頻場景的API持續更新中，敬請期待。

## 價簽原理

* 1.獲取所有POST内容,不包括字節類型參數,如文件、字節流,剔除sign字段,剔除值爲空的參數;
* 2.按照第一個字符的鍵值ASCII碼遞增排序(字母升序排序),如果遇到相同字符則按照第二個字符的鍵值ASCII碼遞增排序,以此類推;
* 3.將排序后的參數與其對應值,組合成 參數=參數值 的格式,并且把這些參數用 & 字符連接起來,然後最後拼接上您的商戶密鑰,此時生成的字符串為待簽名字符串;
* 4.待簽名字符串以MD5方式加密,生成的就是簽名字符串sign的值;


您還可以前往[API Doc](./APIDoc.md)查看每個API的詳細使用説明。
