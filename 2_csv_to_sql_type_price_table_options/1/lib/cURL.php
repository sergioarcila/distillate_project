<?php

include "randomUserAgent.php";

function setopt( $url, $proxy, $proxypwd, $handle, $proxyType){

	$cookiejar = "cookies.txt";

	$useragent = random_user_agent();

	curl_setopt( $handle, CURLOPT_URL, $url );
	curl_setopt( $handle, CURLOPT_HEADER, 0 );

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
	//    curl_setopt( $handle, CURLOPT_COOKIEFILE, $cookiejar );
	curl_setopt($handle, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
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

function get( $url, $proxy, $proxypwd, $closeSession = "true" , $proxyType){

	$handle = curl_init();

	setopt( $url, $proxy,$proxypwd, $handle, $proxyType);

	$data   = curl_exec($handle);
	if($data == false){

		?>

		<table style="border-collapse: collapse;">
			<thead>
				<tr>
					<th style="background: #ff4a46; border: 1px solid #ff4a46; padding: 10px;text-align: left;">url</th>
					<th style="background: #ff4a46; border: 1px solid #ff4a46; padding: 10px;text-align: left;">strln</th>
					<th style="background: #ff4a46; border: 1px solid #ff4a46; padding: 10px;text-align: left;">proxy</th>
					<th style="background: #ff4a46; border: 1px solid #ff4a46; padding: 10px;text-align: left;">proxypwd</th>
					<th style="background: #ff4a46; border: 1px solid #ff4a46; padding: 10px;text-align: left;">proxyType</th>
					<th style="background: #ff4a46; border: 1px solid #ff4a46; padding: 10px;text-align: left;">code status</th>
					<th style="background: #ff4a46; border: 1px solid #ff4a46; padding: 10px;text-align: left;">erreur Curl</th>
				</tr>
			</thead>
			<tbody>
				<td style="border: 1px solid #ff4a46; padding: 10px;text-align: left;"><a href="<?php echo $url; ?>"><?php echo $url; ?></a></td>
				<td style="border: 1px solid #ff4a46; padding: 10px;text-align: left;"><a href="<?php echo $url; ?>"><?php echo strlen($data); ?></a></td>
				<td style="border: 1px solid #ff4a46; padding: 10px;text-align: left;"><?php echo $proxy; ?></td>
				<td style="border: 1px solid #ff4a46; padding: 10px;text-align: left;"><?php echo $proxypwd; ?></td>
				<td style="border: 1px solid #ff4a46; padding: 10px;text-align: left;"><?php echo $proxyType; ?></td>
				<td style="border: 1px solid #ff4a46; padding: 10px;text-align: left;"></td>
				<td style="border: 1px solid #ff4a46; padding: 10px;text-align: left;"><?php echo curl_error($handle); ?></td>
			</tbody>
		</table>

		<?php

		return 'false';

	} else{ 

		?>
		<table style="border-collapse: collapse;">
			<thead>
				<tr>
					<th style="background: #52ff2e; border: 1px solid #52ff70; padding: 10px;text-align: left;">url</th>
					<th style="background: #52ff2e; border: 1px solid #52ff70; padding: 10px;text-align: left;">strln</th>
					<th style="background: #52ff2e; border: 1px solid #52ff70; padding: 10px;text-align: left;">proxy</th>
					<th style="background: #52ff2e; border: 1px solid #52ff70; padding: 10px;text-align: left;">proxypwd</th>
					<th style="background: #52ff2e; border: 1px solid #52ff70; padding: 10px;text-align: left;">proxyType</th>
					<th style="background: #52ff2e; border: 1px solid #52ff70; padding: 10px;text-align: left;">code status</th>
					<th style="background: #52ff2e; border: 1px solid #52ff70; padding: 10px;text-align: left;">erreur Curl</th>
				</tr>
			</thead>
			<tbody>
				<td style="border: 1px solid #52ff70; padding: 10px;text-align: left;"><a href="<?php echo $url; ?>"><?php echo $url; ?></a></td>
				<td style="border: 1px solid #52ff70; padding: 10px;text-align: left;"><a href="<?php echo $url; ?>"><?php echo strlen($data); ?></a></td>
				<td style="border: 1px solid #52ff70; padding: 10px;text-align: left;"><?php echo $proxy; ?></td>
				<td style="border: 1px solid #52ff70; padding: 10px;text-align: left;"><?php echo $proxypwd; ?></td>
				<td style="border: 1px solid #52ff70; padding: 10px;text-align: left;"><?php echo $proxyType; ?></td>
				<td style="border: 1px solid #52ff70; padding: 10px;text-align: left;">200</td>
				<td style="border: 1px solid #52ff70; padding: 10px;text-align: left;"><?php echo curl_error($handle); ?></td>
			</tbody>
		</table>

		<?php 
	
	}

	$code = curl_getinfo( $handle, CURLINFO_HTTP_CODE );
	$info = curl_getinfo( $handle );
	$url  = ( isset( $info['redirect_url'] ) && !empty( $info['redirect_url'] ) != '' ? $info['redirect_url'] : $info['url'] );

  
	?>

	
	<?php
	if($closeSession == true){
		curl_close( $handle );
	}

	return ($info['http_code'] != 200) ? 'false' : $data;
}

?>