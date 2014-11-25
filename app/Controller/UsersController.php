<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
    public $uses = array('User', 'Event', 'Participant');
	public $components = array('Paginator', 'Session');
    public $helpers = array('UploadPack.Upload', 'Paginator');
    public $paginate = array (
        'limit' => 3,
        'order' => array (
            'created' => 'desc'
        )
    );

/**
 * beforeFilter
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'login', 'logout', 'approval');
    }

/**
 * isAuthorized: After Login Setting
 */
    public function isAuthorized($user) {
        if (in_array($this->action, array('edit', 'delete'))) {
            $userId = (int) $this->request->params['pass'][0];
            if ($userId ==  $user['id']) {
                return true;
            } else {
                return false;
            }
        }
        return parent::isAuthorized($user);
    }


/**
 * index method
 *
 * @return void
 */
    public function index() {
<<<<<<< HEAD
=======

>>>>>>> e372864a00ac792ad0fb97c362797855948bfa60
        $this->Paginator->settings = $this->paginate;
        $this->User->recursive = 0;
        $this->set('total', $this->User->find('count'));

        if ($this->request->is('post')) {
            $sort = $this->request->data['Sort']['group_id'];
            // パラメータをセッション変数に保存
            $this->Session->write('sort', $sort);
            $this->set('sort', $sort);
            $this->request->params['named']['page'] = 1;
            
            if ($sort == '0') {
                $this->set('users', $this->Paginator->paginate());
            } else {
                $this->set('users', $this->Paginator->paginate('User', array('group_id' => $sort)));
            }
        } else {
            if($this->Session->check('sort')) {
                $sort = $this->Session->read('sort');
                if ($sort == '0') {
                    $this->set('users', $this->Paginator->paginate());
                } else { 
                    $this->set('users', $this->Paginator->paginate('User', array('group_id' => $sort)));
                }
            } else {
                $this->set('users', $this->Paginator->paginate());
            }
        }
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));

        //GET OWNER EVENT: FUTURE
		$options = array('conditions' => array('user_id' => $id));
        $this->set('myOwnerEvents', $this->Event->find('all', $options));

        //GET OWNER EVENT: PAST : NOW NO NEED, LATER SETTING
    	//$option_past = array(
        //    'open_datetime < now()',
        //    'conditions' => array(
        //        'user_id' => $id,
        //    )
        //);
	    //$this->set('myOwnerPastEvents', $this->Event->find('all', $option_past));

        //GET PARTICIPANT EVENT: FUTURE
		$options = array('conditions' => array('Participant.user_id' => $id));
        $participantEventIds = $this->Participant->find('all', $options);
        if($participantEventIds !== array()) {
            $participantEvents = $this->Event->getMyParticipantEvent($participantEventIds);
            $this->set('myParticipantEvents', $participantEvents); 
        }

        //GET PARTICIPANT EVENT: PAST : NOW NO NEED, LATER SETTING
    	//$option_past = array(
        //    'open_datetime < now()',
        //    'conditions' => array(
        //        'Participant.user_id' => $id,
        //    )
        //);
        //$participantEventPastIds = $this->Participant->find('all', $option_past);
        //$participantPastEvents = $this->Event->getMyParticipantEvent($participantEventIds);
        //$this->set('myParticipantPastEvents', $participantPastEvents);

        //FOR SHOWING PARTICIPANT NAME
		$this->set('users', $this->User->find('all'));
    }



/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				return $this->redirect(array('action' => 'approval'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
        if ($this->request->is(array('post', 'put'))) {
            $this->User->id = $id;
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect('/users/view/'.$id);
            } else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
        } else {
            $options = array('conditions' => array('User.'.$this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
            $this->request->data['User']['password'] = null;
            $this->set('user', $this->request->data); //for showing profile picture
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
        
        $this->request->allowMethod('post', 'delete');

        //Delete by flag
        $options = array('conditions' => array('User.'.$this->User->primaryKey => $id));
        $data = $this->User->find('first', $options);
        $data['User']['del_flg'] = '1';

	    if ($this->User->save($data)) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'login'));
	}

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Invalid email or password, try again'));
            }
        }
    }

    public function logout(){
        $this->Auth->logout();
        $this->Session->destroy();
        return $this->redirect(array('action' => 'login'));
    }

    public function approval() {
        if ($this->Auth->user()) {

        } else {
            //not allow
        }
    }
}
