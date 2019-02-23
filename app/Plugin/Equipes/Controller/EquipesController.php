<?php

Class EquipesController extends EquipesAppController {

    public $uses = array('Equipe', 'User', 'Rluserequipe', 'Datatable');

    public function index() {
        $this->layout = 'novo';
    }

    public function response() {
        $this->layout = '';
        $aColumns = array("id", "nome", "qtde_pessoas");
        $sTable = 'equipes';
        $aConditions = ' st_registro = "S" ';
        $this->autoRender = false;
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions);
        $output['aaData'] = $this->retornaGridList($output['aaData']);
        echo json_encode($output);
    }

    protected function retornaGridList($aaData) {
        $data = array();
        foreach ($aaData as $value) {
            $value[2] = $this->Rluserequipe->find('count', array('conditions' => array('st_registro' => 'S', 'id_equipe' => $value[0]), 'fields' => array('id', 'nome')));
            ;
            $data[] = $value;
        }
        return $data;
    }

    public function add($id = null) {

        $this->layout = 'novo';
        $user = $this->User->find('all', array('conditions' => array('st_registro' => 'S'), 'fields' => array('id', 'name', 'role_id', 'email', 'username'), 'order' => array('name ASC'),));
        $resultEquipe = array();
        foreach ($user as $key => $value) {
            $users['id'] = $value['User']['id'];
            $users['username'] = $value['User']['username'];
            $users['name'] = $value['User']['name'];
            $users['perfil'] = $value['User']['role_id'];
            $users['email'] = $value['User']['email'];
            $resultEquipe[] = $users;
        }

        $result = array();
        foreach ($resultEquipe as $k => $v) {
            if (isset($userequipe)) {
                foreach ($userequipe as $z) {
                    if ($v['id'] == $z) {
                        $v['equipe'] = true;
                    }
                }
            }
            $result[] = $v;
        }
        $this->set(compact('result'));

        $this->set(compact('id'));
        if ($this->request->is('post') || $this->request->is('put')) {
            if (empty($this->data['Equipe']['id'])) {
                $validEquipe = $this->Equipe->find('first', array('conditions' => array('nome' => $this->data['Equipe']['nome'], 'st_registro' => 'S')));
                if (!empty($validEquipe)) {
                    $this->_flash('O nome dessa Equipe já existe. Tente novamente!', 'error');
                    return;
                }
            }

            $cont = 0;
            foreach ($this->data['User']['Td'] as $value) {
                if ($value == '1') {
                    $cont++;
                }
            }
            $this->request->data['Equipe']['qtde_pessoas'] = $cont;
            $resultPrepare = array();
            if ($this->Equipe->save($this->request->data)) {

                $equipeAntiga = $this->Rluserequipe->find('all', array('conditions' => array('st_registro' => 'S', 'id_equipe' => $this->Equipe->id)));
                $inativaEquipe = array();
                foreach ($equipeAntiga as $value) {

                    $value['Rluserequipe']['st_registro'] = 'N';
                    $inativaEquipe[] = $value;
                }

                if (!empty($inativaEquipe)) {
                    $this->Rluserequipe->saveMany($inativaEquipe);
                }
                foreach ($this->data['User']['Td'] as $key => $value) {
                    if ($value == '1') {
                        $prepare['Rluserequipe']['st_registro'] = 'S';
                        $prepare['Rluserequipe']['id_equipe'] = $this->Equipe->id;
                        $id = explode('-', $key);
                        $prepare['Rluserequipe']['id_user'] = $id[1];
                        $resultPrepare[] = $prepare;
                    }
                }
                if ($this->Rluserequipe->saveMany($resultPrepare)) {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou a equipe : ' . $this->request->data['Equipe']['nome'] . '.', array('equipe'));
                    $this->_flash('Equipe inserida com sucesso', 'success', '/equipes/equipes');
                } else {
                    CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar a equipe.', array('equipe'));

                    $this->_flash('Equipe não foi inserida', 'error', '/equipes/equipes');
                }
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar a equipe.', array('equipe'));
                $this->_flash('Equipe não foi inserida', 'error', '/equipes/equipes');
            }
        } elseif ($id != null) {
            $this->Equipe->id = $id;
            if (!$this->Equipe->exists()) {
                $this->_flash('Equipe não existente no sistema.', 'error', '/equipes/equipes/');
            }
            $equipe = $this->Rluserequipe->find('all', array('conditions' => array('st_registro' => 'S', 'id_equipe' => $id), 'fields' => array('id_user')));


            if (!empty($equipe)) {
                foreach ($equipe as $key => $value) {
                    $userequipe[] = $value['Rluserequipe']['id_user'];
                }
            }


            if (!empty($userequipe)) {
                $this->set('userequipe', $userequipe);
            }
            $this->request->data = $this->Equipe->read();
        }
    }

    public function delete($id) {
        $equipe = $this->Equipe->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S'), 'fields' => 'nome'));
        if (empty($equipe)) {
            $this->_flash('Equipe não existente no sistema.', 'error', '/equipes/equipes/');
        }
        $this->Equipe->id = $id;

        $integridade = $this->Rluserequipe->find('first', array('conditions' => array('Rluserequipe.id_equipe' => $id, 'Rluserequipe.st_registro' => 'S'), 'fields' => array('id')));
        if (!empty($integridade)) {
            $this->_flash('Equipe não foi deletada pois contém usuários.', 'error', '/equipes/equipes/');
        }

        $this->Equipe->read('st_registro', $id);
        $this->Equipe->set(array(
            'st_registro' => 'N',
        ));
        if ($this->Equipe->save()) {
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou a equipe : ' . $equipe['Equipe']['nome'] . '.', array('equipe'));
            $this->_flash('Equipe foi deletada com sucesso.', 'success', '/equipes/equipes/');
        } else {
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar a equipe : ' . $equipe['Equipe']['nome'] . '.', array('equipe'));
            $this->_flash('Equipe não foi deletada.', 'error', '/equipes/equipes/');
        }
    }

}
