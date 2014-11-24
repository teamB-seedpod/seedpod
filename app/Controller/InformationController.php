<?php


class InformationController extends AppController{
	public $uses = array('User', 'Information');
	public $helpers = array('Html', 'Form','Session');
	public $components = array('Session');

	public function view($id = null) {
		$this->Information->id = $id;
		$this->set('InformationList', $this->Information->read());
	}

	public function add(){
		$loginUser = $this->Auth->user();
		if($loginUser['role'] != 1){
			throw new NotFoundException(__('You are not allowed'));
		}

		if($this->request->is('post')) {
			if($this->Information->save($this->request->data)) {
				$this->Session->setFlash('Success!');
				$this->redirect(array('controller' => 'events', 'action'=>'index'));
			} else {
				$this->Session->setFlash('failed!');

			}
		}
	}

	public function edit($id = null) {
		$loginUser = $this->Auth->user();
		if($loginUser['role'] != 1){
			throw new NotFoundException(__('You are not allowed'));
		}

		$this->Information->id = $id;
		if($this->request->is('get')) {
			$this->request->data = $this->Information->read();
		} else {
			if($this->Information->save($this->request->data)) {
				$this->Session->setFlash('success!');
				$this->redirect(array('controller' => 'events', 'action' => 'index'));
			} else {
				$this->Session->setFlash('failed!');
			}
		}
	}

	public function delete($id) {
		$loginUser = $this->Auth->user();
		if($loginUser['role'] != 1){
			throw new NotFoundException(__('You are not allowed'));
		}

		$this->Information->id = $id;
		if($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if($this->Information->delete($id)) {
			$this->Session->setFlash('Deleted!');
			$this->redirect(array('controller' => 'events', 'action'=>'index'));
		}
	}
}


