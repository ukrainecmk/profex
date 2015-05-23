<?php
class eventsModel extends model {
	private $_e2fTbl = 'events2files';
	private $_e2cTbl = 'events2categories';
	private $_e2lTbl = 'events2locations';
	private $_getFull = false;
	public function __construct($code) {
		parent::__construct($code);
		$this->_setFields(array(
			'label' => array('valid' => 'notEmpty', 'label' => lang::_('EVENT_LABEL')),
			'description' => array('label' => lang::_('EVENT_DESC')),
			'views' => array('label' => lang::_('EVENT_VIEWS')),
			'subscribed' => array('label' => lang::_('SUBSCRIBERS')),
			'start_date' => array('valid' => 'notEmpty', 'label' => lang::_('START_DATE')),
			'event_place' => array('label' => lang::_('EVENT_PLACE')),
		));
		$this->_setTbl('events');
	}
	protected function _prepareDataBeforeSave($data) {
		if(isset($data['start_date']) && !empty($data['start_date'])) {
			$data['start_date'] = date::dateFromDatepick( $data['start_date'] );
		}
		return $data;
	}
	protected function _afterSave($id, $data) {
		$this->unbindFiles($id);
		if(isset($data['img_id']) && !empty($data['img_id'])) {
			$this->bindFiles($id, $data['img_id']);
		}
		$this->unBind($this->_e2cTbl, array('eid' => $id));
		$this->unBind($this->_e2lTbl, array('eid' => $id));
		if(isset($data['categories_ids']) && !empty($data['categories_ids'])) {
			$this->bind($this->_e2cTbl, array(
				'eid' => $id,
				'cid' => array_map('intval', $data['categories_ids']),
			));
		}
		if(isset($data['locations_ids']) && !empty($data['locations_ids'])) {
			$this->bind($this->_e2lTbl, array(
				'eid' => $id,
				'lid' => array_map('intval', $data['locations_ids']),
			));
		}
	}
	protected function _afterGetList($fromDb) {
		$events = array();
		$prodIdToI = array();
		foreach($fromDb as $p) {
			if(isset($prodIdToI[ $p['id'] ])) {
				$pIter = $prodIdToI[ $p['id'] ];
			} else {
				$pIter = $prodIdToI[ $p['id'] ] = count($events);
				$events[ $pIter ] = $p;
			}
		}
		if($this->_getFull) {
			foreach($events as $i => $p) {
				$events[ $i ]['files'] = $this->getProgramFiles( $p['id'] );
				if(empty($events[ $i ]['files']))
					$events[ $i ]['files'] = array();
				
				$events[ $i ]['categories_ids'] = $events[ $i ]['locations_ids'] = array();
				$events[ $i ]['categories'] = $this->getCategories( $p['id'] );
				if(empty($events[ $i ]['categories']))
					$events[ $i ]['categories'] = array();
				else {
					foreach($events[ $i ]['categories'] as $c) {
						$events[ $i ]['categories_ids'][] = $c['id'];
					}
				}
				$events[ $i ]['locations'] = $this->getLocations( $p['id'] );
				if(empty($events[ $i ]['locations']))
					$events[ $i ]['locations'] = array();
				else {
					foreach($events[ $i ]['locations'] as $l) {
						$events[ $i ]['locations_ids'][] = $l['id'];
					}
				}
			}
		}
		$this->_getFull = false;
		return $events;
	}
	public function getCategories($id) {
		return frame::_()->getModule('categories')->getModel()->getBinded(array(
			'eid' => $id,
		), array(
			$this->_e2cTbl => 'cid',
		));
	}
	public function getLocations($id) {
		return frame::_()->getModule('locations')->getModel()->getBinded(array(
			'eid' => $id,
		), array(
			$this->_e2lTbl => 'lid',
		));
	}
	public function getFullList($conditions = array(), $sortOrder = '') {
		$this->_getFull = true;
		if(!empty($sortOrder)) {
			$this->setSortOrder($sortOrder);
		}
		return $this->getList($conditions);
	}
	public function getFullById($id) {
		$this->_getFull = true;
		return $this->getById($id);
	}
	public function getProgramFiles($eid) {
		$filesTbl = frame::_()->getModule('files')->getModel()->getTbl();
		$files = db::_()->get('SELECT f.*, f2p.type FROM `'. $this->_e2fTbl. '` f2p 
			INNER JOIN `'. $filesTbl. '` f ON f.id = f2p.fid', ALL, array('eid' => $eid));
		if($files) {
			$uploadsUrl = frame::_()->getModule('files')->getModel()->getUploadsUrl();
			foreach($files as $i => $f) {
				$files[ $i ] = $this->prepareFileData( $f, $uploadsUrl );
			}
			return $files;
		}
		return false;
	}
	public function prepareFileData($file, $uploadsUrl = '') {
		if(empty($uploadsUrl))
			$uploadsUrl = frame::_()->getModule('files')->getModel()->getUploadsUrl();
		$file['url'] = $uploadsUrl. '/'. $file['alias'];
		return $file;
	}
	public function unbindFiles($eid) {
		return $this->unBind($this->_e2fTbl, array('eid' => $eid));
	}
	public function unbindFile($eid, $fid) {
		if(db::_()->query('DELETE FROM `'. $this->_e2fTbl. '` WHERE '. db::_()->toQuery(array('eid' => $eid, 'fid' => $fid), 'AND'))) {
			// Remove it from here - when we will have gallery for our files
			if(frame::_()->getModule('files')->getModel()->remove( $fid )) {
				return true;
			} else
				$this->pushError(frame::_()->getModule('files')->getModel()->getErrors());
		} else
			$this->pushError (db::_()->getLastError ());
		return false;
	}
	public function bindFiles($eid, $fIds) {
		if(!is_array($fIds))
			$fIds = array($fIds);
		return $this->bind($this->_e2fTbl, array(
			'eid' => $eid,
			'fid' => $fIds,
		));
	}
	public function setViewed($eid) {
		db::_()->query('UPDATE `'. $this->_tbl. '` SET views = views + 1 WHERE id = '. $eid);
	}
	public function setSubscribed($eid) {
		db::_()->query('UPDATE `'. $this->_tbl. '` SET subscribed = subscribed + 1 WHERE id = '. $eid);
	}
	public function setUnsubscribed($eid) {
		db::_()->query('UPDATE `'. $this->_tbl. '` SET subscribed = IF(subscribed - 1 >= 0, subscribed - 1, 0) WHERE id = '. $eid);
	}
	public function getIdsByCategory($id) {
		return db::_()->get("SELECT eid FROM $this->_e2cTbl WHERE cid = '$id'", COL);
	}
	public function getIdsByLocation($id) {
		return db::_()->get("SELECT eid FROM $this->_e2lTbl WHERE lid = '$id'", COL);
	}
}