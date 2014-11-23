<?php
class EventsController extends AppController{
	public $uses = array('User', 'Event', 'Comment', 'Participant', 'Information');
	public $helpers = array('Html', 'Form', 'Session', 'UploadPack.Upload');
	public $components = array('Session');

	public function index(){
		//Informationの情報をviewに渡す
		$conditions = array(
			'order' => 'created'
		);

		$this->set('Information', $this->Information->find('all', $conditions));
		$this->set('title_for_layout', 'Nexseed');
		$this->set('UsersInformation', $this->User->find('all'));

		//Eventsの情報をviewに渡す
		$events = $this->Event->find('all',array('order' => array('open_datetime' => 'DESC')));
        $this->set('events', $events);

        //userテーブルをdetail.ctpに渡す
		$this->set('users', $this->User->find('all'));
	}

	public function past(){
		$events = $this->Event->find('all',array('order' => array('open_datetime' => 'DESC')));
        $this->set('events', $events);

		$this->set('users', $this->User->find('all'));
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
			$dateTime = $this->request->data;
			$openDateTime = $dateTime['Event']['open_datetime']['year'].'-'.$dateTime['Event']['open_datetime']['month'].'-'.$dateTime['Event']['open_datetime']['day'].' '.$dateTime['Event']['open_datetime']['hour'].':'.$dateTime['Event']['open_datetime']['min'].' '.$dateTime['Event']['open_datetime']['meridian'];
			$closeDateTime = $dateTime['Event']['close_datetime']['year'].'-'.$dateTime['Event']['close_datetime']['month'].'-'.$dateTime['Event']['close_datetime']['day'].' '.$dateTime['Event']['close_datetime']['hour'].':'.$dateTime['Event']['close_datetime']['min'].' '.$dateTime['Event']['close_datetime']['meridian'];

			if(strtotime($openDateTime) > strtotime($closeDateTime)){
				$this->Session->setFlash(__('\'Close Datetime\' must be later than Open \'Datetime\''));
				false;
			}else if(strtotime($openDateTime) < strtotime(date("Y-m-d H:i:s"))){
				$this->Session->setFlash(__('Please create future event'));
				false;
			}else{
				$this->Event->create();
				if($this->Event->save($this->request->data)){
					$this->Session->setFlash(__('Your create has been saved.'));
					return $this->redirect(array('action' => 'index'));
				}
				$this->Session->setFlash(__('Unable to create.'));
			}
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
			$dateTime = $this->request->data;
			$openDateTime = $dateTime['Event']['open_datetime']['year'].'-'.$dateTime['Event']['open_datetime']['month'].'-'.$dateTime['Event']['open_datetime']['day'].' '.$dateTime['Event']['open_datetime']['hour'].':'.$dateTime['Event']['open_datetime']['min'].' '.$dateTime['Event']['open_datetime']['meridian'];
			$closeDateTime = $dateTime['Event']['close_datetime']['year'].'-'.$dateTime['Event']['close_datetime']['month'].'-'.$dateTime['Event']['close_datetime']['day'].' '.$dateTime['Event']['close_datetime']['hour'].':'.$dateTime['Event']['close_datetime']['min'].' '.$dateTime['Event']['close_datetime']['meridian'];

			if(strtotime($openDateTime) > strtotime($closeDateTime)){
				$this->Session->setFlash(__('\'Close Datetime\' must be later than Open \'Datetime\''));
				false;
			}else if(strtotime($openDateTime) < strtotime(date("Y-m-d H:i:s"))){
				$this->Session->setFlash(__('Please create future event'));
				false;
			}else{
				if($this->Event->save($this->request->data)){
					$this->Session->setFlash(__('Your event has been updated.'));
					return $this->redirect(array('action' => 'detail', $id));
				}
				$this->Session->setFlash(__('Unable to update your post.'));
			}
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

		$data = array('Event' => array('id' => $id, 'del_flg' => 1));
		$fields = array('del_flg');
		if($this->Event->save($data, false, $fields)){
			$this->Session->setFlash(__('The event with id: %s has been deleted.', h($id)));
			return $this->redirect(array('action' => 'index'));
		}
	}

	//コメント投稿を削除するためのメソッド
	public function delete_comment($id){
		if($this->request->is('get')){
			throw new MethodNotAllowException();
		}

		$data = array('Comment' => array('id' => $id, 'del_flg' => 1));
		$fields = array('del_flg');
		if($this->Comment->save($data, false, $fields)){
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
			$loginUser = $this->Auth->user();
			// 登録する内容を設定
			$data = array('Participant' => array('event_id' => $id, 'user_id' => $loginUser['id'] , 'status' => 2));
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
			$loginUser = $this->Auth->user();
			// 登録する内容を設定
			$data = array('Participant' => array('event_id' => $id, 'user_id' => $loginUser['id'] , 'status' => 3));
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
			$loginUser = $this->Auth->user();
			// 登録する内容を設定
			$data = array('Participant' => array('event_id' => $id, 'user_id' => $loginUser['id'] , 'status' => 4));
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

    public function invite($id){  //このidはEventのid
    	if(!$id){
			throw new NotFoundException(__('Invalid post'));
		}

		$event = $this->Event->findById($id);
		$this->set('event', $event);

		$users = $this->User->find('all', array('order' => array('name' => 'ASC')));
		$this->set('users', $users);

		//viewからpost送信された場合にParticipantDBに保存する
		if($this->request->is('post')){
			$invite_list = $this->request->data;

			if(isset($invite_list)){
				foreach($invite_list as $invite){
				if(!is_array($invite)){
						// 登録する内容を設定
						$data = array('Participant' => array('event_id' => $id, 'user_id' => $invite , 'status' => 1));
						// 保存
						$this->Participant->saveAll($data);
					}
				}
			$this->Session->setFlash(__('Your invitation has been sent.'));
			return $this->redirect(array('action' => 'detail', $id));
			}
		}
	}

	//ページのアクセス権限処理(オーナー以外はアクセス不可)
	public function isAuthorized($user){
		if(in_array($this->action, array('edit', 'delete', 'invite'))){
			$eventId = (int) $this->request->params['pass']['0'];
			$eventInfo = $this->Event->findById($eventId);
			$eventUserId = $eventInfo['Event']['user_id'];
			if($eventUserId != $user['id']){
				return false;
			}
		}
		if(in_array($this->action, array('delete_comment'))){
			$commentId = (int) $this->request->params['pass']['0'];
			$comment = $this->Comment->findById($commentId);
			$commentUserId = $comment['Comment']['user_id'];
			if($commentUserId != $user['id']){
				return false;
			}
		}
		return parent::isAuthorized($user);
	}
}
