<?php
// Get our helper functions 
require_once("inc/functions.php");
require_once("conn/conn.php");

// Set variables for our request
$api_key = "9928d10dd203c917dc4fa7eb4299f8b9";
$shared_secret = "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";
$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

	$requests = $_GET;
	$serializeArray = serialize($requests);
	$requests = array_diff_key($requests, array( 'hmac' => '' ));
	ksort($requests);
	
	$url = parse_url('https://' . $requests['shop']);
	$host = explode('.', $url['host']);
	$shop = $host[0];
	$shop_url = $params['shop'];
	$storeswitcherenable = 0;
	$autostoreswitcherenable = 0;

$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically

$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

// Use hmac data to check that the response is from Shopify or not
if (hash_equals($hmac, $computed_hmac)) {

	// Set variables for our request
	$query = array(
		"client_id" => $api_key, // Your API key
		"client_secret" => $shared_secret, // Your app credentials (secret key)
		"code" => $params['code'] // Grab the access key from the URL
	);

	// Generate access token URL
	$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

	// Configure curl client and execute request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $access_token_url);
	curl_setopt($ch, CURLOPT_POST, count($query));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
	$result = curl_exec($ch);
	curl_close($ch);

	// Store the access token
	$result = json_decode($result, true);
	$access_token = $result['access_token'];

	// Show the access token (don't do this in production!)

	$sql = "INSERT INTO store_switcher_info (webdomin, webname, storeswitcherenable, autostoreswitcherenable, webtoken) VALUES ('$shop_url', '$shop', '$storeswitcherenable', '$autostoreswitcherenable', '$access_token')";

  	if (mysqli_query($conn, $sql)) {
	  header('location: index.php');
	} else {
	  echo "No record Inserted";
	}

} else {
	// Someone is trying to be shady!
	die('This request is NOT from Shopify!');
}