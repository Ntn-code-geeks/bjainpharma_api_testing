<?PHP

  function array_url_encode($arr) {
        foreach ($arr as &$v) {
            if (!is_array($v))
            $v = urlencode($v);
        }
        return $arr;
    }

    function array_url_decode($arr) {
        foreach ($arr as &$v) {
            if (!is_array($v))
            $v = urldecode($v);
        }
        return $arr;
    }

    function encode($arg){
        return base64_encode($arg);
    }

    function urisafeencode($data){
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    function urisafedecode($data){
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    function decode($arg) {
        return base64_decode($arg);
    }

?>