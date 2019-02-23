<?php

Class FasesController extends FasesAppController {

    public $uses = array('Fase', 'Sistemas.Sistema', 'Datatable', 'Analise');

    public function index()
    {
        $this->layout = 'novo';
    }

    public function response()
    {
        $this->layout = '';
        $aColumns = array('id', 'nome');
        $sTable = 'fases';
        $aConditions = ' st_registro = "S" ';
        $this->autoRender = false;
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions);
        echo json_encode($output);
    }

    public function add($id = null)
    {
        $this->layout = 'novo';
        if ($this->request->is('post') || $this->request->is('put')) {
            $validFase = $this->Fase->find('first', array('conditions' => array('nome' => $this->data['Fase']['nome'], 'st_registro' => 'S')));
            if (!empty($validFase)) {
                $this->_flash('O nome dessa Fase já existe. Tente novamente!', 'error');
                return;
            }
            //recupera dados da fase antes da alteração para que exiba o valor antes e depois da alteração no log
            if (!empty($this->data['Fase']['id'])) {
                $guardaFase = $this->Fase->find('first', array('conditions' => array('id' => $this->data['Fase']['id'], 'st_registro' => 'S')));
            }

            if ($this->Fase->save($this->request->data)) {
                if (empty($this->data['Fase']['id'])) {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou a fase : \'' . $this->request->data['Fase']['nome'] . '\'.', array('fase'));
                    $this->_flash('Fase foi salva com sucesso.', 'success', '/fases/fases/');
                } else {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} alterou a fase \'' . $guardaFase['Fase']['nome'] . '\' para \'' . $this->request->data['Fase']['nome'] . '\'.', array('fase'));
                    $this->_flash('Alteração de Fase foi salva com sucesso.', 'success', '/fases/fases/');
                }
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar a fase.', array('fase'));
                $this->_flash('Fase não foi salva.', 'error', '/fases/fases/');
            }
        } elseif ($id != null) {
            $integridade = $this->Fase->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S')));
            if (empty($integridade)) {
                $this->_flash('Fase não existente no sistema.', 'error', '/fases/fases/');
            }
            $this->Fase->id = $id;
            $this->request->data = $this->Fase->read();
        }
    }

    public function delete($id)
    {
        $fase = $this->Fase->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S'), 'fields' => array('nome')));
        if (empty($fase)) {
            $this->_flash('Fase não existente no sistema.', 'error', '/fases/fases/');
        }
        $integridade = $this->Analise->find('first', array('conditions' => array('Analise.fase_id' => $id, 'Analise.st_registro' => 'S'), 'fields' => array('id')));
        if (!empty($integridade)) {
            $this->_flash('Fase não foi deletada pois está vinculada a uma análise.', 'error', '/fases/fases/');
        }
        $this->Fase->id = $id;
        $this->Fase->read('st_registro', $id);
        $this->Fase->set(array(
            'st_registro' => 'N',
        ));
        if ($this->Fase->save()) {
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou a fase : \'' . $fase['Fase']['nome'] . '\'.', array('fase'));
            $this->_flash('Fase foi deletada com sucesso.', 'success', '/fases/fases/');
        } else {
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar a fase : ' . $fase['Fase']['nome'] . '.', array('fase'));
            $this->_flash('Fase não foi deletada.', 'error', '/fases/fases/');
        }
    }

}
