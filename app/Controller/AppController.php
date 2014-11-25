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

<<<<<<< HEAD
    public function beforeFilter() {
=======
<<<<<<< HEAD
    public function beforeFilter(){
        $this->Auth->allow();
=======
    public function beforeFilter() {

        $this->Auth->allow(); 
>>>>>>> e372864a00ac792ad0fb97c362797855948bfa60
>>>>>>> 7683d9210e289ee3b35607b3bed57a2aabc78174
        if ($this->Auth->user()) {
            $loginUser = $this->Auth->user();
            $this->set('loginUser', $loginUser);
        }
    }
}
