<?php
/**
 * Plugin Name: 	Rebrand Salon Booking
 * Plugin URI: 	    https://rebrandpress.com/rebrand-salonbooking/
 * Description: 	Salon booking allows client-facing businesses to provide a streamlined booking experience. With Rebrand Booking, you can customize your Salon Booking plugin and add your own branding. Change the name, remove the developer’s link, and add your own colors and logo to streamline your messaging and boost trust. 
 * Version:     	1.0
 * Author:      	RebrandPress
 * Author URI:  	https://rebrandpress.com/
 * License:     	GPL2 etc
 * Network:         Active
*/

if (!defined('ABSPATH')) { exit; }

if ( !class_exists('Rebrand_SalonBooking_Pro') ) {
	
	class Rebrand_SalonBooking_Pro {
		
		public function bzsalon_load()
		{
			global $bzsalon_load;
			load_plugin_textdomain( 'bzsalon', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

			if ( !isset($bzsalon_load) )
			{
			  require_once(__DIR__ . '/salonbooking-settings.php');
			  $PluginSalon = new BZSALON\BZRebrandSalonBookingSettings;
			  $PluginSalon->init();
			}
			return $bzsalon_load;
		}
		
	}
}
$PluginRebrandSalonBooking = new Rebrand_SalonBooking_Pro;
$PluginRebrandSalonBooking->bzsalon_load();
