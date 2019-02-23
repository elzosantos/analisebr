<?php

App::uses('SistemasAppModel', 'Sistemas.Model');

class Sistema extends SistemasAppModel {

    //  public $hasMany = array('Analise');
//    public $belongsTo = array(
//        'Linguagem'
//    );

    public function isOwnedBy($post, $user)
    {
        return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
    }

    public function countSistema()
    {
        return $this->find('count', array('conditions' => array('st_registro' => 'S')));
    }

}
