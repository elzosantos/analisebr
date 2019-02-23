<?php

App::uses('AuthComponent', 'Controller/Component');

class User extends UsersAppModel {

    public $name = 'User';

//    public function beforeSave()
//    {
//        if (isset($this->data[$this->alias]['password'])) {
//            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
//        }
//        return true;
//    }

}
