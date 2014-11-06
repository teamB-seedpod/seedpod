<?php
class EventsController extends AppController{
	public $uses = array('User','Event');
	public $helpers = array('Html', 'Form','Session');
	public $components = array('Session');

	public function index(){
		$this->set('events', $this->Event->find('all'));
	}

	public function detail($id = nuLL){    //このidはeventsのid
		if(!$id){
			throw new NotFoundException(__('Invalid post'));
		}

		$event = $this->Event->findById($id); 
		if(!$event){
			throw new NotFoundException(__('Invalid post'));
		}
		$this->set('event',$event);

		//hosting名をUsersのtableから引っ張ってくる
		$user_id = $event['Event']['user_id'];
		$hosting = $this->User->findById($user_id);
		$this->set('hosting',$hosting);
	}

	public function create(){
		if($this->request->is('post')){
			$this->Event->create();
			if($this->Event->save($this->request->data)){
				$this->Session->setFlash(__('Your create has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to create.'));
		}
	}

	public function edit($id = nuLL){
		if(!$id){
			throw new NotFoundException(__('Invalid post'));
		}

		$event = $this->Event->findById($id);
		if(!$event){
			throw new NotFoundException(__('Invalid post'));
		}

		//編集ボタンが押された場合に、DBへの保存処理を行う
		if($this->request->is(array('post','put'))){
			$this->Event->id = $id;
			if($this->Event->save($this->request->data)){
				$this->Session->setFlash(__('Your event has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to update your post.'));
		}

		//ページにアクセスした際にフォームにデータをセットしておく
		if(!$this->request->data){
			$this->request->data = $event;
		}
	}

	public function delete($id){
		if($this->request->is('get')){
			throw new MethodNotAllowException();
		}

		if($this->Event->delete($id)){
			$this->Session->setFlash(__('The event with id: %s has been deleted.', h($id)));
			return $this->redirect(array('action' => 'index'));
		}
	}

}