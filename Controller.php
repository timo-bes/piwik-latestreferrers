<?php

/**
 * Latest Referrers Plugin
 * Controller
 *
 * Author:   Timo Besenreuther
 *           EZdesign.de
 * Created:  2010-09-01
 * Modified: 2010-09-01
 */

class Piwik_LatestReferrers_Controller extends Piwik_Controller {
	
	/** The plugin index */
	public function index() {
		$view = new Piwik_View('LatestReferrers/templates/index.tpl');
		echo $view->render();
	}
	
}