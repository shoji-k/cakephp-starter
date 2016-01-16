<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 */
class Post extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'title' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                'message' => 'Input title.',
                'allowEmpty' => false,
                'required' => true,
            ],
            'maxLength' => [
                'rule' => ['maxLength', '255'],
                'message' => 'Input title in 255 characters or less.',
            ],
        ],
        'body' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                'message' => 'Input body.',
                'allowEmpty' => false,
                'required' => true,
            ],
            'maxLength' => [
                'rule' => ['maxLength', '255'],
                'message' => 'Input body in 255 characters or less.',
            ],
        ],
    ];
}
