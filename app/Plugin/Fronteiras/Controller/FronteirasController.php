<?php

Class FronteirasController extends FronteirasAppController {

    public $uses = array('Fronteira', 'Sistemas.Sistema', 'Datatable', 'Analise');

    public function index()
    {
        $this->layout = 'novo';
    }

    public function response()
    {
        $this->layout = '';
        $aColumns = array('id', 'nome', 'descricao');
        $sTable = 'fronteiras';
        $aConditions = ' st_registro = "S" ';
        $this->autoRender = false;
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions);
        echo json_encode($output);
    }

    public function add($id = null)
    {
        $this->layout = 'novo';
        if ($this->request->is('post') || $this->request->is('put')) {
            //retirei o if para que toda alteraçao/adiçao de fronteira verifique a existencia de fronteira com mesmo nome, excetuando-se o caso de ser um salvamento sem alterações
            $validFronteira = $this->Fronteira->find('first', array('conditions' => array('nome' => $this->data['Fronteira']['nome'], 'st_registro' => 'S')));
            if (!empty($validFronteira) && $validFronteira['Fronteira']['id'] != $id) {
                $this->_flash('O nome dessa Fronteira já existe. Tente novamente!', 'error');
                return;
            }

            //recupera dados da fronteira antes da alteração para que exiba o valor antes e depois da alteração no log
            if (!empty($this->data['Fronteira']['id'])) {
                $guardaFronteira = $this->Fronteira->find('first', array('conditions' => array('id' => $this->data['Fronteira']['id'], 'st_registro' => 'S')));
            }

            if ($this->Fronteira->save($this->request->data)) {
                if (empty($this->data['Fronteira']['id'])) {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou a fronteira, Nome:\'' . $this->request->data['Fronteira']['nome'] . '\', Descrição:\'' . $this->request->data['Fronteira']['descricao'] . '\'.', array('fronteira'));
                    $this->_flash('Fronteira foi salva com sucesso.', 'success', '/fronteiras/fronteiras/');
                } else {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} alterou a fronteira, Nome:\'' . $guardaFronteira['Fronteira']['nome'] . '\' para \'' . $this->request->data['Fronteira']['nome'] . '\', Descrição:\'' . $guardaFronteira['Fronteira']['descricao'] . '\' para \'' . $this->request->data['Fronteira']['descricao'] . '\'.', array('fronteira'));
                    $this->_flash('Fronteira alterada com sucesso.', 'success', '/fronteiras/fronteiras/');
                }
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar a fronteira.', array('fronteira'));
                $this->_flash('Fronteira não foi salva.', 'error', '/fronteiras/fronteiras/');
            }
        } elseif ($id != null) {
            $this->Fronteira->id = $id;
            if (!$this->Fronteira->exists()) {
                $this->_flash('Fronteiras não existente no sistema.', 'error', '/fronteiras/fronteiras/');
            }
            $this->request->data = $this->Fronteira->read();
        }
    }

    public function delete($id)
    {
        $this->Fronteira->id = $id;
        if (!$this->Fronteira->exists()) {
            $this->_flash('Fronteira não existente no sistema.', 'error', '/fronteiras/fronteiras/');
        }
        $integridade = $this->Analise->find('first', array('conditions' => array('Analise.fronteira_id' => $id, 'Analise.st_registro' => 'S'), 'fields' => array('id')));
        if (!empty($integridade)) {
            $this->_flash('Fronteira não foi deletada pois está vinculada a uma análise.', 'error', '/fronteiras/fronteiras/');
        }
        $fronteira = $this->Fronteira->find('first', array('conditions' => array('id' => $id), 'fields' => array('nome')));
        $this->Fronteira->read('st_registro', $id);
        $this->Fronteira->set(array(
            'st_registro' => 'N',
        ));
        if ($this->Fronteira->save()) {
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou a fronteira, Nome:\'' . $fronteira['Fronteira']['nome'] . '\'.', array('fronteira'));
            $this->_flash('Fronteira foi deletada com sucesso.', 'success', '/fronteiras/fronteiras/');
        } else {
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar a fronteira \'' . $fronteira['Fronteira']['nome'] . '\'.', array('fronteira'));
            $this->_flash('Fronteira não foi deletada.', 'error', '/fronteiras/fronteiras/');
        }
    }

}
