<?php

Class ItensController extends ItensAppController {

    public $uses = array('Itens.Item', 'Sistemas.Sistema', 'Datatable', 'Rlitensanalise', 'Contratos.Contrato');

    public function index()
    {
        $this->layout = 'novo';
    }

    public function response()
    {
        $this->layout = '';
        $aColumns = array("id", "nome", "descricao", "valor_pf");
        $sTable = 'items';
        $aConditions = ' st_registro = "S" ';
        $this->autoRender = false;
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions);
       

        $output['aaData'] = $this->retornaGridList($output['aaData'], $output['sEcho']);
     

        echo json_encode($output);
    }
    
    public function retornaGridList($aaData, $sEcho)
    {
        
        
          
        
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

            $validItem = $this->Item->find('first', array('conditions' => array('nome' => $this->data['Item']['nome'], 'st_registro' => 'S')));
            if (!empty($validItem) && $validItem['Item']['id'] != $id) {
                $this->_flash('O nome desse Item já existe. Tente novamente!', 'error');
                return;
            }

            if (!empty($this->data['Item']['id'])) {
                $guardaItem = $this->Item->find('first', array('conditions' => array('id' => $this->data['Item']['id'], 'st_registro' => 'S')));
            } 
             
       
            unset($this->request->data['contratos']);
            if ($this->Item->save($this->request->data)) {
                if (empty($this->data['Item']['id'])) {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou o Item não mensurável, Nome:\'' . $this->request->data['Item']['nome'] . '\', Descrição:\'' . $this->request->data['Item']['descricao'] . '\', Valor PF:\'' . $this->request->data['Item']['valor_pf'] . '\'.', array('item'));
                    $this->_flash('Item foi salvo com sucesso.', 'success', '/itens/itens/');
                } else {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} alterou o Item não mensurável, Nome:\'' . $guardaItem['Item']['nome'] . '\' para \'' . $this->request->data['Item']['nome'] . '\', Descrição:\'' . $guardaItem['Item']['descricao'] . '\' para \'' . $this->request->data['Item']['descricao'] . '\', Valor PF:\'' . $guardaItem['Item']['valor_pf'] . '\' para \'' . $this->request->data['Item']['valor_pf'] . '\'.', array('item'));
                    $this->_flash('Item foi alterado com sucesso.', 'success', '/itens/itens/');
                }
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar o Item não mensurável.', array('item'));
                $this->_flash('Item não foi salvo.', 'error', '/itens/itens/');
            }
        } elseif ($id != null) {
            $integridade = $this->Item->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S')));
            if (empty($integridade)) {
                $this->_flash('Item não existente no sistema.', 'error', '/itens/itens/');
            }
            $this->Item->id = $id;
            $this->request->data = $this->Item->read();
            
             
      
        }   
         
    }

    public function delete($id)
    {
        $this->Item->id = $id;
        $integridade = $this->Rlitensanalise->find('first', array('conditions' => array('item_id' => $id, 'st_registro' => 'S')));
        
        if (!empty($integridade)) {
            $this->_flash('Este Item está relacionado a uma Análise/Funcionalidade, impossível deletar.', 'error', '/itens/itens/');
        }
        $nomeItem = $this->Item->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S'), 'fields' => array('nome')));
        $this->Item->read('st_registro', $id);
        $this->Item->set(array(
            'st_registro' => 'N',
        ));
        if ($this->Item->save()) {
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou o Item não mensurável : ' . $nomeItem['Item']['nome'] . '.', array('item'));
            $this->_flash('Item foi deletada com sucesso.', 'success', '/itens/itens/');
        } else {
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar o Item não mensurável : ' . $nomeItem['Item']['nome'] . '.', array('item'));
            $this->_flash('Item não foi deletada.', 'error', '/itens/itens/');
        }
    }

}
