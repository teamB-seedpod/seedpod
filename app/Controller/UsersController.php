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
	public $components = array('Paginator', 'Session');
    public $helpers = array('UploadPack.Upload', 'Paginator');
    public $paginate = array (
        'limit' => 6,
        'order' => array (
            'created' => 'desc'
        )
    );

/**
 * beforeFilter
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'login', 'logout');
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
        $this->Paginator->settings = $this->paginate;
        $this->User->recursive = 0;
        $this->set('total', $this->User->find('count'));

        if ($this->request->is('post')) {
            $sort = $this->request->data['Sort']['group_id'];
            if ($sort == '0') {
                $this->set('users', $this->Paginator->paginate());
            } else {
                $this->set('users', $this->Paginator->paginate('User', array('group_id' => $sort)));
            }
        } else {
            $this->set('users', $this->Paginator->paginate());
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
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
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
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
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
