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
	
	/** Get latest new link referrers
	 * @return Piwik_DataTable */
	public function getLatestNewLinks($idSite, $period, $date) {
		return $this->getLatestLinks($idSite, $period, $date, true);
	}
	
	/** Get latest link referrers
	 * @return Piwik_DataTable */
	public function getLatestLinks($idSite, $period, $date, $onlyNew=false, $type=false) {
		Piwik::checkUserHasViewAccess($idSite);
		
		$onlyNewSql = '';
		if ($onlyNew) {
			$onlyNewSql = 'HAVING `'.Piwik_LatestReferrers::OCCURRENCES.'` = 1';
		}
		
		if (!$type) {
			$type = Piwik_Common::REFERER_TYPE_WEBSITE;
		}
		
		if ($type == Piwik_Common::REFERER_TYPE_WEBSITE) {
			$group = 'visit.referer_url';
			$select = 'visit.referer_url AS `'
					. Piwik_LatestReferrers::REFERRER_URL.'`';
		} else {
			$group = 'visit.referer_keyword';
			$select = 'visit.referer_keyword AS `'
					. Piwik_LatestReferrers::REFERRER_KEYWORD.'`';
		}
		
		$sql = '
			SELECT
				visit.referer_name AS `'.Piwik_LatestReferrers::REFERRER.'`,
				visit.visit_entry_idaction_url AS `'.Piwik_LatestReferrers::ENTRY_URL.'`,
				action.name AS `'.Piwik_LatestReferrers::ENTRY_URL.'`,
				COUNT(idvisit) AS `'.Piwik_LatestReferrers::OCCURRENCES.'`,
				MAX(visit.visit_first_action_time) AS `'.Piwik_LatestReferrers::TIME.'`,
				'.$select.'
			FROM
				'.Piwik_Common::prefixTable('log_visit').' AS visit
			LEFT JOIN
				'.Piwik_Common::prefixTable('log_action').' AS action
				ON visit.visit_entry_idaction_url = action.idaction
			WHERE
				visit.idsite = '.intval($idSite).' AND
				visit.referer_type = '.intval($type).'
			GROUP BY
				visit.referer_name,
				'.$group.',
				visit.visit_entry_idaction_url
			'.$onlyNewSql.'
			ORDER BY
				`'.Piwik_LatestReferrers::TIME.'` DESC
			LIMIT
				0, 20
		';
		
		return $this->buildDataTableFromSql($sql);
	}
	
	/** Get latest new searches
	 * @return Piwik_DataTable */
	public function getLatestNewSearches($idSite, $period, $date) {
		$type = Piwik_Common::REFERER_TYPE_SEARCH_ENGINE;
		return $this->getLatestLinks($idSite, $period, $date, true, $type);
	}
	
	/** Get latest searches
	 * @return Piwik_DataTable */
	public function getLatestSearches($idSite, $period, $date) {
		$type = Piwik_Common::REFERER_TYPE_SEARCH_ENGINE;
		return $this->getLatestLinks($idSite, $period, $date, false, $type);
	}
	
	/** Build DataTable from sql
	 * @return Piwik_DataTable */
	private function buildDataTableFromSql($sql, $bind=array()) {
		$data = Piwik_FetchAll($sql, $bind);
		return $this->buildDataTable($data);
	}
	
	/** Build DataTable from array
	 * @return Piwik_DataTable */
	private function buildDataTable(&$data) {
		$entryUrl     = Piwik_LatestReferrers::ENTRY_URL;
		$refUrl       = Piwik_LatestReferrers::REFERRER_URL;
		
		$dataTable = new Piwik_DataTable();
		foreach ($data as &$row) {
			// build data table row
			$rowData = array(Piwik_DataTable_Row::COLUMNS => $row);
			// add entry url
			$rowData[Piwik_DataTable_Row::METADATA]['url'] = array(
					$entryUrl => $row[$entryUrl]);
			// add referrer url, if available
			if (isset($row[$refUrl])) {
				$rowData[Piwik_DataTable_Row::METADATA]['url'][$refUrl] = $row[$refUrl];
			}
			$dataTable->addRow(new Piwik_DataTable_Row($rowData));
		}
		return $dataTable;
	}
	
}

?>