<?php

/**
 * Latest Referrers Plugin
 *
 * Author:   Timo Besenreuther
 *           EZdesign.de
 * Created:  2010-09-01
 * Modified: 2010-09-01
 */

class Piwik_LatestReferrers extends Piwik_Plugin {

	/** Information about this plugin */
	public function getInformation() {
		return array(
			'description' => Piwik_Translate('LatestReferrers_PluginDescription'),
			'author' => 'Timo Besenreuther, EZdesign',
			'author_homepage' => 'http://www.ezdesign.de/',
			'version' => '0.0',
			'translationAvailable' => true
		);
	}
	
	/** Register Hooks */
	public function getListHooksRegistered() {
        $hooks = array(
        	'AssetManager.getJsFiles' => 'getJsFiles',
        	'AssetManager.getCssFiles' => 'getCssFiles',
			'Menu.add' => 'addMenu',
        	'WidgetsList.add' => 'addWidgets'
        );
        return $hooks;
    }
    
    /** Add JavaScript */
    public function getJsFiles($notification) {
		$jsFiles = &$notification->getNotificationObject();
		$jsFiles[] = 'plugins/LatestReferrers/templates/latestreferrers.js';
	}
	
	/** Add CSS */
    public function getCssFiles($notification) {
		$cssFiles = &$notification->getNotificationObject();
		$cssFiles[] = 'plugins/LatestReferrers/templates/latestreferrers.css';
	}
	
	/** Menu hook */
	public function addMenu() {
		Piwik_AddMenu('Referers_Referers', 'LatestReferrers_LatestReferrers',
				array('module' => 'LatestReferrers', 'action' => 'index'));
	}
	
	/** Provide Widgets */
	public function addWidgets() {
		// TODO: widgets
	}
	
}

?>