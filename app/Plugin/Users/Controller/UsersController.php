<?php

App::uses('CakeEmail', 'Network/Email');

class UsersController extends UsersAppController {

    public $uses = array('Users.User', 'Rluserequipe', 'Equipe', 'Datatable');

    public function login() {

        $this->layout = 'init';
        if ($this->request->is('get')) {
            if ($this->Auth->login()) {
                 
                return $this->redirect('/painel');
            }
        }
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $us = $this->Session->read('Auth.User');
                if ($us['st_registro'] == 'N') {
                    $this->_flash("Usuário inativo. Tente novamente!", 'error');
                }
                CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} efetuou o login; ', array('acesso'));
                $complete = $this->Session->read('Auth.User.complete');

                if ($complete == 'N') {
                    return $this->redirect('/users/users/complete/' . $this->Session->read('Auth.User.id'));
                }
                $role = $this->Session->read('Auth.User.role_id');
                if ($role != '1') {
                     $this->_flash('Olá '. $this->Session->read('Auth.User.name') .' seja bem-vindo(a)!', 'success', '/users/users/control/');
                }
                $this->_flash('Olá '. $this->Session->read('Auth.User.name') .' seja bem-vindo(a)!', 'success', '/painel');
            } else {
                CakeLog::write('erro', 'Tentativa de acesso negado do usuário {' . $this->request->data['User']['username'] . '} ; ', array('acesso'));
                $this->_flash("Usuário ou senha incorreta. Tente novamente!", 'error');
            }
        }
    }

    public function control() {
        $id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $this->layout = 'novo_control';
        if ($this->request->is('post')) {
            if ($this->data['User']['equipe_id'] != '0') {
                $nomeEquipe = $this->Equipe->find('first', array(
                    "fields" => array("nome"),
                    'conditions' => array('st_registro' => 'S', 'id' => $this->data['User']['equipe_id']),
                    'order' => array('nome')));
            } else {
                $nomeEquipe['Equipe']['nome'] = 'Administrador';
                $this->request->data['User']['equipe_id'] = '';
            }
            $this->Session->write('Equipe', $nomeEquipe['Equipe']['nome']);
            $this->Session->write('Equipe_id', $this->data['User']['equipe_id']);
            $this->redirect('/painel');
        }


        if ($role != '1') {
            $id_equipes = $this->Rluserequipe->find('all', array('conditions' => array('id_user' => $id, 'st_registro' => 'S'),
                "fields" => array("id_equipe")));
            if (count($id_equipes) == 1) {
                $dados_equipe = $this->Equipe->find('first', array(
                    "fields" => array("id", "nome"),
                    'conditions' => array('st_registro' => 'S', 'id' => $id_equipes[0]['Rluserequipe']['id_equipe']),
                    'order' => array('nome')));
                $this->Session->write('Equipe', $dados_equipe['Equipe']['nome']);
                $this->Session->write('Equipe_id', $dados_equipe['Equipe']['id']);
                $this->Session->write('Equipe_unica', '1');
                $this->redirect('/painel');
            }
            $equipes = array();
            if (!empty($id_equipes)) {
                foreach ($id_equipes as $key => $value) {
                    $arrEquipe[] = $value['Rluserequipe']['id_equipe'];
                }
                $equipes = $this->Equipe->find('list', array(
                    "fields" => array("id", "nome"),
                    'conditions' => array('st_registro' => 'S', 'id' => $arrEquipe),
                    'order' => array('nome')));
            }
        } else if ($role == '1') {
            $equipes = $this->Equipe->find('list', array(
                "fields" => array("id", "nome"),
                'conditions' => array('Equipe.st_registro' => 'S'),
                'order' => array('nome')));
            $equipes[0] = 'Administrador';
        }

        asort($equipes);
        $this->set('equipes', $equipes);
    }

    public function complete($id) {
        $this->layout = 'novo_control';
        if ($this->request->is('post') || $this->request->is('put')) {
            $userId = $this->Session->read('Auth.User.id');
            $u = $this->User->findById($userId);
            if (!$this->validaNovaSenha($this->data, $u['User']['password'])) {
                return;
            }
            $pass = AuthComponent::password($this->data['User']['password']);
            $this->request->data['User']['password'] = $pass;
            if ($this->User->save($this->request->data)) {

                CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} completou o cadastro.', array('usuario'));
                $role = $this->Session->read('Auth.User.role_id');

                if ($role != '1') {
                    $this->_flash('Perfil cadastrado com sucesso!', 'success');
                    return $this->redirect('/users/users/control/');
                }
                $this->_flash('Perfil cadastrado com sucesso!', 'success', '/painel/painel/');
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não completou o cadastro.', array('usuario'));
                $this->_flash('Perfil não foi cadastrado!', 'error', '/users/users/logout/');
            }
        } elseif ($id != null) {
            $this->User->id = $id;
            if (!$this->User->exists()) {
                $this->_flash('Usuário não existente no sistema.', 'error', '/users/users/logout');
            }
        }
    }

    public function logout() {
        CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} efetuou o logoff; ', array('acesso'));
        $this->Session->destroy();
        $this->redirect($this->Auth->logout());
    }

    public function index() {
        $this->layout = 'novo';
 


        
    }

    public function response() {
        $this->layout = '';
        $aColumns = array('id', 'name', 'username', 'role_id', 'email');
        $sTable = 'users';
        $aConditions = ' st_registro = "S" ';
        $this->autoRender = false;
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions);
        $output['aaData'] = $this->retornaGrid($output['aaData']);
        echo json_encode($output);
    }

    public function retornaGrid($aaData) {
        $data = array();
        foreach ($aaData as $value) {
            $value[3] = \Dominio\Perfil::getPerfilById($value[3]);
            $data[] = $value;
        }
        return $data;
    }

    public function add($param = null) {
        $this->layout = 'novo';

        if ($this->request->is('post') || $this->request->is('put')) {


            $tipoCadastro = $this->request->data['User']['tipoCadastro'];


            $this->set('cadastro', $tipoCadastro);
            if ($tipoCadastro == 'alterar' || $tipoCadastro == 'alterar_admin' || $tipoCadastro == 'alterar_admin_auto' || $tipoCadastro == 'alterar_analista_auto') {
                
                $this->User->id = $this->request->data['User']['id'];
                $u = $this->User->findById($this->request->data['User']['id']);
                if(!empty($this->data['reset'])){
                    if (!$this->validaNovaSenha($this->data, $u['User']['password'])) {
                        return;
                    }
                    $pass = AuthComponent::password($this->data['User']['password']);
                    $this->request->data['User']['password'] = $pass;
                }

            }

            if (empty($this->data['User']['id'])) {
               
                if ($tipoCadastro == 'novo') {
                    if (!$this->validaNovaSenha($this->data, $u['User']['password'])) {
                        return;
                    }
                    $pass = AuthComponent::password($this->data['User']['password']);
                    $this->request->data['User']['password'] = $pass;
                    $this->request->data['User']['complete'] = 'N';
                    $usernameValid = $this->User->find('first', array('conditions' => array('username' => $this->request->data['User']['username'], 'st_registro' => 'S')));
                    $emailValid = $this->User->find('first', array('conditions' => array('email' => $this->request->data['User']['email'], 'st_registro' => 'S')));

                    if (!empty($usernameValid)) {
                        $this->_flash('Já existe um perfil com este Usuario. Favor tente novamente!', 'error');
                        return;
                    }
                    if (!empty($emailValid)) {
                        $this->_flash('Já existe um perfil com este Email. Favor tente novamente!', 'error');
                        return;
                    }
                }

            }
            if (!$this->validaNovaSenha($this->data, $u['User']['password'])) {
                return;
            }else{
                $pass = AuthComponent::password($this->data['User']['password']);
                $this->request->data['User']['password'] = $pass;
            }

            if ($this->User->save($this->request->data)) {

                if ($tipoCadastro == 'novo') {
                    CakeLog::write('sucesso', 'Usuário  {' . $this->Session->read('Auth.User.username') . '} adicionou o usuário  {' . $this->request->data['User']['username'] . '}  .', array('equipe'));
                    $this->_flash('Usuário cadastrado com sucesso!', 'success', '/users');
                } else if ($tipoCadastro == 'alterar_admin' || $tipoCadastro == 'alterar_admin_auto') {
                    CakeLog::write('sucesso', 'Usuário  {' . $this->Session->read('Auth.User.username') . '} alterou seus dados.', array('equipe'));
                    $this->_flash('Usuário alterado com sucesso!', 'success', '/users');
                } else if ($tipoCadastro == 'alterar_analista_auto') {
                    CakeLog::write('sucesso', 'Usuário  {' . $this->Session->read('Auth.User.username') . '} alterou seus dados.', array('equipe'));
                    $this->_flash('Usuário alterado com sucesso!', 'success', '/painel');
                }
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->request->data['User']['username'] . '} não foi cadastro.', array('usuario'));
                CakeLog::write('erro', 'Usuário {' . $this->request->data['User']['username'] . '} não foi adicionado a nenhuma equipe.', array('equipe'));
                $this->_flash('Usuário não foi cadastrado!', 'error', '/users');
            }
        } elseif ($param == 'user') {
            $this->User->id = $this->Session->read('Auth.User.id');
            if (!$this->User->exists()) {
                $this->_flash('Usuário não existente no sistema.', 'error', '/painel');
            }
            if ($this->Session->read('Auth.User.role_id') == '1') {
                $this->set('cadastro', 'alterar_admin_auto');
            } elseif ($this->Session->read('Auth.User.role_id') == '2') {
                $this->set('cadastro', 'alterar_analista_auto');
            }
            $this->request->data = $this->User->read();

           
        } elseif ($param) {
            if ($this->Session->read('Auth.User.role_id') == '2') {
                $this->_flash('Sem permissão para alterar.', 'error', '/painel');
            }
            $this->User->id = $param;
            if (!$this->User->exists()) {
                $this->_flash('Usuário não existente no sistema.', 'error', '/painel');
            }
            $this->request->data = $this->User->read();
            $this->set('cadastro', 'alterar_admin');
        } else {
            $this->set('cadastro', 'novo');
        }
    }

    public function delete($id) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->_flash('Usuário não existente no sistema.', 'error', '/users/users/');
        }
        $this->User->read('st_registro', $id);
        $nomeUsuario = $this->User->find('first', array('conditions' => array('id' => $id), 'fields' => array('username')));
        $this->User->set(array(
            'st_registro' => 'N',
        ));
        $idRlUser = $this->Rluserequipe->find('list', array('conditions' => array('id_user' => $id), 'fields' => array('id')));



        if ($this->User->save()) {


            if (!empty($idRlUser)) {
                foreach ($idRlUser as $k) {
                    $this->Rluserequipe->read('st_registro', $k);
                    $this->Rluserequipe->set(array(
                        'st_registro' => 'N',
                    ));
                    $this->Rluserequipe->save();
                }
            }

            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou o usuário {' . $nomeUsuario['User']['username'] . '}  .', array('usuario'));
            $this->_flash('Usuário foi deletado com sucesso.', 'success', '/users/users/');
        } else {
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar o usuário {' . $nomeUsuario['User']['username'] . '}  .', array('usuario'));
            $this->_flash('Usuário não foi deletado.', 'error', '/users/users/');
        }
    }


    public function reset($token, $type = null) {
        $this->layout = 'novo_recuperar';
        if(!empty($type)){
            $u = $this->User->findById($token);
            $this->User->id = $u['User']['id'];
            $this->User->data['User']['complete'] = 'N';
            if ($this->User->save($this->User->data)) {
                $this->_flash('Senha resetada com sucesso!', 'success', '/users');
            }
        }

        if (!empty($token) && empty($type) ) {
            $u = $this->User->findBytoken($token);
            if ($u) {
                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {
                    if (!$this->validaNovaSenha($this->data, $u['User']['password'])) {
                        return;
                    }
                    $this->User->data = $this->data;
                    $new_hash = sha1($u['User']['username'] . rand(0, 30)); //created token
                    $this->User->data['User']['token'] = $new_hash;
                    $pass = AuthComponent::password($this->data['User']['password']);

                    $this->User->data['User']['password'] = $pass;
                    if ($this->User->save($this->User->data)) {
                        $this->_flash('Senha alterada com sucesso!', 'success', '/login');
                    }
                }
            } else {
                $this->_flash('Não foi possível recuperar senha. Tente novamente!', 'error', '/login');
                return;
            }
        }
    }
    public function recover($param = null) {
        $this->layout = 'novo_recuperar';
        if ($this->request->is('post') || $this->request->is('put')) {
            if (empty($this->data['User']['email']) && empty($this->data['User']['usuario'])) {
                $this->_flash('Informe o email ou o usuário. Tente novamente!', 'error');
                return;
            }
            if (!empty($this->data['User']['email'])) {
                $validaEmail = $this->User->find('first', array('conditions' => array('email' => $this->data['User']['email'], 'st_registro' => 'S')));
                if (empty($validaEmail)) {
                    $this->_flash('Email não encontrado. Tente novamente!', 'error');
                    return;
                }
            } else {
                $validaUser = $this->User->find('first', array('conditions' => array('username' => $this->data['User']['usuario'], 'st_registro' => 'S')));
                if (empty($validaUser)) {
                    $this->_flash('Usuário não encontrado. Tente novamente!', 'error');
                    return;
                }
                $validaEmail = $validaUser;
            }

            $key = Security::hash(String::uuid(), 'sha512', true);
            $hash = sha1($validaEmail['User']['username'] . rand(0, 100));
            $url = Router::url(array('controller' => 'users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
            $ms = $url;
            $ms = wordwrap($ms, 1000);
            $validaEmail['User']['token'] = $key;
            $this->User->id = $validaEmail['User']['id'];
            if ($this->User->saveField('token', $validaEmail['User']['token'])) {

                $msg = "<p>Olá, clique no link abaixo para renovar sua senha. </p><br/>"
                    . " <a href='" . $ms . "'>Clique aqui para resetar a senha</a><br/>";

                $Email = new CakeEmail();
                $Email->template('default', 'default')
                    ->emailFormat('html')
                    ->to($validaEmail['User']['email'])
                    ->from(array('apfbr@analisebr.com.br' => 'APFBr Sistema de Ponto de Função'))
                    ->subject('APFBr - Solicitação de Recuperação de Senha');


                try {
                    if ($Email->send($msg)) {
                        $this->_flash('Foi enviado um Link para recuperação de senha no seu email.', 'success', '/login');
                    }
                } catch (Exception $e) {

                    $this->_flash('Usuário cadastrado com sucesso!', 'success', '/users/users/recover/1');
                    CakeLog::write('erro', 'Usuário {' . $this->request->data['User']['username'] . '} : não foi possível enviar e-mail de cadastro.', array('usuario'));
                }


//============EndEmail=============//
            } else {
                $this->_flash('Não foi possível gerar o link. Tente novamente!', 'error');
                return;
            }
        } else {

            if ($param == '1') {
                $error = 'Não foi possível enviar e-mail de recuperação de senha para o usuário. Contacte serviço de infraestrutura para verificar'
                    . ' o funcionamento do envio de e-mails pelo Servidor. Favor tentar novamente!';

                $this->set('error', $error);
            }
        }
    }

    public function validaNovaSenha($dados) {
 
        if (strlen($dados['User']['password']) < 6) {
            $this->_flash('A senha precisa ter mais do que 6 digitos. Tente novamente!', 'error');
            return false;
        }

        return true;
        
    }

    public function contains($senha) {
        if (!preg_match('/^[a-z0-9 .\-]+$/i', $senha)) {
            return true;
        } else {
            return false;
        }
    }

}
