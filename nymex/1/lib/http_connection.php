<?php

function getPageWithProxy($url,$use_proxy){

    $db    = new Database();

    $proxy = '';
    $proxyType = '';
    $usernamepassword = '';
    $isDetetable = '';
    if($use_proxy == "false"){
        $proxy = '';
        $proxyType = '';
        $usernamepassword = '';
        $isDetetable = '';
    }else{
        $qry = "SELECT * FROM `application_proxies` ORDER BY RAND() LIMIT 1";
        $tab = $db->select($qry);
        if(!empty($tab[0])){
            if(!empty($tab[0]['Ip_Address'])){
                $proxy = trim($tab[0]['Ip_Address']);
            }
            if(!empty($tab[0]['typeIP'])){
                $proxyType = trim($tab[0]['typeIP']);
            }
            if(!empty($tab[0]['usernamepassword'])){
                $usernamepassword = trim($tab[0]['usernamepassword']);
            }
            if(!empty($tab[0]['isDetetable'])){
                $isDetetable = trim($tab[0]['isDetetable']);
            }
        }
    }

    $str = get($url, $proxy, $usernamepassword, $closeSession = "false", $proxyType);

    $h = 0;
    while($h < 10  and strlen($str) < 100000){

//            echo '<span style="color: red">'.$url.' >> failed '.($h+1).' >> $proxy = '.$proxy.' >> str = '.$str.' >> $proxyType = '.$proxyType.'</span><br>';

        if($use_proxy == "false"){
            $proxy = '';
            $proxyType = '';
            $usernamepassword = '';
            $isDetetable = '';
        }else{
            sleep(3);
            $qry = "SELECT * FROM `application_proxies` ORDER BY RAND() LIMIT 1";
            $tab = $db->select($qry);
            if(!empty($tab[0])){
                if(!empty($tab[0]['Ip_Address'])){
                    $proxy = trim($tab[0]['Ip_Address']);
                }
                if(!empty($tab[0]['typeIP'])){
                    $proxyType = trim($tab[0]['typeIP']);
                }
                if(!empty($tab[0]['usernamepassword'])){
                    $usernamepassword = trim($tab[0]['usernamepassword']);
                }
                if(!empty($tab[0]['usernamepassword'])){
                    $usernamepassword = trim($tab[0]['usernamepassword']);
                }
                if(!empty($tab[0]['isDetetable'])){
                    $isDetetable = trim($tab[0]['isDetetable']);
                }
            }

            if($isDetetable == "yes"){
                $qry = "DELETE FROM `application_proxies` WHERE `Ip_Address` = '".$proxy."'";
                $db->select($qry);
            }

        }

        $str = get( $url, $proxy, $usernamepassword, $closeSession = "false", $proxyType );

        $h++;

    }

    return $str;

}

function postPageWithProxy($url,$param,$use_proxy){

    $db    = new Database();

    $proxy = '';
    $proxyType = '';
    $usernamepassword = '';
    $isDetetable = '';
    if($use_proxy == "false"){
        $proxy = '';
        $proxyType = '';
        $usernamepassword = '';
        $isDetetable = '';
    }else{
        $qry = "SELECT * FROM `application_proxies` ORDER BY RAND() LIMIT 1";
        $tab = $db->select($qry);
        if(!empty($tab[0])){
            if(!empty($tab[0]['Ip_Address'])){
                $proxy = trim($tab[0]['Ip_Address']);
            }
            if(!empty($tab[0]['typeIP'])){
                $proxyType = trim($tab[0]['typeIP']);
            }
            if(!empty($tab[0]['usernamepassword'])){
                $usernamepassword = trim($tab[0]['usernamepassword']);
            }
            if(!empty($tab[0]['isDetetable'])){
                $isDetetable = trim($tab[0]['isDetetable']);
            }
        }
    }

    $str = post($url,$param, $proxy, $usernamepassword, $closeSession = "false", $proxyType);

    $h = 0;
    while($h < 10  and strlen($str) < 100000){

//            echo '<span style="color: red">'.$url.' >> failed '.($h+1).' >> $proxy = '.$proxy.' >> str = '.$str.' >> $proxyType = '.$proxyType.'</span><br>';

        if($use_proxy == "false"){
            $proxy = '';
            $proxyType = '';
            $usernamepassword = '';
            $isDetetable = '';
        }else{
            sleep(3);
            $qry = "SELECT * FROM `application_proxies` ORDER BY RAND() LIMIT 1";
            $tab = $db->select($qry);
            if(!empty($tab[0])){
                if(!empty($tab[0]['Ip_Address'])){
                    $proxy = trim($tab[0]['Ip_Address']);
                }
                if(!empty($tab[0]['typeIP'])){
                    $proxyType = trim($tab[0]['typeIP']);
                }
                if(!empty($tab[0]['usernamepassword'])){
                    $usernamepassword = trim($tab[0]['usernamepassword']);
                }
                if(!empty($tab[0]['usernamepassword'])){
                    $usernamepassword = trim($tab[0]['usernamepassword']);
                }
                if(!empty($tab[0]['isDetetable'])){
                    $isDetetable = trim($tab[0]['isDetetable']);
                }
            }

            if($isDetetable == "yes"){
                $qry = "DELETE FROM `application_proxies` WHERE `Ip_Address` = '".$proxy."'";
                $db->select($qry);
            }

        }

        $str = post($url,$param, $proxy, $usernamepassword, $closeSession = "false", $proxyType);

        $h++;

    }

    return $str;

}

?>