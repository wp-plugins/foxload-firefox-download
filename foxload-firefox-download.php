<?php
/*
Plugin Name: Foxload Firefox Download
Plugin URI: http://www.foxload.com/
Description: Offers your blog visitors a <a href="http://www.foxload.com/firefox-download/">firefox download</a> button in different formats and colors on the sidebar. If your theme does not support widgets, call the php function <em>&lt;?php get_foxload_button(); ?&gt;</em>.
Author: Foxload
Version: 0.2.11
Author URI: http://www.foxload.com/
Tags: firefox, download, widget, button, browser, sidebar, mozilla
*/

function get_foxload_button() {
  $options = get_option("widget_myFoxload");
  
  if (!is_array( $options )) {
	  $options = array(
		'title' => '',
		'size' => '110-32',
		'banner' => '110-32-blue'
      );
  }
  
  $locale = get_locale();
  
  if (myFoxload_str_ends_with($_SERVER['SERVER_NAME'], '.de')) {
    $locale = 'de_de';
  } else if (myFoxload_str_ends_with($_SERVER['SERVER_NAME'], '.co.uk')) {
    $locale = 'en_gb';
  }
  
  if (strtolower($locale) == 'de_de' || strtolower($locale) == 'de_ch' || strtolower($locale) == 'de_at')  {
	$foxload_url = 'http://www.foxload.com/firefox-download/';
  } else if (strtolower($locale) == 'fr_fr') {
	$foxload_url = 'http://fr.foxload.com/';
  } else if (strtolower($locale) == 'en_gb') {
	$foxload_url = 'http://www.getfirefox.co.uk/';
  } else {
	$foxload_url = 'http://en.foxload.com/';
  }
  
  echo '<a href="'.$foxload_url.'" title="Mozilla Firefox Download"><img src="http://www.foxload.com/images/wp/firefox-'.$options['banner'].'.png" border="0" style="border:none;" alt="Mozilla Firefox" /></a>';
}

function widget_myFoxload($args) {
  extract($args);

  $options = get_option("widget_myFoxload");
  
  if (!is_array( $options )) {
	  $options = array(
		'title' => '',
		'size' => '110-32',
		'banner' => '110-32-blue'
      );
  }      

  echo $before_widget;
  echo $before_title;
  echo $options['title'];
  echo $after_title;

  if ($options['title'] != '') {
	echo '<div style="background:none; border:none;">&nbsp;</div>';
  }
  
  get_foxload_button();
  
  echo $after_widget;
}

function myFoxload_str_ends_with($haystack, $needle) {
    return strrpos($haystack, $needle) === strlen($haystack)-strlen($needle);
}

function myFoxload_control() {
	myFoxload_configuration();
}

function myFoxload_settings() {
	myFoxload_configuration(TRUE);
}

function myFoxload_configuration($standalone = FALSE) {
  $options = get_option("widget_myFoxload");
  
  if (!is_array( $options )) {
	  $options = array(
		'title' => '',
		'size' => '110-32',
		'banner' => '110-32-blue'
      );
  }    

  if ($_POST['myFoxload-Submit']) {
    $options['title'] = htmlspecialchars($_POST['myFoxload-WidgetTitle']);
	$options['size'] = htmlspecialchars($_POST['myFoxload-Size']);
	$options['banner'] = htmlspecialchars($_POST['myFoxload-Banner']);
    update_option("widget_myFoxload", $options);
  }
  
  if (strpos($options['banner'], $options['size']) === FALSE) {
	$pos1 = strpos($options['banner'], '-');
	$pos2 = strpos($options['banner'], '-', $pos1+1);
	$options['size'] = substr($options['banner'], 0, $pos2);
	update_option("widget_myFoxload", $options);
  }
  
  if ($standalone) {
	echo '<form action=""  method="post">';
  }

  echo 	'<script type="text/javascript">'.
			'function showFoxloadBanner(size) {'.
				'showFoxloadBannerElements(getFoxloadBannerElementsByClass("myFoxload-banner-110-32"), (size == "110-32" ? true : false));'.
				'showFoxloadBannerElements(getFoxloadBannerElementsByClass("myFoxload-banner-120-240"), (size == "120-240" ? true : false));'.
				'showFoxloadBannerElements(getFoxloadBannerElementsByClass("myFoxload-banner-125-125"), (size == "125-125" ? true : false));'.
				'showFoxloadBannerElements(getFoxloadBannerElementsByClass("myFoxload-banner-173-26"), (size == "173-26" ? true : false));'.
				'showFoxloadBannerElements(getFoxloadBannerElementsByClass("myFoxload-banner-468-60"), (size == "468-60" ? true : false));'.
				'showFoxloadBannerElements(getFoxloadBannerElementsByClass("myFoxload-banner-80-15"), (size == "80-15" ? true : false));'.
			'}'.
			'function getFoxloadBannerElementsByClass(className) {'.
				'var divElements = document.getElementsByTagName("div");'.
				'var classElements = new Array();'.				
				'for (i=0; i<divElements.length; i++) {'.				
					'if (divElements[i].className == className) { classElements.push(divElements[i]); }'.
				'}'.
				'return classElements;'.
			'}'.
			'function showFoxloadBannerElements(bannerElements, visible) {'.
				'for (i=0; i<bannerElements.length; i++) {'.				
					'if (visible) { bannerElements[i].style.display = ""; } else { bannerElements[i].style.display = "none"; }'.
				'}'.
			'}'.
		'</script>'.
		'<p>'.
		'<table border="0">'.
		'<tr><td valign="middle"><label for="myFoxload-WidgetTitle">Title: </label></td>'.
		'<td valign="middle"><input type="text" id="myFoxload-WidgetTitle" name="myFoxload-WidgetTitle" value="'.$options['title'].'" /></td></tr>'.
		'<tr><td valign="middle"><label for="myFoxload-Size">Size: </label>'.
		'<td valign="middle"><select id="myFoxload-Size" name="myFoxload-Size" onchange="showFoxloadBanner(this.value);">'.
			'<option value="110-32" '.($options['size'] == '110-32' ? 'selected="selected"' : '').'>110x32</option>'.
			'<option value="120-240" '.($options['size'] == '120-240' ? 'selected="selected"' : '').'>120x240</option>'.
			'<option value="125-125" '.($options['size'] == '125-125' ? 'selected="selected"' : '').'>125x125</option>'.
			'<option value="173-26" '.($options['size'] == '173-26' ? 'selected="selected"' : '').'>173x26</option>'.
			'<option value="468-60" '.($options['size'] == '468-60' ? 'selected="selected"' : '').'>468x60</option>'.
			'<option value="80-15" '.($options['size'] == '80-15' ? 'selected="selected"' : '').'>80x15</option>'.
		'</select></td></tr>'.
		'</table>'.
		'<table border="0">'.
		'<tr><td><label for="myFoxload-Banner">Banner: </label></td></tr>'.
		'</table>'.
		'<div style="padding-left: 10px;">'.
		'<div class="myFoxload-banner-110-32">'.
			'<table border="0">'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="110-32-blue" '.($options['banner'] == '110-32-blue' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-110-32-blue.png" width="110" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="110-32-green" '.($options['banner'] == '110-32-green' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-110-32-green.png" width="110" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="110-32-orange" '.($options['banner'] == '110-32-orange' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-110-32-orange.png" width="110" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="110-32-purple" '.($options['banner'] == '110-32-purple' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-110-32-purple.png" width="110" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="110-32-get-blue" '.($options['banner'] == '110-32-get-blue' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-110-32-get-blue.png" width="110" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="110-32-getmyFoxloadParent-orange" '.($options['banner'] == '110-32-get-orange' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-110-32-get-orange.png" width="110" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="110-32-get-purple" '.($options['banner'] == '110-32-get-purple' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-110-32-get-purple.png" width="110" /></td></tr>'.
			'</table>'.
		'</div>'.
		'<div class="myFoxload-banner-120-240">'.
			'<table border="0">'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="120-240-green" '.($options['banner'] == '120-240-green' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-120-240-green.png" height="80" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="120-240-orange" '.($options['banner'] == '120-240-orange' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-120-240-orange.png" height="80" /></td></tr>'.
			'</table>'.
		'</div>'.
		'<div class="myFoxload-banner-125-125">'.
			'<table border="0">'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="125-125" '.($options['banner'] == '125-125' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-125-125.png" width="80" /></td></tr>'.
			'</table>'.
		'</div>'.
		'<div class="myFoxload-banner-173-26">'.
			'<table border="0">'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="173-26-green" '.($options['banner'] == '173-26-green' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-173-26-green.png" width="150" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="173-26-orange" '.($options['banner'] == '173-26-orange' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-173-26-orange.png" width="150" /></td></tr>'.
			'</table>'.
		'</div>'.
		'<div class="myFoxload-banner-468-60">'.
			'<table border="0">'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="468-60-blue" '.($options['banner'] == '468-60-blue' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-468-60-blue.png" width="180" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="468-60-green" '.($options['banner'] == '468-60-green' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-468-60-green.png" width="180" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="468-60-orange" '.($options['banner'] == '468-60-orange' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-468-60-orange.png" width="180" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="468-60-purple" '.($options['banner'] == '468-60-purple' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-468-60-purple.png" width="180" /></td></tr>'.
			'</table>'.
		'</div>'.
		'<div class="myFoxload-banner-80-15">'.
			'<table border="0">'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="80-15-blue" '.($options['banner'] == '80-15-blue' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-80-15-blue.png" width="80" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="80-15-green" '.($options['banner'] == '80-15-green' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-80-15-green.png" width="80" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="80-15-orange" '.($options['banner'] == '80-15-orange' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-80-15-orange.png" width="80" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="80-15-square-blue" '.($options['banner'] == '80-15-square-blue' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-80-15-square-blue.png" width="80" /></td></tr>'.
				'<tr><td valign="middle"><input type="radio" name="myFoxload-Banner" value="80-15-square-orange" '.($options['banner'] == '80-15-square-orange' ? 'checked="checked"' : '').' /></td><td valign="middle"><img src="http://www.foxload.com/images/wp/firefox-80-15-square-orange.png" width="80" /></td></tr>'.
			'</table>'.
		'</div>'.
		'</div>'.
		'<script type="text/javascript">showFoxloadBanner("'.$options['size'].'");</script>'.
		'<input type="hidden" id="myFoxload-Submit" name="myFoxload-Submit" value="1" />'.
		'</p>';
	 
	if ($standalone) {
		echo '<p class="submit">';
		echo '<input name="submit" class="button-primary" value="Save" type="submit">';
		echo '</p>';
		echo '</form>';
		echo '<p>';
		echo 'If your theme does not support widgets, or you want to place the button somewhere else. Use this code:';
		echo '<pre>';
		echo "&lt;?php\n";
		echo "    if (function_exists('get_foxload_button')) {\n";
		echo "        get_foxload_button();\n";
		echo "    }\n";
		echo "?&gt";
		echo '</pre>';
		echo '</p>';
	}
}

function myFoxload_init() {
  register_sidebar_widget(__('Foxload'), 'widget_myFoxload');
  register_widget_control('Foxload', 'myFoxload_control');    
}

function myFoxload_admin_add_page() {
  add_options_page('Foxload', 'Foxload', 'manage_options', 'foxload-firefox-download.php', 'myFoxload_settings');
}

function myFoxload_footer() {
	echo '<script type="text/javascript">';
	echo 'var foxloadDocumentReferrer = escape(document.referrer);';
 	echo "var foxloadButtonReferrer = 'wordpress';";
	echo '</script>';
	echo '<script type="text/javascript" src="http://www.foxload.com/files/browsercheck.js"></script>';
}

add_action("plugins_loaded", "myFoxload_init");
add_action('admin_menu', 'myFoxload_admin_add_page');
add_action('wp_footer', 'myFoxload_footer');
?>
