<?php
require_once("PayPal-PHP-SDK/autoload.php");

$apiContext=new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(

        'AViEltmBLtEqOR7RGlWRhW_KWcGwtH_zdj90oQB8n-VzYZhW-KGXokJVVbovPIBfd3Vf8M2fQxTTU5QV',
        'EI5jFC4CQwzRbbSyztRvMEKi5wW9zjBi3eR6E7ctSul4tBA5SxtDENmDhRs17vTYX5qR2m5PPVf6MYFM'

    )
);

?>