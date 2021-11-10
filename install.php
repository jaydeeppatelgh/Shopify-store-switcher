<?php
// Set variables for our request
$shop = $_GET['shop'];
$replase = ".myshopify.com";
$shop = str_replace($replase, '', $shop) ;
$api_key = "9928d10dd203c917dc4fa7eb4299f8b9";
$scopes = "read_orders,write_products,read_themes,write_themes";
$redirect_uri = "https://ecommercehotels.net/shopifyapp/StoreSwitcher/generate_token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();