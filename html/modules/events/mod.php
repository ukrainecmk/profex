<?php
class eventsMod extends module {
	public function getProgrLink($event) {
		return uri::getLink('events/view/'. $event['id']);
	}
	public function getLink($event) {
		return $this->getProgrLink($event);
	}
	public function getEditLink($pid) {
		return uri::getAdminLink('events/edit/'. $pid);
	}
	public function getRemoveLink($pid) {
		return uri::getAdminLink('events/remove/'. $pid);
	}
	public function getSearchAction() {
		$action = 'events/list';
		$allRouteParts = router::_()->getParts();
		if(count($allRouteParts) == 4 && $allRouteParts[0] == 'events' && $allRouteParts[1] == 'list') {
			$action = implode('/', $allRouteParts);
		}
		return uri::getLink($action);
	}
}