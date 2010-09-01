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
	
	/** Latest links method */
	public function links() {
		$view = new Piwik_View('LatestReferrers/templates/links.tpl');
		$view->latestLinks = $this->latestLinks(true);
		$view->latestNewLinks = $this->latestNewLinks(true);
		echo $view->render();
	}
	
	/** Latest searches method */
	public function searches() {
		$view = new Piwik_View('LatestReferrers/templates/searches.tpl');
		$view->latestSearches = $this->latestSearches(true);
		$view->latestNewSearches = $this->latestNewSearches(true);
		echo $view->render();
	}
	
	/** Get latest new links */
	public function latestNewLinks($return=false) {
		$view = new Piwik_ViewDataTable_HtmlTable();
		$view->init($this->pluginName,  __FUNCTION__, 'LatestReferrers.getLatestNewLinks');
		$cols = array(
			Piwik_LatestReferrers::REFERRER,
			Piwik_LatestReferrers::REFERRER_URL,
			Piwik_LatestReferrers::ENTRY_URL,
			Piwik_LatestReferrers::TIME
		);
		return $this->latestLinks($return, $view, $cols);
	}
	
	/** Get latest links */
	public function latestLinks($return=false, $view=null, $cols=null) {
		if (!$cols) {
			$cols = array(
				Piwik_LatestReferrers::REFERRER,
				Piwik_LatestReferrers::REFERRER_URL,
				Piwik_LatestReferrers::ENTRY_URL,
				Piwik_LatestReferrers::TIME,
				Piwik_LatestReferrers::OCCURRENCES
			);
		}
		
		if (!$view) {
			$view = new Piwik_ViewDataTable_HtmlTable();
			$view->init($this->pluginName,  __FUNCTION__, 'LatestReferrers.getLatestLinks');
		}
		
		Piwik_LatestReferrers::displayColumns($view, $cols);
		
		$view->setTemplate('LatestReferrers/templates/datatable.tpl');
		$view->setSortedColumn(Piwik_LatestReferrers::TIME, 'desc');
		$view->disableFooterIcons();
		$view->disableSearchBox();
		$view->setLimit(5);
		
		$result = $this->renderView($view, true);
		if ($return) return $result;
		echo $result;
	}
	
	/** Get latest new searches */
	public function latestNewSearches($return=false) {
		$view = new Piwik_ViewDataTable_HtmlTable();
		$view->init($this->pluginName,  __FUNCTION__, 'LatestReferrers.getLatestNewSearches');
		$cols = array(
			Piwik_LatestReferrers::REFERRER,
			Piwik_LatestReferrers::REFERRER_KEYWORD,
			Piwik_LatestReferrers::ENTRY_URL,
			Piwik_LatestReferrers::TIME
		);
		return $this->latestLinks($return, $view, $cols);
	}
	
	/** Get latest searches */
	public function latestSearches($return=false) {
		$view = new Piwik_ViewDataTable_HtmlTable();
		$view->init($this->pluginName,  __FUNCTION__, 'LatestReferrers.getLatestSearches');
		$cols = array(
			Piwik_LatestReferrers::REFERRER,
			Piwik_LatestReferrers::REFERRER_KEYWORD,
			Piwik_LatestReferrers::ENTRY_URL,
			Piwik_LatestReferrers::TIME,
			Piwik_LatestReferrers::OCCURRENCES
		);
		return $this->latestLinks($return, $view, $cols);
	}
	
}