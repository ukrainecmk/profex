<?php
class userView extends view {
	public function getAdminList($dataList) {
		$this->assign('dataList', $dataList);
		$this->assign('fieldsList', $this->getListFields());
		$this->assign('module', $this->getModule());
		$this->assign('rolesList', $this->getModel()->getRolesListForSelect());
		return parent::getContent('admin.list');
	}
	public function getEditForm($data = array()) {
		$edit = !empty($data);
		$this->assign('rolesList', $this->getModel()->getRolesListForSelect());
		$this->assign('data', $data);
		$this->assign('edit', $edit);
		$this->assign('fieldsList', $this->getListFields());
		return parent::getContent('editForm');
	}
	public function getListFields() {
		$baseFields = $this->getModel()->getFields();
		unset($baseFields['passwd']);
		return array_merge($baseFields, array(
			'actions' => array('label' => lang::_('ACTIONS')),
		));
	}
	public function getSubscribeForm() {
		return parent::getContent('subscribeForm');
	}
	public function getSubscribeBtn($eid) {
		$this->assign('eid', $eid);
		$this->assign('isLoggedIn', $this->getModule()->isLoggedIn());
		$this->assign('subscribed', $this->getModule()->isSubscribed($eid));
		return parent::getContent('subscribeBtn');
	}
	public function showSubscribeBtn($pid) {
		echo $this->getSubscribeBtn($pid);
	}
	public function getProfileContent($user) {
		$this->assign('user', $user);
		$this->assign('banner', $this->getBannerContent());
		if(!empty($user['subscribed'])) {
			$this->assign('subscribedPrograms', frame::_()->getModule('events')->getModel()->getList(array('IN' => array('id' => $user['subscribed']))));
		}
		return parent::getContent('profile');
	}
	public function getBannerContent() {
		return parent::getContent('banner');
	}
}