<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {

    public $validate = array(
        'email' => array(
            'rule' => 'notEmpty'
        ),
        'password' => array(
            'rule' => 'notEmpty'
        ),
        'name' => array(
            'rule' => 'notEmpty'
        ),
        'group_id' => array(
            'rule' => 'notEmpty'
        ),
        'birthday' => array(
            'rule' => 'date',
            'allowEmpty' => true
        )
    ); 

    public $actsAs = array( //Profile Picture Setting
        'UploadPack.Upload' => array(
            'img' => array(
                'quality' => 95,
                'styles' => array(
                    'thumb' => '85x85'
                )
            )
        ),
    );

    public function beforeSave($options = array()) { //Password Hasher
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
        return true;
    }

}

