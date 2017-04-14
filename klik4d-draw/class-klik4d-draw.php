<?php

class Klik4d_Draw_Activator {
	public static function activate() {
		// Register cron into schedule event
		if( !wp_next_scheduled( 'klik4d_cron' ) ) {  
			   wp_schedule_event( time(), 'hourly', 'klik4d_cron' );  
			}
	}
}

class Klik4d_Draw_Deactivator {
	public static function deactivate() {
		// Remove next scheduled event and unschedule previous events
		$timestamp = wp_next_scheduled ('klik4d_cron');
		wp_unschedule_event ($timestamp, 'klik4d_cron');
	}

}

class Klik4d_Draw {
	private function __construct(){
		
	}
}