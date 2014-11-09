<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

    var $actsAs = array(
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
