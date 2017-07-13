<?php
use yii\helpers\Json;

/* @var $this \yii\base\View */
/* @var $token string */
/* @var $error string */
/* @var $url string */
/* @var $enforceRedirect bool */
?>
<!DOCTYPE html>
<html>
<head>
    <script>
        function popupWindowRedirect(url, enforceRedirect, token)
        {
            if (window.opener && !window.opener.closed) {
                window.opener.localStorage.setItem('token', token);
                if (enforceRedirect === undefined || enforceRedirect) {
                    window.opener.location = url;
                }
                window.opener.focus();
                window.close();
            } else {
                window.localStorage.setItem('token', token);
            }
        }
        popupWindowRedirect(<?= Json::htmlEncode($url) ?>, <?= Json::htmlEncode($enforceRedirect) ?>, <?= Json::htmlEncode($token) ?>);
    </script>
</head>
<body>

<div id="token" data-token="<?= Json::htmlEncode($token) ?>" data-error="<?= Json::htmlEncode($error) ?>"></div>


</body>
</html>
