<?php
class eventsView extends view {
	public function getAdminList($events) {
		$this->assign('events', $events);
		$this->assign('eventsFieldsList', $this->getListFields());
		$this->assign('module', $this->getModule());
		return parent::getContent('admin.list');
	}
	public function getList($events, $pageData = array()) {
		$this->assign('events', $events);
		$this->assign('pageData', $pageData);
		$this->assign('banner', frame::_()->getModule('user')->getBannerContent());
		return parent::getContent('list');
	}
	public function getEditForm($event = array()) {
		$this->assign('event', $event);
		$this->assign('edit', !empty($event));
		$this->assign('categoriesList', rs('categories.model.getListForParentSelect'));
		$this->assign('locationsList', rs('locations.model.getListForParentSelect'));
		return parent::getContent('editForm');
	}
	public function getListFields() {
		$baseFields = $this->getModel()->getFields();
		unset($baseFields['description']);
		return array_merge($baseFields, array(
			'date_created' => array('label' => lang::_('DATE_CREATED')),
			'actions' => array('label' => lang::_('ACTIONS')),
		));
	}
	public function getSingle($event) {
		$this->assign('event', $event);
		return parent::getContent('single');
	}
	public function getSearchForm($searched) {
		$this->assign('searched', $searched);
		return parent::getContent('searchForm');
	}
	public function showSearchForm($searched) {
		echo $this->getSearchForm($searched);
	}
}