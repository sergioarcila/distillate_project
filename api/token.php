<?php 
session_start();

// fight against session timeout - ask user to login using HTTP Basic authentication
if($_SESSION['uid']==0)
{
	// ask authorization again
  header('HTTP/1.0 401 Unauthorized', true, 401);
  echo 'Wrong username or password';
	die;
}
if($_SESSION['uid'] == 1) header('X-ADMIN: 1');

?>