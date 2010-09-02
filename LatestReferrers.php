<?php

/**
 * Latest Referrers Plugin
 *
 * Author:   Timo Besenreuther
 *           EZdesign.de
 * Created:  2010-09-01
 * Modified: 2010-09-02
 */

class Piwik_LatestReferrers extends Piwik_Plugin {
	
	/* Archive indexes */
    const REFERRER = 1;
    const REFERRER_URL = 2;
    const REFERRER_KEYWORD = 3;
    const ENTRY_IDACTION = 4;
    const ENTRY_URL = 5;
    const TIME = 6;
    const OCCURRENCES = 7;
    
    /** Columns traslations */
    private static $columnTranslations = array(
    	self::REFERRER => 'LatestReferrers_Referrer',
    	self::REFERRER_URL => 'LatestReferrers_ReferrerUrl',
	    self::REFERRER_KEYWORD => 'LatestReferrers_ReferrerKeyword',
	    self::ENTRY_URL => 'LatestReferrers_EntryUrl',
	    self::TIME => 'LatestReferrers_Time',
	    self::OCCURRENCES => 'LatestReferrers_Occurrences'
    );
	
	/** Translate and show table columns */
    public static function displayColumns($view, $columns) {
    	foreach ($columns as $column) {
	    	$view->setColumnTranslation($column,
	    			Piwik_Translate(self::$columnTranslations[$column]));
    	}
    	$view->setColumnsToDisplay($columns);
    }
    
	/** Information about this plugin */
	public function getInformation() {
		return array(
			'description' => Piwik_Translate('LatestReferrers_PluginDescription'),
			'author' => 'Timo Besenreuther, EZdesign',
			'author_homepage' => 'http://www.ezdesign.de/',
			'version' => '0.1.1',
			'translationAvailable' => true
		);
	}
	
	/** Register Hooks */
	public function getListHooksRegistered() {
        return array(
			'Menu.add' => 'addMenu'
        );
    }
	
	/** Menu hook */
	public function addMenu() {
		Piwik_AddMenu('Referers_Referers', 'LatestReferrers_LatestLinks',
				array('module' => 'LatestReferrers', 'action' => 'links'));
		Piwik_AddMenu('Referers_Referers', 'LatestReferrers_LatestSearches',
				array('module' => 'LatestReferrers', 'action' => 'searches'));
	}
	
}

?>