<?php

include "randomUserAgent.php";

function setopt( $url, $proxy, $proxypwd, $handle, $proxyType){

    $cookiejar = __DIR__."/../lib/cookies.txt";

    $useragent = random_user_agent();

    curl_setopt( $handle, CURLOPT_URL, $url );
    curl_setopt( $handle, CURLOPT_HEADER, 0 );

    $header=array(
        'User-Agent: '.$useragent,
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,/;q=0.8',
        'Keep-Alive: 115',
        'Connection: keep-alive',
    );
    curl_setopt($handle,CURLOPT_HTTPHEADER,$header);

    curl_setopt( $handle, CURLOPT_FOLLOWLOCATION, 1 );
    curl_setopt( $handle, CURLOPT_MAXREDIRS, 5 );

//    curl_setopt($handle, CURLOPT_SSLVERSION, 3);

    curl_setopt( $handle, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $handle, CURLOPT_USERAGENT, $useragent );

    curl_setopt($handle,CURLOPT_CONNECTTIMEOUT,30);
    //curl_setopt($handle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($handle, CURLOPT_TIMEOUT, 30); //timeout in seconds

    curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $handle, CURLOPT_SSL_VERIFYHOST, false );


    curl_setopt( $handle, CURLOPT_COOKIEJAR, $cookiejar );
    curl_setopt( $handle, CURLOPT_COOKIEFILE, $cookiejar );

    if( $proxy != '' ){
        curl_setopt( $handle, CURLOPT_PROXY, $proxy );

        if(preg_match('/socks4/',$proxyType)){
            curl_setopt($handle, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
//            curl_setopt($handle, CURLOPT_HTTPPROXYTUNNEL, 1);
        }elseif(preg_match('/socks5/',$proxyType)){
            curl_setopt($handle, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
//            curl_setopt($handle, CURLOPT_HTTPPROXYTUNNEL, 1);
        }
        if( $proxypwd != '' ){
            curl_setopt( $handle, CURLOPT_PROXYUSERPWD, $proxypwd );
        }
    }
}

function get( $url, $proxy,$proxypwd, $closeSession = "true" , $proxyType){
    $handle = curl_init();

    setopt( $url, $proxy,$proxypwd, $handle, $proxyType);

    $data   = curl_exec($handle);
    if(curl_exec($handle) == false){
        echo 'Erreur Curl : ' . curl_error($handle).' <br> ';
        return 'false';
    }

    $code = curl_getinfo( $handle, CURLINFO_HTTP_CODE );
    $info = curl_getinfo( $handle );

    $url  = ( isset( $info['redirect_url'] ) && !empty( $info['redirect_url'] ) != '' ? $info['redirect_url'] : $info['url'] );

    if($closeSession == true){
        curl_close( $handle );
    }

    return ($info['http_code'] != 200) ? 'false' : $data;
}

function post( $url, $param, $proxy,$proxypwd, $closeSession = "true", $proxyType){

    $handle = curl_init();

    setopt( $url, $proxy,$proxypwd, $handle, $proxyType);

    curl_setopt( $handle, CURLOPT_POST, 1 );
    curl_setopt( $handle, CURLOPT_POSTFIELDS, $param );

    $data   = curl_exec($handle);
    if(curl_exec($handle) === false){
        echo 'Erreur Curl : ' . curl_error($handle).' <br> ';
        return 'false';
    }

    $code = curl_getinfo( $handle, CURLINFO_HTTP_CODE );
    $info = curl_getinfo( $handle );

    $url  = ( isset( $info['redirect_url'] ) && !empty( $info['redirect_url'] ) != '' ? $info['redirect_url'] : $info['url'] );

    if($closeSession == "true"){
        curl_close( $handle );
    }

    return ($info['http_code'] != 200) ? 'false' : $data;
}

function postJson( $url, $param, $proxy,$proxypwd, $closeSession = "true", $proxyType){

    $handle = curl_init();

    setopt( $url, $proxy,$proxypwd, $handle, $proxyType);

    curl_setopt( $handle, CURLOPT_POST, 1 );
    curl_setopt( $handle, CURLOPT_POSTFIELDS, $param );
    curl_setopt( $handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($param)) );

    $data = curl_exec($handle);
    if(curl_exec($handle) === false){
        echo 'Erreur Curl : ' . curl_error($handle).' <br> ';
        return 'false';
    }

    $code = curl_getinfo( $handle, CURLINFO_HTTP_CODE );
    $info = curl_getinfo( $handle );

    $url  = ( isset( $info['redirect_url'] ) && !empty( $info['redirect_url'] ) != '' ? $info['redirect_url'] : $info['url'] );

    if($closeSession == "true"){
        curl_close( $handle );
    }

    return ($info['http_code'] != 200) ? 'false' : $data;
}

function rotateProxyChanger($counter){
    $file = __DIR__."/../resources/proxy.txt";

    $lines= file($file);
    $i    = 0;
    $tab  = array();

    foreach($lines as $line_num => $line){
        $tab[$i] = trim($line);
        $i++;
    }

    $proxy = $tab[$counter];

    return $proxy;
}

function getProxyFileSize(){
    $file = __DIR__."/../resources/proxy.txt";

    $lines= file($file);
    $i    = 0;
    $tab  = array();

    foreach($lines as $line_num => $line){
        $tab[$i] = trim($line);
        $i++;
    }

    return count($tab);
}

function mini_get( $url, $proxy, $proxypwd ){
    $rCURL = curl_init();

    curl_setopt($rCURL, CURLOPT_URL, $url);
    curl_setopt($rCURL, CURLOPT_HEADER, 0);
    curl_setopt($rCURL, CURLOPT_RETURNTRANSFER, 1);

    if( $proxy != '' ){
        curl_setopt( $rCURL, CURLOPT_PROXY, $proxy );
        //curl_setopt($handle, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        //curl_setopt($rCURL, CURLOPT_HTTPPROXYTUNNEL, 1);

        if( $proxypwd != '' ){
            curl_setopt( $rCURL, CURLOPT_PROXYUSERPWD, $proxypwd );
        }
    }
    $str = curl_exec($rCURL);
    if(curl_exec($rCURL) == $str){
        echo 'Erreur Curl : ' . curl_error($rCURL).' <br> ';
        return 'false';
    }

    curl_close($rCURL);

    return $str;
}
?>