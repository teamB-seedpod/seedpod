<?php


class InformationController extends AppController{
	public $uses = array('User','Information');
	public $helpers = array('Html','Form');

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



}


