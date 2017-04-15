<?php

class Klik4d_Activator {

	/**
	 * Data fetch into scheduled event (hourly) - later can setup
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Register cron into schedule event
		if( !wp_next_scheduled( 'cron_klik4d' ) ) {  
			   wp_schedule_event( time(), 'hourly', 'cron_klik4d' );  
			}
	}

}