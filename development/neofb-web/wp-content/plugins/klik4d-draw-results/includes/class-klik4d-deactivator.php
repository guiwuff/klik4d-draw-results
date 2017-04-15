<?php

class Klik4d_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// find out when the last event was scheduled
		$timestamp = wp_next_scheduled ('cron_klikk4d');
		// unschedule previous event if any
		wp_unschedule_event ($timestamp, 'cron_klikk4d');
	}

}