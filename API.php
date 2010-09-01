<?php

/**
 * Latest Referrers Plugin
 * API
 *
 * Author:   Timo Besenreuther
 *           EZdesign.de
 * Created:  2010-09-01
 * Modified: 2010-09-01
 */

class Piwik_LatestReferrers_API {
	
	// singleton instance
	static private $instance = null;
	
	/** Get singleton instance
	 * @return Piwik_SiteSearch_API */
	static public function getInstance() {
		if (self::$instance == null) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
}

?>