<?php


class InformationController extends AppController{
	public $uses = array('User','Information');
	public $helpers = array('Html','Form','Session');
	public $components = array('Session');

	public function index(){
		$params = array(
			'order' => 'modified desc'
		);

		$this->set('Information', $this->Information->find('all',$params));
		$this->set('title_for_layout', 'Nexseed');
		$this->set('UsersInformation', $this->User->find('all'));
	}

	public function view($id = null){
		$this->Information->id = $id;
		$this->set('InformationList',$this->Information->read());
	}

	public function add(){
		if($this->request->is('post')){
			//↑のpostはpost送信で送られてきたという意味！！
			if($this->Information->save($this->request->data)){
				$this->Session->setFlash('Success!');
				$this->redirect(array('action'=>'index'));
			}else{
				$this->Session->setFlash('failed!');

			}
		}
	}

	//public function edit($id = null){
	//	$this->Post->id = $id;
	//	if($this->request->is('get')){
	//		$this->request->data = $this->Information->read();
	//	}else{
	//		if($this->Information->save($this->request->data)){
	//			$this->Session->setFlash('success!');
	//			$this->redirect(array('action' => 'index'));
	//		}else{
	//			$this->Session->setFlash('failed!');
	//		}
	//	}
	//}



}


