<?php

Class UstsController extends UstsAppController {

    public $uses = array('Usts.Ust', 'Sistemas.Sistema', 'Datatable', 'Rlustsanalise', 'Contrato');

    public function index()
    {
        $this->layout = 'novo';
    }

    public function response()
    {
        $this->layout = '';
        $aColumns = array("id", "nome", "descricao", "valor_pf");
        $sTable = 'usts';
        $aConditions = ' st_registro = "S" ';
        $this->autoRender = false;
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions);
       

        $output['aaData'] = $this->retornaGridList($output['aaData'], $output['sEcho']);
     

        echo json_encode($output);
    }
    
    public function retornaGridList($aaData, $sEcho)
    {
        $data =array();
        $aux = ($sEcho * 10) - 9;
       
        foreach ($aaData as $value) {
            $v[0] = $aux;
            $v[1] = $value[0];
            $v[2] = $value[1];
            $v[3] = $value[2];
            $v[4] = $value[3];
           
            $data[] = $v;
            $aux ++;
        }
        return $data;
    }

    public function add($id = null)
    {
        $this->layout = 'novo';
        $contratos = $this->Contrato->find('list', array(
                "fields" => array("id", "identificador_contrato", "nome_empresa"),
                'conditions' => array('Contrato.st_registro' => 'S'),
                'order' => array('Contrato.identificador_contrato')));
            //($contratos);exit;
        $this->set('contratos', $contratos);
        if ($this->request->is('post') || $this->request->is('put')) {

            $validItem = $this->Ust->find('first', array('conditions' => array('nome' => $this->data['Ust']['nome'], 'st_registro' => 'S')));
            if (!empty($validItem) && $validItem['Ust']['id'] != $id) {
                $this->_flash('O nome dessa UST já existe. Tente novamente!', 'error');
                return;
            }

            if (!empty($this->data['Ust']['id'])) {
                $guardaItem = $this->Ust->find('first', array('conditions' => array('id' => $this->data['Ust']['id'], 'st_registro' => 'S')));
            } 
            
            if ($this->Ust->save($this->request->data)) {
                if (empty($this->data['Ust']['id'])) {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou a UST, Nome:\'' . $this->request->data['Ust']['nome'] . '\', Descrição:\'' . $this->request->data['Ust']['descricao'] . '\', Valor PF:\'' . $this->request->data['Ust']['valor_pf'] . '\'.', array('ust'));
                    $this->_flash('UST foi salva com sucesso.', 'success', '/usts/usts/');
                } else {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} alterou a UST, Nome:\'' . $guardaItem['Ust']['nome'] . '\' para \'' . $this->request->data['Ust']['nome'] . '\', Descrição:\'' . $guardaItem['Ust']['descricao'] . '\' para \'' . $this->request->data['Ust']['descricao'] . '\', Valor PF:\'' . $guardaItem['Ust']['valor_pf'] . '\' para \'' . 
                            $this->request->data['Ust']['valor_pf'] . '\'.', array('ust'));
                    $this->_flash('UST foi alterada com sucesso.', 'success', '/usts/usts/');
                }
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar a UST.', array('ust'));
                $this->_flash('UST não foi salva.', 'error', '/usts/usts/');
            }
        } elseif ($id != null) {
            $integridade = $this->Ust->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S')));
            if (empty($integridade)) {
                $this->_flash('UST não existente no sistema.', 'error', '/usts/usts/');
            }
            $this->Ust->id = $id;
            $this->request->data = $this->Ust->read();
        }
    }

    public function delete($id)
    {
        $this->Ust->id = $id;
        $integridade = $this->Rlustsanalise->find('first', array('conditions' => array('ust_id' => $id, 'st_registro' => 'S')));
        
        if (!empty($integridade)) {
            $this->_flash('Esta UST está relacionado a uma Análise/Funcionalidade, impossível deletar.', 'error', '/usts/usts/');
        }
        $nomeItem = $this->Ust->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S'), 'fields' => array('nome')));
        $this->Ust->read('st_registro', $id);
        $this->Ust->set(array(
            'st_registro' => 'N',
        ));
        if ($this->Ust->save()) {
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou a UST : ' . $nomeItem['Ust']['nome'] . '.', array('ust'));
            $this->_flash('UST foi deletada com sucesso.', 'success', '/usts/usts/');
        } else {
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar o UST : ' . $nomeItem['Ust']['nome'] . '.', array('ust'));
            $this->_flash('UST não foi deletada.', 'error', '/usts/usts/');
        }
    }

}
