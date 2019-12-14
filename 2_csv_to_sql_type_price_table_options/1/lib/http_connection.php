<?php

function getPageWithProxy($url, $strlen, $use_proxy){

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

        $qry = "SELECT * FROM `application_proxies_redfin` WHERE `status` = 'finished' ORDER BY RAND() LIMIT 1";
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

        $qry = "UPDATE `application_proxies_redfin` SET `status`='working' WHERE `Ip_Address` = '".$proxy."'";
        $db->select($qry);

    }

    $str = get($url, $proxy, $usernamepassword, $closeSession = "true", $proxyType);
    sleep(rand(10,30));

    $qry = "UPDATE `application_proxies_redfin` SET `status`='finished' WHERE `Ip_Address` = '".$proxy."'";
    $db->select($qry);

    $h = 0;
    while($h < 10  and strlen($str) < $strlen){

//            echo '<span style="color: red">'.$url.' >> failed '.($h+1).' >> $proxy = '.$proxy.' >> str = '.$str.' >> $proxyType = '.$proxyType.'</span><br>';

        if($use_proxy == "false"){
            $proxy = '';
            $proxyType = '';
            $usernamepassword = '';
            $isDetetable = '';
        }else{

            $qry = "SELECT * FROM `application_proxies_redfin` WHERE `status` = 'finished' ORDER BY RAND() LIMIT 1";
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

            $qry = "UPDATE `application_proxies_redfin` SET `status`='working' WHERE `Ip_Address` = '".$proxy."'";
            $db->select($qry);

            if($isDetetable == "yes"){
                $qry = "DELETE FROM `application_proxies_redfin` WHERE `Ip_Address` = '".$proxy."'";
                $db->select($qry);
            }

        }

        $str = get( $url, $proxy, $usernamepassword, $closeSession = "true", $proxyType );
        sleep(rand(10,30));

        $qry = "UPDATE `application_proxies_redfin` SET `status`='finished' WHERE `Ip_Address` = '".$proxy."'";
        $db->select($qry);

        $h++;

    }

    return $str;

}

?>