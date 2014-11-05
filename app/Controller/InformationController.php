<?php


class InformationController extends AppController{
	public $helpers = array('Html','Form');

	public function index(){
		$params = array(
			'order' => 'modified desc'
		);

		$this->set('Information', $this->Information->find('all',$params));
		$this->set('title_for_layout', 'Nexseed');
	}

	public function view($id = null){
		$this->Information->id = $id;
		$this->set('Info',$this->Information->read());
		
	}



}


