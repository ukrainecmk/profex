<?php
class dashboardController extends controller {
	public function indexAction() {
		document::_()->setContent( 
			$this->getView()->getIndex(array(
				'totals' => array(
					'events' => frame::_()->getModule('events')->getModel()->getTotal(),
					'subscribers' => frame::_()->getModule('user')->getModel()->getTotal(array('role_id' => 1/*Subscribers*/)),
				),
			)) 
		);
	}
	public function getPermissions() {
		return array(
			ADMIN => array('index'),
		);
	}
}