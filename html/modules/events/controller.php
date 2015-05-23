<?php
class eventsController extends controller {
	public function listAction() {
		if(router::_()->isAdmin()) {
			document::_()->addScript('admin.events.list', $this->getModule()->getUrl(). '/js/admin.events.list.js');
			document::_()->setContent( 
				$this->getView()->getAdminList( 
					$this->getModel()->getList() 
				) 
			);
		} else {
			$conditions = array();
			$model = $this->getModel();
			$by = router::_()->getPart(2);
			$id = (int) router::_()->getPart(3);
			$pageData = array();
			if(!empty($by) && !empty($id)) {
				switch($by) {
					case 'category':
						$conditions['IN']['id'] = $model->getIdsByCategory($id);
						$pageData['category'] = frame::_()->getModule('categories')->getModel()->getById( $id );
						break;
					case 'location':
						$conditions['IN']['id'] = $model->getIdsByLocation($id);
						$pageData['location'] = frame::_()->getModule('locations')->getModel()->getById( $id );
						break;
				}
			}
			$search = trim(req::getVar('s'));
			if(!empty($search)) {
				$conditions['OR']['WHOLE_LIKE'] = array(
					'label' => $search,
					'description' => $search,
				);
			}
			$model->setSortOrder('date_created');
			document::_()->setContent( 
				$this->getView()->getList( 
					$model->getFullList($conditions), $pageData
				) 
			);
		}
	}
	public function addAction() {
		document::_()->setTitle(lang::_('ADD_EVENT'));
		document::_()->addScript('chosen.jquery', URL_JS. '/chosen.jquery.min.js');
		document::_()->addStyle('chosen.jquery', URL_CSS. '/chosen.min.css');
		rs('files.connectDragDropAssets');
		document::_()->addScript('admin.events.edit', $this->getModule()->getUrl(). '/js/admin.events.edit.js');
		document::_()->setContent( $this->getView()->getEditForm() );
	}
	public function editAction() {
		$id = (int) router::_()->getPart(2);
		$event = $this->getModel()->getFullById($id);
		document::_()->setTitle(lang::_('EDIT_EVENT'). ' '. $event['label']);
		document::_()->addScript('chosen.jquery', URL_JS. '/chosen.jquery.min.js');
		document::_()->addStyle('chosen.jquery', URL_CSS. '/chosen.min.css');
		rs('files.connectDragDropAssets');
		document::_()->addJsVar('currentProgram', $event);
		document::_()->addScript('admin.events.edit', $this->getModule()->getUrl(). '/js/admin.events.edit.js');
		document::_()->setContent( 
			$this->getView()->getEditForm(
				$event
			)
		);
	}
	public function removeAction() {
		$id = (int) router::_()->getPart(2);
		if($id) {
			if($this->getModel()->removeById($id)) {
				$this->addData('id', $id);
			} else
				$this->pushError ($this->getModel()->getErrors());
		} else
			$this->pushError (lang::_('INVALID_ID'));
	}
	public function saveAction() {
		if(($id = $this->getModel()->save(req::get('post')))) {
			$this->addData('event', $this->getModel()->getById($id));
			if($this->getModel()->getLastDbAction() == 'INSERT') {	// For new added - redirect user to edit URL
				$this->addData('event_edit_link', $this->getModule()->getEditLink($id));
			}
			$this->pushMessage(lang::_('SAVED'));
		} else
			$this->pushError ($this->getModel()->getErrors());
	}
	public function addImageAction() {
		$fileData = frame::_()->getModule('files')->getModel()->saveFileFromRequest();
		if($fileData) {
			$pid = (int) router::_()->getPart(2);
			if($pid) {
				$this->getModel()->bindFiles($pid, $fileData['id']);
			}
			$this->addData('file', $this->getModel()->prepareFileData($fileData));
			$this->pushMessage(lang::_('SAVED'));
		} else
			$this->pushError (frame::_()->getModule('files')->getModel()->getErrors());
	}
	public function removeImageAction() {
		$pid = (int) router::_()->getPart(2);
		$fid = (int) router::_()->getPart(3);
		if($pid && $fid) {
			if($this->getModel()->unbindFile($pid, $fid)) {
				$this->pushMessage(lang::_('DONE'));
				$this->addData('fid', $fid);
			} else
				$this->pushError($this->getModel()->getErrors());
		} else
			$this->pushError (lang::_('INVALID_ID'));
	}
	public function viewAction() {
		$id = (int) router::_()->getPart(2);
		if($id && ($event = $this->getModel()->getFullById($id))) {
			document::_()->addScript('frontend.events.view', $this->getModule()->getUrl(). '/js/frontend.events.view.js');
			$this->getModel()->setViewed( $id );
			document::_()->setTitle($event['label']);
			document::_()->setContent( 
				$this->getView()->getSingle( 
					$event
				) 
			);
		} else {
			frame::_()->set404( true );
		}
	}
	public function searchAction() {
		$conditions = '';
		$search = trim(req::getVar('s'));
		if(!empty($search)) {
			$this->getModel()->setSortOrder('date_created');
			$conditions['OR']['WHOLE_LIKE'] = array(
				'label' => $search,
				'description' => $search,
			);
		}
		document::_()->setContent( 
			$this->getView()->getList( 
				$this->getModel()->getFullList( $conditions ) 
			) 
		);
	}
	public function getPermissions() {
		return array(
			ADMIN => array('save', 'remove', 'addImage', 'removeImage'),
		);
	}
}