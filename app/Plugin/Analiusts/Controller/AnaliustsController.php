<?php

Class AnaliustsController extends AnaliustsAppController {

    /**
     * Load Class Models
     * @var type $uses
     */
    public $uses = array('Analise', 'Analiust', 'Fases.Fase', 'Fronteiras.Fronteira', 'Datatable',
        'Sistemas.Sistema', 'Rluserequipe',
        'Associativa', 'Equipes.Equipe', 'Itens.Item', 'Usts.Ust', 'Rlustsanalise',
        'Rlitensanalise', 'Deflatores.Deflatore', 'Thanaliust',
        'Datalock', 'Users.User', 'Contratos.Contrato', 'Rlcontratometodo', 'Rlcontratoequipe');

    /**
     * Index Lista Análises
     */
    public function index() {
       $this->layout = 'novo'; 
        $userId = $this->Session->read('Auth.User.role_id');
        $todos   = array('0' =>' - Todos - ');
        $equipeId = $this->Session->read('Equipe_id');
        if ($userId == '1') {
            $equipes = $this->Equipe->find('list', array(
                "fields" => array("id", "nome"),
                'conditions' => array('Equipe.st_registro' => 'S'),
                'order' => array('Equipe.nome')));
            $adm[999999] = 'Administração';
            $equipes = array_replace ($todos,$adm, $equipes);  
        } else { 
            $equipes = $this->Equipe->find('list', array(
                "fields" => array("id", "nome"),
                'conditions' => array('Equipe.st_registro' => 'S', 'Equipe.id' => $equipeId),
                'order' => array('Equipe.nome'))); 
            $equipes = array_replace ($todos, $equipes);  
        } 
        $sistemas = $this->Sistema->find('list', array(
                "fields" => array("id", "sigla"),
                'conditions' => array('Sistema.st_registro' => 'S'),
                'order' => array('Sistema.sigla'))); 
        $sistemas = array_replace ($todos, $sistemas);  
        $contagens  = array(    '0' => ' - Todos - ',
                                '1' => 'Detalhada(IFPUG)',
                                '2' => 'Estimada(NESMA)',
                                '3' => 'Indicativa(NESMA)' 
        ); 
        $this->set('equipes', $equipes);
        $this->set('sistemas', $sistemas);
        $this->set('responsaveis', array(    '0' => ' - Todos - '));
        $this->set('contagens', $contagens);
    }
    
    public function carregaResponsavel($idEquipe){ 
        if($idEquipe == 999999 ){
            $listaAdmin = $this->User->find('list', array('conditions' => array(
                        'User.role_id' => 1, 'User.st_registro' => 'S' 
                    ),
                    'fields' => array('User.id', 'User.name'),
                    'order' => 'User.name' 
                    ));
            echo json_encode($listaAdmin);
        }else{
            $listaEquipe = $this->Rluserequipe->find('list', array(
               'joins' => array( 
                    array(
                       'table' => 'users',
                       'alias' => 'us',
                       'type' => 'INNER',
                       'conditions' => array(
                           'us.id = Rluserequipe.id_user'
                       )
                   )
               ),
               'conditions' => array(
                   'Rluserequipe.id_equipe' => $idEquipe, 'Rluserequipe.st_registro' => 'S' 
               ),
               'fields' => array('us.id', 'us.name'),
               'order' => 'us.name' 
               )); 
            echo json_encode($listaEquipe);
        } 
    }
    
    public function carregaMetodo($idContrato){ 
  
        $listaMetodo = $this->Rlcontratometodo->find('list', array(
           'joins' => array( 
                array(
                   'table' => 'contratos',
                   'alias' => 'con',
                   'type' => 'INNER',
                   'conditions' => array(
                       'con.id = Rlcontratometodo.id_contrato'
                   )
               )
           ),
           'conditions' => array(
               'Rlcontratometodo.id_contrato' => $idContrato, 'Rlcontratometodo.st_registro' => 'S' 
           ),
           'fields' => array('Rlcontratometodo.metodo', 'Rlcontratometodo.metodo'),
           'order' => 'Rlcontratometodo.metodo' 
           )); 
        echo json_encode($listaMetodo);
        
    }
    
    function atualizaBaseline($funcionalidade) {
        $baseline = $this->Baseline->find('first', array(
            'conditions' => array(
                'st_ultimo_registro' => 'S',
                'sistema_id' => $funcionalidade['Funcionalidade']['sistema_id']
        )));
        $updateBases['Baseline']['id'] = $baseline['Baseline']['id'];
        $updateBases['Baseline']['modified'] = date('Y-m-d H:i:s');
        $this->Baseline->save($updateBases);
    }
    
    /**
     * function delete - Inativa uma análise
     * @param type $id
     */
    public function duplicar($id) {      
        $analise = $this->Analiust->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S')));
         
        if (empty($analise)) {
            $this->_flash('Análise não existente no sistema.', 'error', '/analiusts/analiusts/');
        }  
        unset($analise['Analiust']['id']);
        unset($analise['Analiust']['created']);
        unset($analise['Analiust']['modified']);       
        $saveAnalise = $this->Analiust->save($analise); 
        if (!$saveAnalise) {
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu duplicar a  análise UST ID:' . $id . '.', array('analiust'));
            $this->_flash('Analise não foi duplicada!', 'error', '/analiusts/analiusts/');
        } else {
            //Apagar relacionamento dos INMs com a analise após exclusão da análise
            $rlItemAnalise = $this->Rlustsanalise->find('all', array('conditions' => array('analise_id' => $id, 'st_registro' => 'S')));
            if (!empty($rlItemAnalise)) {
                $updateRlAnalise = array();
                foreach ($rlItemAnalise as $key => $value) {
                    unset($value['Rlustsanalise']['id']);
                    unset($value['Rlustsanalise']['created']);
                    unset($value['Rlustsanalise']['modified']);
                    unset($value['Rlustsanalise']['analise_id']);
                    unset($value['Rlustsanalise']['user_id']);
                    $dataRl['Rlustsanalise']= $value['Rlustsanalise'];
                    $dataRl['Rlustsanalise']['analise_id'] = $saveAnalise['Analiust']['id'];
                    $dataRl['Rlustsanalise']['user_id'] = $this->Session->read('Auth.User.id');
                    $updateRlAnalise[] = $dataRl;
                }
                $this->Rlustsanalise->saveMany($updateRlAnalise);
            }
        }
     
        $this->duplicarUstsAnalise($saveAnalise['Analiust']['id'], $id);  
        CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} duplicou a  análise ID:' . $id . '.', array('analise'));
        $this->_flash('Analise duplicada com sucesso!', 'success', '/analiusts/analiusts/');
    } 
    
    /**
     * funtion duplicarItensAnalise - Duplicar Itens de uma análise alterando o valor de PFs da análise 
     * @param type $idAnalise
     * @param type $tipoFuncionalidade
     */
    public function duplicarUstsAnalise($idNovo, $idDuplicado) { 
        $rlItem = $this->Rlustsanalise->find('first', array('conditions' => array('analise_id' => $idDuplicado))); 
        foreach ($rlItem as $value) {      
            unset($value['Rlustsanalise']['id']);
            unset($value['Rlustsanalise']['created']);
            unset($value['Rlustsanalise']['modified']); 
            unset($value['Rlustsanalise']['analise_id']);
            unset($value['Rlustsanalise']['user_id']);
            $dataRlFunc = $value;  
            $dataRlFunc['Rlustsanalise']['analise_id'] = $idNovo; 
            $dataRlFunc['Rlustsanalise']['user_id'] = $this->Session->read('Auth.User.id'); 
            $updateRlFunc[] = $dataRlFunc;
        }
        if (!empty($updateRlFunc)) {
            $this->Rlustsanalise->saveMany($updateRlFunc);
        } 
    }
    
     

    /**
     * Adiciona a primeira etapa das análises
     */
    public function add() {
        $this->layout = 'novo';
         
        if ($this->data) { //recebe dados do POST
            $arrData = array();
            $arrData['Analiust']['equipe_id'] = $this->Session->read('Equipe_id');
            $arrData['Analiust']['sistema_id'] = $this->request->data['Analise']['sistema_id'];
            $arrData['Analiust']['st_registro'] = $this->request->data['Analise']['st_registro'];
            $this->Analiust->save($arrData);
            $idAnalise = $this->Analiust->getLastInsertID();
            $nomeSistemas = $this->Sistema->find('first', array(
                "fields" => array("nome"),
                'conditions' => array('Sistema.st_registro' => 'S', 'id' => $this->request->data['Analise']['sistema_id'])));
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} iniciou a análise ID: ' . $idAnalise . ' no sistema: ' . $nomeSistemas['Sistema']['nome'] . ' . ', array('analiust'));
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou a análise ID: ' . $idAnalise . ' no sistema: ' . $nomeSistemas['Sistema']['nome'] . ' . ', array('analiust'));
            $this->redirect('/analiusts/analiusts/analises/' . $idAnalise);
        } else { //carrega combobox quando a requisição for GET
            $sistemas = $this->Sistema->find('list', array(
                "fields" => array("id", "sigla"),
                'conditions' => array('Sistema.st_registro' => 'S'),
                'order' => array('Sistema.sigla')));
            $this->set('sistemas', $sistemas);
        }
    }

    /**
     * Adiciona as Informações gerais da Análise
     * @param type $id
     */
    public function analises($id = null) {
        //verifica se a análise existe, senão redireciona para a página inicial
        $exists = $this->Analiust->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S'), 'fields' => 
            array('id','id_contrato', 'metodo_contagem', 'nu_demanda', 'total_ust', 'baseline', 'sistema_id', 'fase_id', 'observacao')));
        if (empty($exists)) {
            $this->_flash('Análise não encontrada.', 'error', '/analiusts/analiusts/');
        }
        $this->dataLock($id);
        $this->Analiust->id = $id;
        $this->layout = 'novo';
        $this->set('analise', $exists);
        $fases = $this->Fase->find('list', array(
            "fields" => array("id",
                "nome"),
            'conditions' => array('st_registro' => 'S'),
            'order' => array('nome')
                )
        );
        $this->set('fases', $fases);
        
         $equipe = $this->Session->read('Equipe_id');
        
        if (empty($equipe)){
            $equipe = 'Rlcontratoequipe.id_equipe is not null ';
        }else{
            $equipe = 'Rlcontratoequipe.id_equipe => ' . $equipe;
        }
        $contratos = $this->Rlcontratoequipe->find('list', array(
           'joins' => array( 
                array(
                   'table' => 'contratos',
                   'alias' => 'con',
                   'type' => 'INNER',
                   'conditions' => array(
                       'con.id = Rlcontratoequipe.id_contrato'
                   )
               )
           ),
           'conditions' => array(
               'con.st_registro' => 'S', 'Rlcontratoequipe.st_registro' => 'S' ,  $equipe
           ),
           "fields" => array("con.id", "con.identificador_contrato", "con.nome_empresa"),
           'order' => array('con.identificador_contrato')
        )); 
             
        $this->set('contratos', $contratos);
        $arrMetodos = $this->Rlcontratometodo->find('list', array(
            "fields" => array('id', "metodo"),
            'conditions' => array('id_contrato' => $exists['Analiust']['id_contrato'],'st_registro' => 'S')
                )
        );
        $metodos = array();
        foreach($arrMetodos as $value){
            if($value == '1'){
                $metodos[1] = \Dominio\MetodoContagem::getMetodoById(1);
            }elseif($value == '2'){
                $metodos[2] = \Dominio\MetodoContagem::getMetodoById(2);
            }else{
                $metodos[3] = \Dominio\MetodoContagem::getMetodoById(3);
            }
        }
        
        $this->set('metodos', $metodos);
        // contar os pf das funcionalidades dados e transção
        $sistema = $this->Sistema->find('first', array(
            "fields" => array(
                "nome"),
            'conditions' => array('st_registro' => 'S', 'id' => $exists['Analiust']['sistema_id']),
            'order' => array('nome')
                )
        );
        $resumo['metodo_contagem'] = $exists['Analiust']['metodo_contagem'];
        $resumo['nu_demanda'] = $exists['Analiust']['nu_demanda'];
        $resumo['total_ust'] = $exists['Analiust']['total_ust'];
        $resumo['sistema'] = $sistema['Sistema']['nome'];
        $this->set('resumo', $resumo);
        if ($this->request->is('post') || $this->request->is('put')) {
            //SOMENTE Análise Detalhada entra no baseline e feita pelo administrador, 0 vai pro baseline e 1 não entra no baseline 
            $role = $this->Session->read('Auth.User.role_id');
            if ($this->request->data['Analiust']['metodo_contagem'] == '1' && $role == '1') {
                if ($this->request->data['Analiust']['baseline'] == '1') {
                    $this->controlaBaseline($this->request->data, 'U');
                    $this->request->data['Analiust']['baseline'] = 0;
                } else {
                    $this->request->data['Analiust']['baseline'] = 1;
                }
            } else {
                $this->request->data['Analiust']['baseline'] = 1;
            }
            if ($this->Analiust->save($this->request->data)) {
                // $this->getHeader($id);
                CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} alterou as Informações Gerais da análise ID:' . $id . '.', array('analiust'));
                $this->_flash('Análise foi salva.');
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu alterar as Informações Gerais da análise ID:' . $id . '.', array('analiust'));
                $this->_flash('Análise não foi salva.', 'error');
            }
        }
        $this->request->data = $this->Analiust->read();
        $exists = $this->Analiust->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S'), 'fields' => array('id', 'metodo_contagem', 'nu_demanda', 'total_ust', 'baseline', 'sistema_id', 'fase_id', 'observacao')));
        $this->set('analise', $exists);
    }

    /**
     * function delete - Inativa uma análise
     * @param type $id
     */
    public function delete($id) {
        $this->Analiust->id = $id;
        $analise = $this->Analiust->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S')));
        if (empty($analise)) {
            $this->_flash('Análise não existente no sistema.', 'error', '/analiusts/analiusts/');
        }
        $this->Analiust->read('st_registro', $id);
        $this->Analiust->set(array(
            'st_registro' => 'N',
            'baseline' => '1'
        ));
        $saveAnalise = $this->Analiust->save();
        if (!$saveAnalise) {
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar a  análise ID:' . $id . '.', array('analiust'));
            $this->_flash('Analise não foi deletada!', 'error', '/analiusts/analiusts/');
        } else {
            //Apagar relacionamento dos USTs com a analise após exclusão da análise
            $rlUstAnalise = $this->Rlustsanalise->find('all', array('conditions' => array('analise_id' => $id, 'st_registro' => 'S')));
            if (!empty($rlUstAnalise)) {
                $updateRlAnalise = array();
                foreach ($rlUstAnalise as $key => $value) {
                    $dataRl['Rlustsanalise']['id'] = $value['Rlustsanalise']['id'];
                    $dataRl['Rlustsanalise']['st_registro'] = 'N';
                    $updateRlAnalise[] = $dataRl;
                }
                $this->Rlustsanalise->saveMany($updateRlAnalise);
            }
        }
        CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou a  análise ID:' . $id . '.', array('analise'));
        $this->_flash('Analise deletada com sucesso!', 'success', '/analiusts');
    }

    public function usts($id = null) {
        $exists = $this->Analiust->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S'), 'fields' => array('id', 'id_contrato',
                                                        'metodo_contagem', 'nu_demanda', 'total_ust', 'baseline', 'sistema_id', 'fase_id', 'observacao')));
        if (empty($exists)) {
            $this->_flash('Análise não encontrada.', 'error', '/analiusts/analiusts/');
        }
        $this->Analiust->id = $id;
        $this->set('analise', $exists);
        $this->layout = 'novo'; 
        $items = $this->Ust->find('all', array(
            "fields" => array("id",
                "nome", 'valor_pf', 'descricao'),
            'order' => array('nome')
            ,
            'conditions' => array('Ust.st_registro' => 'S', 'Ust.id_contrato' => $exists['Analiust']['id_contrato'])
        ));
        $this->set('items', $items);
        $naomensuravel = $this->Rlustsanalise->find('all', array('conditions' => array(
                'st_registro' => 'S',
                'analise_id' => $id
        )));
        $this->set('naomensuravel', $naomensuravel);
        $nomeItens = $this->Ust->find('list', array('conditions' => array(
                'st_registro' => 'S'
            ),
            'fields' => array('id', 'nome')));
        $this->set('nomeItens', $nomeItens);
        $pesoItens = $this->Ust->find('list', array('conditions' => array(
                'st_registro' => 'S'
            ),
            'fields' => array('id', 'valor_pf')));
        $this->set('pesoItens', $pesoItens);
        $sistema = $this->Sistema->find('first', array(
            "fields" => array(
                "nome"),
            'conditions' => array('st_registro' => 'S', 'id' => $exists['Analiust']['sistema_id']),
            'order' => array('nome')
                )
        );
        $resumo['metodo_contagem'] = $exists['Analiust']['metodo_contagem'];
        $resumo['nu_demanda'] = $exists['Analiust']['nu_demanda'];
        $resumo['total_ust'] = $exists['Analiust']['total_ust'];
        $resumo['sistema'] = $sistema['Sistema']['nome'];
        $this->set('resumo', $resumo);
        if ($this->request->is('post') || $this->request->is('put')) {
            $retornaSaveUsts = $this->configItems($this->request->data['Rlustsanalise']['Ust'], $id);
            if ($retornaSaveUsts) {
                $saveItens = $this->Rlustsanalise->saveMany($retornaSaveUsts);
                $analise = $this->Analiust->find('first', array(
                    "fields" => array(
                        'id', 'total_ust'),
                    "conditions" => array('id' => $id)));
                $saveAnalise['Analiust']['id'] = $analise['Analiust']['id'];
                $saveAnalise['Analiust']['total_ust'] = $analise['Analiust']['total_ust'] + $this->calculaUsts($this->request->data['Rlustsanalise']['Ust']);
                $this->Analiust->save($saveAnalise);
                $this->data = array();
                if ($saveItens) {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou Itens a análise ID: {' . $id . '} . ', array('item'));
                    $this->_flash('USTs cadastrados com sucesso.', 'success', '/analiusts/analiusts/usts/' . $id);
                } else {
                    CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar Itens a análise ID: {' . $id . '} . ', array('item'));
                    $this->_flash('USTs não foram cadastrados.', 'error', '/analiusts/analiusts/usts/' . $id);
                }
            }
        }
    }

    /**
     * response - retorna grid de listagem
     */
    public function response() {
         
        
        $this->layout = '';
        $aColumns = array(
            "id",
            "status",
            "sistema_id",
            "nu_demanda",
            "user_id",
            "equipe_id",
            "metodo_contagem",
            "total_ust",
            "created",
            "baseline"
        );
        $sTable = 'analiusts';
        $this->autoRender = false;
        $role = $this->Session->read('Auth.User.role_id');
        $equipe = $this->Session->read('Equipe_id');
        $aConditions = '';
        if ($role != '1') {
            $aConditions .= ' AND equipe_id =  ' . $equipe;
        } elseif ($role == '1' && !empty($equipe)) {
            $aConditions .= ' AND equipe_id =  ' . $equipe;
        }
 
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions, 'lista_analises_usts');
        $output['aaData'] = $this->retornaGrid($output['aaData']);
        echo json_encode($output);
    }

    /**
     * dataLock - Bloqueia a Análise ou verifica se ela está bloqueada
     * @param type $id
     * @param type $status
     */
    public function dataLock($id, $status = null) {
        if ($this->Session->read('Auth.User.role_id') != '1') {
            $equipeUser = $this->Session->read('Equipe_id');
            $verificaAnaliseEquipe = $this->Analiust->find('first', array('conditions' => array('id' => $id)));

            if ($verificaAnaliseEquipe['Analiust']['equipe_id'] != $equipeUser) {
                $this->_flash('Você não tem permissão para acessar essa análise.', 'error', '/analiusts/analiusts');
                return;
            }
        }
        $datalock = $this->Datalock->find('first', array('conditions' => array(
                'Datalock.analise_id' => $id,
                'Datalock.st_registro' => 'S',
                'Datalock.tipo' => 'U')));
        if (!$status) {
            if (empty($datalock)) {
                $data['Datalock']['analise_id'] = $id;
                $data['Datalock']['st_registro'] = 'S';
                $data['Datalock']['user_id'] = $this->Session->read('Auth.User.id');
                $data['Datalock']['lock'] = 'S';
                $data['Datalock']['tipo'] = 'U';
                $this->Datalock->save($data);
            } else {
                if ($datalock['Datalock']['st_registro'] == 'S' && $datalock['Datalock']['user_id'] != $this->Session->read('Auth.User.id')) {
                    $this->_flash('A análise foi acessada por outro usuário, impossível acessar neste momento.', 'error', '/analiusts/analiusts');
                } else {
                    $data['Datalock']['id'] = $datalock['Datalock']['id'];
                    $data['Datalock']['st_registro'] = 'N';
                    $data['Datalock']['lock'] = 'N';
                    $data['Datalock']['tipo'] = 'U';
                    $this->Datalock->save($data);
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} bloqueou análise ID: {' . $id . '} . ', array('analiust'));
                }
            }
         } else if ($status == 'desbloquear') {

            $data['Datalock']['id'] = $datalock['Datalock']['id'];
            $data['Datalock']['st_registro'] = 'N';
            $data['Datalock']['lock'] = 'N';
            $data['Datalock']['tipo'] = 'U';
            $this->Datalock->save($data);
            $this->createHistory($id);
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} desbloqueou análise ID: {' . $id . '} . ', array('analiust'));
            $this->_flash('A análise foi desbloqueada.', 'success', '/analiusts/analiusts');
        
        } else {
            $data['Datalock']['id'] = $datalock['Datalock']['id'];
            $data['Datalock']['st_registro'] = 'N';
            $data['Datalock']['lock'] = 'N';
            $data['Datalock']['tipo'] = 'U';
            $this->Datalock->save($data);
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} desbloqueou análise ID: {' . $id . '} . ', array('analiust'));
            $this->_flash('A análise foi desbloqueada.', 'success', '/analiusts/analiusts');
        }
    }

    /**
     * checkLock - Busca análise bloqueada
     * @param type $id
     * @return type
     */
    public function checkLock($id) {
        $datalock = $this->Datalock->find('first', array('conditions' => array(
                'Datalock.analise_id' => $id,
                'Datalock.st_registro' => 'S',
                'Datalock.tipo' => 'U'
            ), 'fields' => 'user_id'));
        return $datalock;
    }

    /**
     * Relatorio da Análise
     * @param type $id
     */
    public function relatorio($id, $acao = 0) {
        if ($acao == 1) {
            $this->layout = 'novo_impressao';
        } else
        if ($acao == 2) {
            $this->layout = 'novo_impressao';
        } else {
            $this->layout = 'novo';
        }
        $nomeUsts = $this->Ust->find('list', array('conditions' => array(
                'st_registro' => 'S'
            ),
            'fields' => array('id', 'nome')));
        $this->set('nomeUsts', $nomeUsts);
        $pesoUsts = $this->Ust->find('list', array('conditions' => array(
                'st_registro' => 'S'
            ),
            'fields' => array('id', 'valor_pf')));
        $this->set('pesoUsts', $pesoUsts);
        $ustanalise = $this->Rlustsanalise->find('all', array('conditions' => array('analise_id' => $id, 'st_registro' => 'S')));
        $analise = $this->Analiust->find('first', array('conditions' => array('id' => $id)));
        $sistema = $this->Sistema->find('first', array('fields' => array('nome', 'id'),
            'conditions' => array('Sistema.id' => $analise['Analiust']['sistema_id'])));
        $analise['Analise']['sistema'] = $sistema['Sistema']['nome'];
        $usuario = $this->User->find('first', array('fields' => array('name'),
            'conditions' => array('id' => $analise['Analiust']['user_id'])));
        $equipe = $this->Equipe->find('first', array('fields' => array('nome'),
            'conditions' => array('Equipe.id' => $analise['Analiust']['equipe_id'])));
        $analise['Analiust']['usuario'] = $usuario['User']['name'];
        $analise['Analiust']['equipe'] = !empty($equipe['Equipe']['nome']) ? $equipe['Equipe']['nome'] : 'Administrador';
        $this->set('imprimir', $acao);
        $this->set('ustanalise', $ustanalise);
        $this->set('analise', $analise);
        $this->set('nomeUsts', $nomeUsts);
        $this->set('pesoUsts', $pesoUsts);
    }

    /**
     * buscar - Busca a análise de acordo com os parametros
     */
    public function buscar() {
        $this->layout = 'novo';
        $sistemas = $this->Sistema->find('list', array(
            "fields" => array("id", "nome"),
            'conditions' => array('Sistema.st_registro' => 'S'),
            'order' => array('Sistema.nome')));
        $this->set('sistemas', $sistemas);
        if ($this->request->is('post') || $this->request->is('put')) {
            $condicoes = array();
            if (!empty($this->request->data['Analise']['demanda'])) {
                $demanda = array('Analise.nu_demanda ' => $this->request->data['Analise']['demanda']);
            } else {
                $demanda = array();
            }
            if (!empty($this->request->data['Analise']['sistema_id'])) {
                $sistema = array('Analise.sistema_id ' => $this->request->data['Analise']['sistema_id']);
            } else {
                $sistema = array();
            }
            if (!empty($this->request->data['Analise']['tipo'])) {
                $tipo = array('Analise.tipo_contagem ' => $this->request->data['Analise']['tipo']);
            } else {
                $tipo = array();
            }
            $result = array();
            $cond = array(
                'Analise.st_registro' => 'S');
            $condicoes = array_merge($cond, $sistema);
            $condicoes = array_merge($condicoes, $demanda);
            $condicoes = array_merge($condicoes, $tipo);
            $analises = $this->Analise->find('all', array(
                'conditions' => $condicoes,
                'fields' => array('id', 'tipo_contagem', 'metodo_contagem', 'nu_demanda', 'total_pf', 'total_pf_ajustado', 'fase_id', 'sistema_id', 'created', 'valor_fator'),
                'order' => "Analise.id DESC"
                    )
            );
            foreach ($analises as $key => $value) {
                $funcionalidades = $this->Funcionalidade->find('all', array(
                    'conditions' => array(
                        'Funcionalidade.analise_id ' => $value['Analise']['id'],
                        'Funcionalidade.st_registro' => 'S'),
                    'fields' => array('id', 'nome', 'tipo_funcionalidade', 'complexidade', 'impacto', 'qtd_pf', 'observacao'),
                    'order' => array('Funcionalidade.nome')
                        )
                );
                $fase = $this->Fase->find('first', array(
                    'conditions' => array(
                        'Fase.id ' => $value['Analise']['fase_id'],
                        'Fase.st_registro' => 'S'),
                    'fields' => array('nome')
                        )
                );
                $sistema = $this->Sistema->find('first', array(
                    'conditions' => array(
                        'Sistema.id ' => $value['Analise']['sistema_id'],
                        'Sistema.st_registro' => 'S'),
                    'fields' => array('nome')
                        )
                );
                $value['Analise']['sistema'] = isset($sistema['Sistema']['nome']) ? $sistema['Sistema']['nome'] : '';
                $value['Analise']['fase_id'] = isset($fase['Fase']['nome']) ? $fase['Fase']['nome'] : '';
                $result[$key] = $value;
                $result[$key]['Funcionalidade'] = $this->configFuncionalidades($funcionalidades);
            }
            $this->data = array();
            if (!empty($result)) {
                $this->set('result', $result);
            } else {
                $this->_flash('Nenhum registro encontrado.', 'error', '/analises/analises/buscar');
            }
        }
    }

    /**
     * Histórico de uma analise.
     * @param type $id
     */
    public function history($id) {
        $this->layout = 'novo';
        $th = $this->Thanaliust->find('all', array('conditions' => array('analise_id' => $id, 'history != ' => '')));
        $result = array();
        if (!empty($th)) {
            foreach ($th as $value) {
                $user = $this->User->find('first', array('conditions' => array('id' => $value['Thanaliust']['user_id'])));
                $value['Thanaliust']['user'] = !empty($user['User']['name']) ? $user['User']['name'] : $user['User']['username'];
                $value['Thanaliust']['email'] = !empty($user['User']['email']) ? $user['User']['email'] : 'indisponível';
                $value['Thanaliust']['perfil'] = $user['User']['role_id'];
                $fase = $this->Fase->find('first', array('conditions' => array('id' => $value['Thanaliust']['fase_id'])));
                $value['Thanaliust']['fase_id'] = !empty($fase['Fase']['nome']) ? $fase['Fase']['nome'] : 'indisponível';
                $resultado['Analise'] = $value['Thanaliust'];
                $result[] = $resultado;
            }
        }
        $this->set('result', $result);
    }
    /**
     * funtion deleteUstsAnalise - Deletar Itens de uma análise alterando o valor de PFs da análise
     */
    public function deleteUstsAnalise($idRlust, $idUst, $idAnalise) {
        $this->Rlustsanalise->read('st_registro', $idRlust);
        $this->Rlustsanalise->set(array(
            'st_registro' => 'N'
        ));
        $saveRl = $this->Rlustsanalise->save();
        $pesoUst = $this->Ust->find('first', array('conditions' => array('id' => $idUst), 'fields' => array('nome', 'valor_pf')));
        $rlItem = $this->Rlustsanalise->find('first', array('conditions' => array('id' => $idRlust)));
        $analise = $this->Analiust->find('first', array('conditions' => array('id' => $idAnalise)));
        $valorItem = $rlItem['Rlustsanalise']['qtde'] * $pesoUst['Ust']['valor_pf'];
        
       


        $analise['Analiust']['total_ust'] = $analise['Analiust']['total_ust'] - round($valorItem, 2);
        
        
        $saveAnalise = $this->Analiust->save($analise);
        
        if ($saveRl && $saveAnalise) {
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou a UST : ' .
                    $pesoUst['Ust']['nome'] . ' da  análise ID:' . $idAnalise . '.', array('ust'));
            $this->_flash('UST deletada com sucesso!', 'success', '/analiusts/analiusts/usts/' . $idAnalise);
        } else {
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar o Item não mensurável : ' .
                    $pesoUst['Ust']['nome'] . ' da  análise ID:' . $idAnalise . '.', array('item'));
            $this->_flash('UST não foi deletada!', 'success', '/analiusts/analiusts/usts/' . $idAnalise);
        }
    }

}
