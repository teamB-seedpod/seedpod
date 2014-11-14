<?php
class EventsController extends AppController{
	public $uses = array('User', 'Event', 'Comment', 'Participant');
	public $helpers = array('Html', 'Form', 'Session', 'UploadPack.Upload');
	public $components = array('Session');

	public function index(){
		$events = $this->Event->find('all',array('order' => array('open_datetime' => 'DESC')));
        $this->set('events', $events);

        //userテーブルをdetail.ctpに渡す
		$this->set('users', $this->User->find('all'));

		//過去のイベントをページネーションしたものをindex.ctpに渡す！
    	$past_events = $this->paginate('Event',array('open_datetime < now()'));
	    $this->set('past_events', $past_events);
	}

	public function detail($id = null){    //このidはeventsのid
		if(!$id){
			throw new NotFoundException(__('Invalid post'));
		}

		$event = $this->Event->findById($id); 
		if(!$event){
			throw new NotFoundException(__('Invalid post'));
		}
		$this->set('event', $event);

		//hosting名をUsersのtableから引っ張ってくる ←これは非効率なので変えた方がよいかも
		$user_id = $event['Event']['user_id'];
		$hosting = $this->User->findById($user_id);
		$this->set('hosting', $hosting);

		//userテーブルをdetail.ctpに渡す
		$this->set('users', $this->User->find('all'));

		//イベントに対応するcomment履歴をdetail.ctpに表示する
		$comments = $this->Comment->getComments($id);
		$this->set('comments', $comments);

		//commentの処理を行う
		if($this->request->is('post')){
			$this->Comment->create();
			if($this->Comment->save($this->request->data)){
				$this->Session->setFlash(__('Your comment has been saved.'));
				return $this->redirect($this->referer());
			}
			$this->Session->setFlash(__('Unable to comment.'));
		}

		//Participantテーブルの情報をviewに渡す
		$participants = $this->Participant->getParticipantInfo($id);
		$this->set('participants', $participants);

		//参加者の配列をviewに渡す
		$join_info = $this->Participant->getJoin($id);
		$this->set('join_info', $join_info);

		//保留者の配列をviewに渡す
		$maybe_info = $this->Participant->getMaybe($id);
		$this->set('maybe_info', $maybe_info);

		//保留者の配列をviewに渡す
		$invited_info = $this->Participant->getInvited($id);
		$this->set('invited_info', $invited_info);

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

	public function edit($id = null){
		if(!$id){
			throw new NotFoundException(__('Invalid post'));
		}

		$event = $this->Event->findById($id);
		if(!$event){
			throw new NotFoundException(__('Invalid post'));
		}

		//編集ボタンが押された場合に、DBへの保存処理を行う
		if($this->request->is(array('post', 'put'))){
			$this->Event->id = $id;
			if($this->Event->save($this->request->data)){
				$this->Session->setFlash(__('Your event has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to update your post.'));
		}

		//editページにアクセスした際にフォームにデータをセットしておく
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

	//コメント投稿を削除するためのメソッド
	public function delete_comment($id){
		if($this->request->is('get')){
			throw new MethodNotAllowException();
		}

		if($this->Comment->delete($id)){
			$this->Session->setFlash(__('The comment with id: %s has been deleted.', h($id)));
			return $this->redirect($this->referer());
		}
	}

	//イベントへの参加意志表明
	public function join($id){  //このidはevent id
		if($this->request->is('get')){
			throw new MethodNotAllowException();
		}

		$participants = $this->Participant->getParticipantInfo($id);
		$participant_id = $participants[0]['Participant']['id'];

		if($participant_id == null){
			// 登録する内容を設定
			$data = array('Participant' => array('event_id' => $id, 'user_id' => 1 , 'status' => 2));  //最終的にはAuthを利用する。2は参加。
			// 登録する項目（フィールド指定）
			$fields = array('event_id', 'user_id', 'status');
			// 登録
			$this->Participant->save($data, false, $fields);

			$this->Session->setFlash(__('Your will has been updated.'));
			return $this->redirect($this->referer());
		}else{
			//更新する内容を設定
			$data = array('Participant' => array('id' => $participant_id, 'status' => 2));
			// 更新する項目（フィールド指定）
			$fields = array('status');
			// 更新
			$this->Participant->save($data, false, $fields);

			$this->Session->setFlash(__('Your will has been updated.'));
			return $this->redirect($this->referer());
		}
	}

	//イベントへの保留意志表明
	public function maybe($id){  //このidはevent id
		if($this->request->is('get')){
			throw new MethodNotAllowException();
		}

		$participants = $this->Participant->getParticipantInfo($id);
		$participant_id = $participants[0]['Participant']['id'];

		if($participant_id == null){
			// 登録する内容を設定
			$data = array('Participant' => array('event_id' => $id, 'user_id' => 1 ,'status' => 3));  //最終的にはAuthを利用する。3は保留。
			// 登録する項目（フィールド指定）
			$fields = array('event_id','user_id','status');
			// 登録
			$this->Participant->save($data, false, $fields);

			$this->Session->setFlash(__('Your will has been updated.'));
			return $this->redirect($this->referer());
		}else{
			//更新する内容を設定
			$data = array('Participant' => array('id' => $participant_id, 'status' => 3));
			// 更新する項目（フィールド指定）
			$fields = array('status');
			// 更新
			$this->Participant->save($data, false, $fields);

			$this->Session->setFlash(__('Your will has been updated.'));
			return $this->redirect($this->referer());
		}
	}

	//イベントへの欠席意志表明
	public function decline($id){  //このidはevent id
		if($this->request->is('get')){
			throw new MethodNotAllowException();
		}

		$participants = $this->Participant->getParticipantInfo($id);
		$participant_id = $participants[0]['Participant']['id'];

		if($participant_id == null){
			// 登録する内容を設定
			$data = array('Participant' => array('event_id' => $id, 'user_id' => 1 , 'status' => 4));  //最終的にはAuthを利用する。4は欠席。
			// 登録する項目（フィールド指定）
			$fields = array('event_id', 'user_id', 'status');
			// 登録
			$this->Participant->save($data, false, $fields);

			$this->Session->setFlash(__('Your will has been updated.'));
			return $this->redirect($this->referer());
		}else{
			//更新する内容を設定
			$data = array('Participant' => array('id' => $participant_id, 'status' => 4));
			// 更新する項目（フィールド指定）
			$fields = array('status');
			// 更新
			$this->Participant->save($data, false, $fields);

			$this->Session->setFlash(__('Your will has been updated.'));
			return $this->redirect($this->referer());
		}
	}

	//ページネーションを利用してイベント一覧ページを作成する
	public $paginate = array(
        'limit' => 3,
        'order' => array(
            'Event.open_datetime' => 'desc'
        )
    );

    public function invite(){
		$users = $this->User->find('all', array('order' => array('name' => 'ASC')));
		$this->set('users', $users);

		//招待した情報をParticipantテーブルに反映させる
		// if($this->request->is('post')){
		// 	$this->Participant->create();
		// 	if($this->Participant->save($this->request->data)){
		// 		$this->Session->setFlash(__('Your comment has been saved.'));
		// 		return $this->redirect($this->referer());
		// 	}
		// 	$this->Session->setFlash(__('Unable to comment.'));
		// }
	}

}