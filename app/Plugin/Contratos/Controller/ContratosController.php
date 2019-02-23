<?php

Class ContratosController extends ContratosAppController {

    public $uses = array('Contratos.Contrato', 
        'Datatable', 'Baseline', 'Analises.Analise', 'Equipe', 'Funcionalidade', 'Tdstrsar', 'Deflatore', 'Rlcontratometodo', 'Rlcontratoequipe');

    public function index() {

        $this->layout = 'novo';
    }

    public function add($id = null) {
        $this->layout = 'novo';
                
        $equipe = $this->Equipe->find('all', array('conditions' => array('st_registro' => 'S'), 'fields' => array('id', 'nome'), 'order' => array('nome ASC'),));
        $resultEquipe = array();
        foreach ($equipe as $value) {
            $equipes['id'] = $value['Equipe']['id']; 
            $equipes['nome'] = $value['Equipe']['nome']; 
            $resultEquipe[] = $equipes;
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
        if(!empty($id)){
            $rlcontratometodo = $this->Rlcontratometodo->find('all', array('conditions' => array('id_contrato' => $id, 'st_registro' => 'S')));
            $rlcontratoequipe = $this->Rlcontratoequipe->find('all', array('conditions' => array('id_contrato' => $id, 'st_registro' => 'S')));
        }   
        if ($this->request->is('post') || $this->request->is('put')) {
           
            $validContrato = $this->Contrato->find('first', array('conditions' => array('identificador_contrato' => $this->data['Contrato']['identificador_contrato'], 'st_registro' => 'S')));
            if (!empty($validContrato) && $validContrato['Contrato']['id'] != $id) {
                $this->_flash('O nome desse Contrato já existe. Tente novamente!', 'error');
                return;
            } 
           
            if ($this->Contrato->save($this->request->data)) {
                
                $id_contrato = $this->Contrato->id;
                
                $prepare = array();
                
                $resulContratoMetodo = Array();
                if(!empty($rlcontratometodo)){
                    foreach ($rlcontratometodo as $value) {  
                        $prepare['Rlcontratometodo']['id'] = $value['Rlcontratometodo']['id'];
                        $prepare['Rlcontratometodo']['st_registro'] =  'N';
                        $resulContratoMetodo[] = $prepare;
                    } 
                }
                $prepare = array();
                foreach ($this->data['Metodo'] as $key => $value) {
                   
                    if ($value == '1') { 
                        $prepare['Rlcontratometodo']['id_contrato'] = $id_contrato;
                        $prepare['Rlcontratometodo']['st_registro'] =  'S';
                        $id = explode('-', $key); 
                        $prepare['Rlcontratometodo']['metodo'] = $id[1];
                        $resulContratoMetodo[] = $prepare;
                    }
                } 
                $this->Rlcontratometodo->create();
                $this->Rlcontratometodo->saveMany($resulContratoMetodo);
                $resulContratoEquipe = array(); 
                $prepare = array();
                if(!empty($rlcontratoequipe)){
                    foreach ($rlcontratoequipe as $value) { 
                        $prepare['Rlcontratoequipe']['id'] = $value['Rlcontratoequipe']['id'];
                        $prepare['Rlcontratoequipe']['st_registro'] =  'N';
                        $resulContratoEquipe[] = $prepare;
                    }  
                }
                $prepare = array();
                foreach ($this->data['Equipe']['Td'] as $key => $valor) { 
                    if ($valor == '1') { 
                        $prepare['Rlcontratoequipe']['id_contrato'] = $id_contrato;
                        $id = explode('-', $key);
                        $prepare['Rlcontratoequipe']['st_registro'] =  'S';
                        $prepare['Rlcontratoequipe']['id_equipe'] = $id[1];
                        $resulContratoEquipe[] = $prepare;
                    }
                } 
                $this->Rlcontratoequipe->create(); 
                $this->Rlcontratoequipe->saveMany($resulContratoEquipe);
                
                if (empty($this->data['Contrato']['id'])) {
                  //  CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou o Sistema, Nome:\'' . $this->request->data['Contrato']['nome'] . '\', Sigla:\'' . $this->request->data['Sistema']['sigla'] . '\', Linguagem:\'' . $linguagems[$this->request->data['Sistema']['linguagem_id']] . '\', Descrição:\'' . $this->request->data['Sistema']['descricao'] . '\'.', array('sistema'));
                    $this->_flash('Contrato cadastrado com sucesso!', 'success', '/contratos/contratos/index/');
                } else {
                   // CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} alterou o Sistema, Nome:\'' . $guardaContrato['Contrato']['nome'] . '\' para \'' . $this->request->data['Sistema']['nome'] . '\', Sigla:\'' . $guardaSistema['Sistema']['sigla'] . '\' para \'' . $this->request->data['Sistema']['sigla'] . '\', Linguagem:\'' . $linguagems[$guardaSistema['Sistema']['linguagem_id']] . '\' para \'' . $linguagems[$this->request->data['Sistema']['linguagem_id']] . '\', Descrição:\'' . $guardaSistema['Sistema']['descricao'] . '\' para \'' . $this->request->data['Sistema']['descricao'] . '\'.', array('sistema'));
                    $this->_flash('Contrato alterado com sucesso!', 'success', '/contratos/contratos/index/');
                }
            } else {
             //   CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar a Sistema.', array('sistema'));
                $this->_flash('Contrato não foi cadastrado!', 'error', '/contratos/contratos/add/');
            }
        } elseif ($id != null) {
            $sistema = $this->Contrato->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S'), 'fields' => 'identificador_contrato'));
            if (empty($sistema)) {
                $this->_flash('Contrato não existente.', 'error', '/contratos/contratos/');
            }
            $this->Contrato->id = $id;
            $this->request->data = $this->Contrato->read();
        
            foreach($rlcontratometodo as $value){ 
                if($value['Rlcontratometodo']['metodo'] == '1'){ 
                    $this->set('validDetalhada', true); 
                }
                if($value['Rlcontratometodo']['metodo'] == '2'){
                    $this->set('validEstimada', true); 
                }
                if($value['Rlcontratometodo']['metodo'] == '3'){
                    $this->set('validIndicativa', true); 
                }
            }
            $this->set('equipecontrato', $rlcontratoequipe); 
         
        }
    }
    
    public function response() {


        $this->layout = '';
        $aColumns = array("id", "identificador_contrato", "nome_empresa", "dt_inicio_contrato", "dt_fim_contrato", "valor_pf");
        $sTable = 'contratos';
        $aConditions = ' st_registro = "S" ';
        $this->autoRender = false;
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions);

        echo json_encode($output);
    }

   

    public function delete($id) {
        $contrato = $this->Contrato->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S'), 'fields' => 'id'));
        if (empty($contrato)) {
            $this->_flash('Contrato não existente no sistema.', 'error', '/contratos/contratos/');
        }
        $this->Contrato->id = $id;

       /* $integridade = $this->Rluserequipe->find('first', array('conditions' => array('Rluserequipe.id_equipe' => $id, 'Rluserequipe.st_registro' => 'S'), 'fields' => array('id')));
        if (!empty($integridade)) {
            $this->_flash('Equipe não foi deletada pois contém usuários.', 'error', '/equipes/equipes/');
        }*/

        $this->Contrato->read('st_registro', $id);
        $this->Contrato->set(array(
            'st_registro' => 'N',
        ));
        if ($this->Contrato->save()) {
           // CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou a equipe : ' . $equipe['Equipe']['nome'] . '.', array('equipe'));
            $this->_flash('Contrato foi deletado com sucesso.', 'success', '/contratos/contratos/');
        } else {
         //   CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar a equipe : ' . $equipe['Equipe']['nome'] . '.', array('equipe'));
            $this->_flash('Contrato não foi deletado.', 'error', '/contratos/contratos/');
        }
    }
                   
}
