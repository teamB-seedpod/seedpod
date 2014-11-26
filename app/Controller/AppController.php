<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $uses = array('User', 'Event', 'Participant');
    public $components = array(
        'DebugKit.Toolbar',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'User',
                    'fields' => array('username' => 'email', 'password' => 'password')
                )
            ),
            'authorize' => array('Controller')
        )
    );

    public function isAuthorized($user) {
        if ($user['del_flg'] == '0' && $user['role'] !== '0') {
            return true;
        } else {     
            return false;
        }
    }

    public function beforeFilter(){
        $this->Auth->allow();
        if ($this->Auth->user()) {
            $loginUser = $this->Auth->user();
            $this->set('loginUser', $loginUser);

            //Setting for common-left: get myowner events data
            $options = array('conditions' => array('user_id' => $loginUser['id']));
            $this->set('loginMyOwnerEvents', $this->Event->find('all', $options));

            //Setting for common-left: get myParticipant events data
            $options = array('conditions' => array('Participant.user_id' => $loginUser['id']));
            $participantEventIds = $this->Participant->find('all', $options);
            if($participantEventIds !== array()) {
                $participantEvents = $this->Event->getMyParticipantEvent($participantEventIds);
                $this->set('loginMyParticipantEvents', $participantEvents); 

            $events = $this->Event->find('all');
            $this->set('events', $events);
            }
        }        
    }
}