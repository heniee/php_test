
<?php

function pr($in, $exit=false, $ip="") {
    if( $ip && $_SERVER['REMOTE_ADDR'] != $ip ) return;

    if( is_array( $in ) ){
        echo "<pre>";
        print_r($in);
        echo "</pre>";
    }
    else{
        var_dump($in);
        echo "<br>";
    }
    if( $exit ) exit;
}

function msg($msg, $url="", $target="", $replace=3, $param=array()) {
    if($msg) $str = "<script>alert('".$msg."');</script>";
    switch($url) {
        case "":
            $str .=
                "<script>
                    if(parent.document.getElementsByClassName('pay_buy_btn')[0]) {
                        var payBuyButton = parent.document.getElementsByClassName('pay_buy_btn')[0];
                        payBuyButton.innerHTML = '결제하기';
                        payBuyButton.disabled = false;
                    }
                </script>";
            break;
        case "popup":
            if(!$target) $target = "parent.opener";
            $str .= "<script>\n";
            if ($target) $str .= "if($target)";
            $str .= $target.".location.reload();\n";
            $str .= "parent.wclose();\n";
            $str .= "</script>";
            break;
        case "modal":
            $str .= "<script>top.closeModal();</script>";
            break;
        case "close":
            $str .= "<script>window.close();</script>";
            break;
        case "back":
            $str .= "<script>history.back(-1);</script>";
            break;
        case "code":
            $str .= "<script>".$target."</script>";
            break;
        case "top":
            $str .= "<script>top.location.href='{$url}';</script>";
            break;
        case "reload":
            if($target) $target .= ".";
            $str .= "<script>".$target."location.reload();document.location.href='about:blank';</script>";
            break;
        default :
            $str .= makeLocation($target, $url, $replace, $msg);
    }

    if(isset($param['layer']) && is_array($param['layer'])) {
        echo '<script type="text/javascript">';
        foreach($param['layer'] as $layer) {
            echo 'parent.layTgl(parent.document.getElementById(\''.$layer.'\'));';
        }
        echo '</script>';
    }

    if(isset($param['close'])) {
        if($param['close']=="Y") {
            $str .= "<script>window.close();</script>";
        }
    }

    if(isset($str))	echo $str;

    if(!empty($param["custom_code"])){
        echo '<script type="text/javascript">';
        echo $param["custom_code"];
        echo '</script>';
    }

    exit;
}

function makeLocation($target, $url, $replace=3, $msg="") {
    // 익스패치에 따라 타겟없을 경우 header
    if(!$target && !$msg) { // 메세지가 있을 경우 header 에러라...
        if (!headers_sent() && $url!='about:blank') {
            header('Location: '.$url);
        }else{
            $str = '<meta http-equiv="refresh" content=\0; url='.$url.'">';
        }
    }else{
        $str = '<script type="text/javascript">';

        if($target)	$str .= $target.'.';
        $str .= 'location.';

        if($replace=='3')	$str .= 'replace("'.$url.'");';
        else				$str .= 'href="'.$url.'";';

        $str .= '</script>';
    }

    return $str;
}
