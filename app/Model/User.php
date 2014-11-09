<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
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

    public $actsAs = array(
        'UploadPack.Upload' => array(
            'img' => array(
                'quality' => 95,
                'styles' => array(
                    'thumb' => '85x85'
                )
            )
        ),
    );
}
