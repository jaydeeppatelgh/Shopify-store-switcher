<!DOCTYPE html>
<html>
<head> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body class="body">
	<button class="storeswitcherenable">Store Switcher Enable</button>
	<button class="storeswitcherdisable">Store Switcher Disable</button> <br><br>
	<button class="autostoreswitcherenable">Auto Redirect Enable</button>
	<button class="autostoreswitcherdisable">Auto Redirect Disable</button> <br><br>

<script type="text/javascript">
	jQuery(document).ready(function(){

		jQuery(".storeswitcherenable").click(function(){
			var myValue = 1;

			$.ajax({

				//url : 'index.php',
				type : 'GET',
				data : {storeswitcherenable: myValue },
				//dataType:'json',
				success : function(data) {
					alert('Data: ' + storeswitcherenable);
						
				}
			});
		});

		jQuery(".storeswitcherdisable").click(function(){
			var myValue = 0;

			$.ajax({

				//url : 'index.php',
				type : 'GET',
				data : {storeswitcherdisable: myValue },
				//dataType:'json',
				success : function(data) {
					alert('Data: ' + storeswitcherdisable);
						
				}
			});
		});

		jQuery(".autostoreswitcherenable").click(function(){
			var myValue = 1;

			$.ajax({

				//url : 'index.php',
				type : 'GET',
				data : {autostoreswitcherenable: myValue },
				//dataType:'json',
				success : function(data) {
					alert('Data: ' + autostoreswitcherenable);
						
				}
			});
		});

		jQuery(".autostoreswitcherdisable").click(function(){
			var myValue = 0;

			$.ajax({

				//url : 'index.php',
				type : 'GET',
				data : {autostoreswitcherdisable: myValue },
				//dataType:'json',
				success : function(data) {
					alert('Data: ' + autostoreswitcherdisable);
						
				}
			});
		});
	});
</script>
</body>
</html>

<?php
		require_once("conn/conn.php");
		require_once("inc/functions.php");

	$params = $_GET;
	$requests = $_GET;
	$hmac = $_GET['hmac'];
	$serializeArray = serialize($requests);
	$requests = array_diff_key($requests, array( 'hmac' => '' ));
	ksort($requests);

	$url = parse_url('https://' . $requests['shop']);
	$host = explode('.', $url['host']);
	$shop = $host[0];

	$store_url = $params['shop'];
	echo $store_url;

	//Enable StoreSwitcher //
	if(isset($_GET['storeswitcherenable'])) {
		$storeswitcherenable = $_GET['storeswitcherenable'];
		echo $storeswitcherenable;
		$updateSwitcher = "UPDATE store_switcher_info SET storeswitcherenable = '$storeswitcherenable' where webname = '$shop'";
		$result = mysqli_query($conn, $updateSwitcher);
	}

	// Disable StoreSwitcher //
	if(isset($_GET['storeswitcherdisable'])) {
		$storeswitcherenable = $_GET['storeswitcherdisable'];
		echo $storeswitcherenable;
		$updateSwitcher = "UPDATE store_switcher_info SET storeswitcherenable = '$storeswitcherenable' where webname = '$shop'";
		$result = mysqli_query($conn, $updateSwitcher);
	}

	//Enable AutoStoreSwitcher //
	if(isset($_GET['autostoreswitcherenable'])) {
		$autostoreswitcherenable = $_GET['autostoreswitcherenable'];
		echo $autostoreswitcherenable;
		$updateSwitcher = "UPDATE store_switcher_info SET autostoreswitcherenable = '$autostoreswitcherenable' where webname = '$shop'";
		$result = mysqli_query($conn, $updateSwitcher);
	}

	// Disable AutoStoreSwitcher //
	if(isset($_GET['autostoreswitcherdisable'])) {
		$autostoreswitcherenable = $_GET['autostoreswitcherdisable'];
		echo $autostoreswitcherenable;
		$updateSwitcher = "UPDATE store_switcher_info SET autostoreswitcherenable = '$autostoreswitcherenable' where webname = '$shop'";
		$result = mysqli_query($conn, $updateSwitcher);
	}

	$switcher = "SELECT storeswitcherenable, autostoreswitcherenable, webtoken FROM store_switcher_info where webname = '$shop'";
	$result = mysqli_query($conn, $switcher);
 
		while($row = mysqli_fetch_array($result)) {
			$storeswitcherenable = $row['storeswitcherenable'];
			$autostoreswitcherenable = $row['autostoreswitcherenable'];
			$token = $row['webtoken'];
		}

// Add StoreSwitcher Code //	
if($storeswitcherenable == 1)
{
$theme = shopify_call($token, $shop, "/admin/api/2021-07/themes.json", array(), 'GET');
$theme = json_decode($theme['response'], JSON_PRETTY_PRINT);

	foreach ($theme as $cur_theme) {
		foreach ($cur_theme as $key => $value) {
			if ($value['role'] == 'main') {
				$theme_id = $value['id'];
				
				$asset_file = array(
				'asset' => array(
						'key' => 'sections/storeswitcher.liquid',
						'value' => '<div id="ac-wrapper" style="display: none;">
							    <div class="form-popup">								      
							      <h1>{{ ipwhois.country }}</h1>								    
							      <input type="submit" name="submit" value="Yes" onClick="PopUp()" />
							      <input type="submit" name="submit" value="No" onClick="closeForm()" />
							    </div>
							  </div>
							  <script>function PopUp(){var s="",t=request_ipwhois(s);if("France"===t.country){var i=window.location.href,r="https://'.$shop.'.myshopify.com/fr";-1!=i.indexOf(r)?($("#currencies").val("CH"),$("#currencies").change()):($("#currencies .disclosure-list .disclosure-list__option").each(function(){"CH"==$(this).attr("data-value")&&($("#country-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#country-list").removeClass("disclosure-list--visible"),$("#CountrySelector").val("CH"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#currencies-dev-button").html("Zwitserland (CHF CHF)"))}),$("#languages-custom .disclosure-list .disclosure-list__option").each(function(){"fr"==$(this).attr("data-value")&&($("#lang-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#lang-list").removeClass("disclosure-list--visible"),$("#LocaleSelector").val("fr"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#languages-dev-button").html("français"))}),$("form#localization_form").submit())}if("Spain"===t.country){var e=window.location.href,l="https://'.$shop.'.myshopify.com/es";-1!=e.indexOf(l)?($("#currencies").val("ES"),$("#currencies").change()):($("#currencies .disclosure-list .disclosure-list__option").each(function(){"ES"==$(this).attr("data-value")&&($("#country-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#country-list").removeClass("disclosure-list--visible"),$("#CountrySelector").val("ES"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#currencies-dev-button").html("Spain (EUR €)"))}),$("#languages-custom .disclosure-list .disclosure-list__option").each(function(){"es"==$(this).attr("data-value")&&($("#lang-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#lang-list").removeClass("disclosure-list--visible"),$("#LocaleSelector").val("es"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#languages-dev-button").html("Español"))}),$("form#localization_form").submit())}if("Germany"===t.country){var c=window.location.href,o="https://'.$shop.'.myshopify.com/de";-1!=c.indexOf(o)?($("#currencies").val("DE"),$("#currencies").change()):($("#currencies .disclosure-list .disclosure-list__option").each(function(){"DE"==$(this).attr("data-value")&&($("#country-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#country-list").removeClass("disclosure-list--visible"),$("#CountrySelector").val("DE"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#currencies-dev-button").html("Espagne (EUR €)"))}),$("#languages-custom .disclosure-list .disclosure-list__option").each(function(){"de"==$(this).attr("data-value")&&($("#lang-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#lang-list").removeClass("disclosure-list--visible"),$("#LocaleSelector").val("de"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#languages-dev-button").html("Deutsch"))}),$("form#localization_form").submit())}if("Netherlands"===t.country){var a=window.location.href,n="https://'.$shop.'.myshopify.com/nl";-1!=a.indexOf(n)?($("#currencies").val("NL"),$("#currencies").change()):($("#currencies .disclosure-list .disclosure-list__option").each(function(){"NL"==$(this).attr("data-value")&&($("#country-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#country-list").removeClass("disclosure-list--visible"),$("#CountrySelector").val("NL"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#currencies-dev-button").html("Netherlands (EUR €)"))}),$("#languages-custom .disclosure-list .disclosure-list__option").each(function(){"nl"==$(this).attr("data-value")&&($("#lang-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#lang-list").removeClass("disclosure-list--visible"),$("#LocaleSelector").val("nl"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#languages-dev-button").html("Nederlands"))}),$("form#localization_form").submit())}if("Romania"===t.country){var c=window.location.href,o="https://'.$shop.'.myshopify.com/ro";-1!=c.indexOf(o)?($("#currencies").val("GB"),$("#currencies").change()):($("#currencies .disclosure-list .disclosure-list__option").each(function(){"GB"==$(this).attr("data-value")&&($("#country-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#country-list").removeClass("disclosure-list--visible"),$("#CountrySelector").val("GB"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#currencies-dev-button").html("United Kingdom (GBP £)"))}),$("#languages-custom .disclosure-list .disclosure-list__option").each(function(){"ro"==$(this).attr("data-value")&&($("#lang-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#lang-list").removeClass("disclosure-list--visible"),$("#LocaleSelector").val("ro"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#languages-dev-button").html("română"))}),$("form#localization_form").submit())}}function closeForm(){document.getElementById("ac-wrapper").style.display="none"}jQuery(document).ready(function(s){var t="",i=request_ipwhois(t);if("France"===i.country){var r=window.location.href,e="https://'.$shop.'.myshopify.com/fr";-1!=r.indexOf(e)?(s("#currencies").val("FR"),s("#currencies").change()):s("#ac-wrapper").show()}if("Spain"===i.country){var l=window.location.href,c="https://'.$shop.'.myshopify.com/es";-1!=l.indexOf(c)?(s("#currencies").val("ES"),s("#currencies").change()):s("#ac-wrapper").show()}if("Germany"===i.country){var o=window.location.href,a="https://'.$shop.'.myshopify.com/de";-1!=o.indexOf(a)?(s("#currencies").val("DE"),s("#currencies").change()):s("#ac-wrapper").show()}if("Netherlands"===i.country){var n=window.location.href,u="https://'.$shop.'.myshopify.com/nl";-1!=n.indexOf(u)?(s("#currencies").val("NL"),s("#currencies").change()):s("#ac-wrapper").show()}if("Romania"===i.country){var n=window.location.href,u="https://'.$shop.'.myshopify.com/ro";-1!=n.indexOf(u)?(s("#currencies").val("RO"),s("#currencies").change()):s("#ac-wrapper").show()}});</script>
							{% style %}
							#ac-wrapper {
							position: fixed;
							top: 0;
							left: 0;
							width: 100%;
							height: 100%;
							background: rgba(255,255,255,.6);
							z-index: 1001;
						}

						.form-popup {
							width: 555px;
							height: 375px;
							background: #FFFFFF;
							border: 5px solid #000;
							border-radius: 25px;
							-moz-border-radius: 25px;
							-webkit-border-radius: 25px;
							box-shadow: #64686e 0px 0px 3px 3px;
							-moz-box-shadow: #64686e 0px 0px 3px 3px;
							-webkit-box-shadow: #64686e 0px 0px 3px 3px;
							position: relative;
							top: 150px; left: 375px;
						}
						{% endstyle %}'
					)
				);

				$assets = shopify_call($token, $shop, "/admin/api/2021-07/themes/" . $theme_id . "/assets.json", $asset_file, 'PUT');
				$assets = json_decode($assets['response'], JSON_PRETTY_PRINT);

				$array = array('asset' => array('key' => 'layout/theme.liquid'));
				$assets = shopify_call($token, $shop, "/admin/api/2021-07/themes/" . $theme_id . "/assets.json", $array, 'GET');
				$assets = json_decode($assets['response'], JSON_PRETTY_PRINT);

				$addcode = "{% section 'storeswitcher' %}";
				$body_tag = '</body>';
				$new_body_tag = $addcode . $body_tag;
				$theme_liquid = $assets['asset']['value'];

				$new_theme_liquid = str_replace($body_tag, $new_body_tag, $theme_liquid);

				if( strpos($assets['asset']['value'], $addcode) === false ) {

					$array = array(
						'asset' => array(
							'key' => "layout/theme.liquid",
							'value' => $new_theme_liquid
						)
					);

					$assets = shopify_call($token, $shop, "/admin/api/2021-07/themes/" . $theme_id . "/assets.json", $array, 'PUT');
					$assets = json_decode($assets['response'], JSON_PRETTY_PRINT);
				}

				$addtag='<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
				  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
				  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
				  <script src="https://cdn.ipwhois.io/js/ipwhois.js"></script>';
				$head_tag = '</head>';
				$new_head_tag = $addtag . $head_tag;
				$themes_liquid = $assets['asset']['value'];

				$new_themes_liquid = str_replace($head_tag, $new_head_tag, $themes_liquid);

				if( strpos($assets['asset']['value'], $addtag) === false ) {

					$array = array(
						'asset' => array(
							'key' => "layout/theme.liquid",
							'value' => $new_themes_liquid
						)
					);

					$assets = shopify_call($token, $shop, "/admin/api/2021-07/themes/" . $theme_id . "/assets.json", $array, 'PUT');
					$assets = json_decode($assets['response'], JSON_PRETTY_PRINT);
				}
			}
		}
	}
}

// Remove StoreSwitcher Code //
if($storeswitcherenable == 0)
{
$theme = shopify_call($token, $shop, "/admin/api/2021-07/themes.json", array(), 'GET');
$theme = json_decode($theme['response'], JSON_PRETTY_PRINT);

	foreach ($theme as $cur_theme) {
		foreach ($cur_theme as $key => $value) {
			if ($value['role'] == 'main') {
				$theme_id = $value['id'];

				$asset_remove = array(
				'asset' => array(
						'key' => 'sections/storeswitcher.liquid',
						'value' => '{% comment %}
							Store Switcher Disable!
						{% endcomment %}'
					)
				);

				$assets = shopify_call($token, $shop, "/admin/api/2021-07/themes/" . $theme_id . "/assets.json", $asset_remove, 'PUT');
				$assets = json_decode($assets['response'], JSON_PRETTY_PRINT);
			}
		}
	}
}

// Add Auto StoreSwitcher Code //
if($storeswitcherenable && $autostoreswitcherenable == 1)
{
$theme = shopify_call($token, $shop, "/admin/api/2021-07/themes.json", array(), 'GET');
$theme = json_decode($theme['response'], JSON_PRETTY_PRINT);

	foreach ($theme as $cur_theme) {
		foreach ($cur_theme as $key => $value) {
			if ($value['role'] == 'main') {
				$theme_id = $value['id'];

				$asset_file = array(
				'asset' => array(
						'key' => 'sections/storeswitcher.liquid',
						'value' => '<script>var ipaddress="",ipwhois=request_ipwhois(ipaddress);if("France"===ipwhois.country){var frstr1=window.location.href,frstr2="https://'.$shop.'.myshopify.com/fr";-1!=frstr1.indexOf(frstr2)?($("#currencies").val("CH"),$("#currencies").change()):($("#currencies .disclosure-list .disclosure-list__option").each(function(){"CH"==$(this).attr("data-value")&&($("#country-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#country-list").removeClass("disclosure-list--visible"),$("#CountrySelector").val("CH"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#currencies-dev-button").html("Zwitserland (CHF CHF)"))}),$("#languages-custom .disclosure-list .disclosure-list__option").each(function(){"fr"==$(this).attr("data-value")&&($("#lang-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#lang-list").removeClass("disclosure-list--visible"),$("#LocaleSelector").val("fr"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#languages-dev-button").html("français"))}),$("form#localization_form").submit())}if("Spain"===ipwhois.country){var esstr1=window.location.href,esstr2="https://'.$shop.'.myshopify.com/es";-1!=esstr1.indexOf(esstr2)?($("#currencies").val("ES"),$("#currencies").change()):($("#currencies .disclosure-list .disclosure-list__option").each(function(){"ES"==$(this).attr("data-value")&&($("#country-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#country-list").removeClass("disclosure-list--visible"),$("#CountrySelector").val("ES"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#currencies-dev-button").html("Spain (EUR €)"))}),$("#languages-custom .disclosure-list .disclosure-list__option").each(function(){"es"==$(this).attr("data-value")&&($("#lang-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#lang-list").removeClass("disclosure-list--visible"),$("#LocaleSelector").val("es"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#languages-dev-button").html("Español"))}),$("form#localization_form").submit())}if("Germany"===ipwhois.country){var destr2="https://'.$shop.'.myshopify.com/de";-1!=(destr1=window.location.href).indexOf(destr2)?($("#currencies").val("DE"),$("#currencies").change()):($("#currencies .disclosure-list .disclosure-list__option").each(function(){"DE"==$(this).attr("data-value")&&($("#country-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#country-list").removeClass("disclosure-list--visible"),$("#CountrySelector").val("DE"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#currencies-dev-button").html("Espagne (EUR €)"))}),$("#languages-custom .disclosure-list .disclosure-list__option").each(function(){"de"==$(this).attr("data-value")&&($("#lang-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#lang-list").removeClass("disclosure-list--visible"),$("#LocaleSelector").val("de"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#languages-dev-button").html("Deutsch"))}),$("form#localization_form").submit())}if("Netherlands"===ipwhois.country){var nlstr1=window.location.href,nlstr2="https://'.$shop.'.myshopify.com/nl";-1!=nlstr1.indexOf(nlstr2)?($("#currencies").val("NL"),$("#currencies").change()):($("#currencies .disclosure-list .disclosure-list__option").each(function(){"NL"==$(this).attr("data-value")&&($("#country-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#country-list").removeClass("disclosure-list--visible"),$("#CountrySelector").val("NL"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#currencies-dev-button").html("Netherlands (EUR €)"))}),$("#languages-custom .disclosure-list .disclosure-list__option").each(function(){"nl"==$(this).attr("data-value")&&($("#lang-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#lang-list").removeClass("disclosure-list--visible"),$("#LocaleSelector").val("nl"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#languages-dev-button").html("Nederlands"))}),$("form#localization_form").submit())}if("Romania"===ipwhois.country){var destr1;destr2="https://'.$shop.'.myshopify.com/ro";-1!=(destr1=window.location.href).indexOf(destr2)?($("#currencies").val("GB"),$("#currencies").change()):($("#currencies .disclosure-list .disclosure-list__option").each(function(){"GB"==$(this).attr("data-value")&&($("#country-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#country-list").removeClass("disclosure-list--visible"),$("#CountrySelector").val("GB"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#currencies-dev-button").html("United Kingdom (GBP £)"))}),$("#languages-custom .disclosure-list .disclosure-list__option").each(function(){"ro"==$(this).attr("data-value")&&($("#lang-list").addClass("disclosure-list--visible"),$(this).parent().trigger("click"),$("#lang-list").removeClass("disclosure-list--visible"),$("#LocaleSelector").val("ro"),$(".disclosure-list__item").removeClass("disclosure-list__item--current"),$(this).parent().addClass("disclosure-list__item--current"),$("#country-list .disclosure-list__option").removeAttr("aria-current"),$(this).attr("aria-current","true"),$("#languages-dev-button").html("română"))}),$("form#localization_form").submit())}</script>'
					)
				);

				$assets = shopify_call($token, $shop, "/admin/api/2021-07/themes/" . $theme_id . "/assets.json", $asset_file, 'PUT');
				$assets = json_decode($assets['response'], JSON_PRETTY_PRINT);

				$array = array('asset' => array('key' => 'layout/theme.liquid'));
				$assets = shopify_call($token, $shop, "/admin/api/2021-07/themes/" . $theme_id . "/assets.json", $array, 'GET');
				$assets = json_decode($assets['response'], JSON_PRETTY_PRINT);

				$addcode = "{% section 'storeswitcher' %}";
				$body_tag = '</body>';
				$new_body_tag = $addcode . $body_tag;
				$theme_liquid = $assets['asset']['value'];

				$new_theme_liquid = str_replace($body_tag, $new_body_tag, $theme_liquid);

				if( strpos($assets['asset']['value'], $addcode) === false ) {

					$array = array(
						'asset' => array(
							'key' => "layout/theme.liquid",
							'value' => $new_theme_liquid
						)
					);

					$assets = shopify_call($token, $shop, "/admin/api/2021-07/themes/" . $theme_id . "/assets.json", $array, 'PUT');
					$assets = json_decode($assets['response'], JSON_PRETTY_PRINT);
				}
			}
		}
	}
}
?>