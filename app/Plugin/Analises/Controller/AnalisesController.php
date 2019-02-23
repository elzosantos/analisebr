<?php

Class AnalisesController extends AnalisesAppController {

    /**
     * Load Class Models
     * @var type $uses
     */
    public $uses = array('Analise', 'Analiust', 'Fases.Fase', 'Fronteiras.Fronteira', 'Datatable',
        'Sistemas.Sistema', 'Funcionalidade', 'Tdstrsar',
        'Thanalise', 'Thfuncionalidade', 'Thtdstrsar',
        'Associativa', 'Equipes.Equipe', 'Itens.Item', 'Usts.Ust', 'Rlustsanalise',
        'Rlitensanalise','Rluserequipe', 'Deflatores.Deflatore',
        'Datalock', 'Users.User', 'Documentos.Documento', 'Contratos.Contrato', 'Rlcontratometodo', 'Rlcontratoequipe'); 
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
                                '1' => 'Projeto de Desenvolvimento',
                                '2' => 'Projeto de Melhoria',
                                '3' => 'Contagem de Aplicação' 
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
     * Adiciona a primeira etapa das análises
     */
    public function add() { 
        $this->layout = 'novo';
        if ($this->data) { //recebe dados do POST
                $this->request->data['Analise']['equipe_id'] = $this->Session->read('Equipe_id');
                $this->Analise->save($this->data);
                $idAnalise = $this->Analise->getLastInsertID();
                $nomeSistemas = $this->Sistema->find('first', array(
                    "fields" => array("nome"),
                    'conditions' => array('Sistema.st_registro' => 'S', 'id' => $this->request->data['Analise']['sistema_id'])));
                CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} iniciou a análise ID: ' . $idAnalise . ' no sistema: ' . $nomeSistemas['Sistema']['nome'] . ' . ', array('analise'));
                CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou a análise ID: ' . $idAnalise . ' no sistema: ' . $nomeSistemas['Sistema']['nome'] . ' . ', array('analise'));
                $this->redirect('/analises/analises/analises/' . $idAnalise); 
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
        $exists = $this->Analise->find('first', array('conditions' => array('Analise.id' => $id, 'Analise.st_registro' => 'S'), 
		'fields' => array('metodo_contagem', 'tipo_contagem', 'total_pf_ajustado', 'fator', 'baseline', 'total_pf_itens', 'id_contrato')));
        if (empty($exists)) {
            $this->_flash('Análise não encontrada.', 'error', '/painel');
        }
        $this->Analise->id = $id;
        $this->layout = 'novo';
        $this->dataLock($id);
        $this->getHeader($id); 
        $fronteiras = $this->Fronteira->find('list', array(
            "fields" => array("id",
                "nome"),
            'conditions' => array('st_registro' => 'S'),
            'order' => array('nome')
                )
        );
        $this->set('fronteiras', $fronteiras); 
        $equipe = $this->Session->read('Equipe_id');
        
        if (empty($equipe)){
            $equipe = 'Rlcontratoequipe.id_equipe is not null ';
        }else{
            $equipe = 'Rlcontratoequipe.id_equipe = ' . $equipe;
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
            'conditions' => array('id_contrato' => $exists['Analise']['id_contrato'],'st_registro' => 'S')
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
        $fases = $this->Fase->find('list', array(
            "fields" => array("id",
                "nome"),
            'conditions' => array('st_registro' => 'S'),
            'order' => array('nome')
                )
        );
   
        $this->set('fases', $fases); 
        // contar os pf das funcionalidades dados e transção
        $funcionalidadesAnalise = $this->Funcionalidade->find('all', array('conditions' => array(
                'Funcionalidade.st_registro' => 'S',
                'Funcionalidade.analise_id' => $id,
            )), compact('funcionalidades'));
        $qtd_dados = 0;
        $qtd_transacao = 0;
        foreach ($funcionalidadesAnalise as $value) {
            if ($value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI ||
                    $value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) {
                $qtd_dados = $qtd_dados + $value['Funcionalidade']['qtd_pf'];
            } else {
                $qtd_transacao = $qtd_transacao + $value['Funcionalidade']['qtd_pf'];
            }
        } 
        $this->set('qtd_dados', $qtd_dados);
        $this->set('qtd_transacao', $qtd_transacao); 
        $fatorPadrao = $this->Deflatore->find('first');
        $fat = !empty($exists['Analise']['fator']) ? $exists['Analise']['fator'] : $fatorPadrao['Deflatore']['fator'];
        $this->set('fator_padrao', $fat);
        $this->set('fator_padrao_sistema', $fatorPadrao['Deflatore']['fator']); 
        if ($this->request->is('post') || $this->request->is('put')) { 
            
            $funcionalidades = $this->Funcionalidade->find('all', array('conditions' => array('Funcionalidade.analise_id' => $id,
                    'Funcionalidade.st_registro' => 'S'), 'fields' =>
                array('id', 'baseline', 'id_antigo', 'impacto', 'sistema_id', 'nome', 'tipo_funcionalidade','qtd_pf', 'complexidade')));
            //Verifica se existe funcionalidades na análise antes de mudar o método ou o tipo
            // Apagas as funcionalidades apos a troca do tipo para Estimada
            if (!empty($exists['Analise']['metodo_contagem']) || !empty($exists['Analise']['tipo_contagem'])) {
                if(($exists['Analise']['metodo_contagem'] == \Dominio\MetodoContagem::$estimada ||
                        $exists['Analise']['metodo_contagem'] == \Dominio\MetodoContagem::$indicativa) 
                        && $this->data['Analise']['metodo_contagem'] == \Dominio\MetodoContagem::$detalhada){
                        $this->_flash('Não é possível transformar uma análise estimada ou indicativa em detalhada.', 'error', '/analises/analises/analises/' . $id);
                        }
                
                if ($exists['Analise']['metodo_contagem'] != $this->data['Analise']['metodo_contagem'] || 
                        $exists['Analise']['tipo_contagem'] != $this->data['Analise']['tipo_contagem']) {
                    if (!empty($funcionalidades)) {
                        $total_pf = 0;
                        $total_pf_ajustado = 0;
                        foreach($funcionalidades as $value){
                            $dados['Funcionalidade'] = $this->getCalculaAPF($value, \Dominio\MetodoContagem::$estimada); 
                            $total_pf = $total_pf + $dados['Funcionalidade']['qtd_pf'];
                            $total_pf_ajustado = $total_pf_ajustado +  $this->ajusteFuncionalidade( $dados  , $exists['Analise'] , $total_pf);
                            $this->Funcionalidade->save($dados);
                            $dados['Funcionalidade'] = array();
                        }  
                        $this->request->data['Analise']['total_pf'] = $total_pf;
                        $this->request->data['Analise']['total_pf_ajustado'] = $total_pf_ajustado;
                        $this->request->data['Analise']['valor_fator'] = $total_pf;
                        $funcionalidades = array(); 
                    }
                }
            } 
            // utilizar o fator de deflator da analise ou do sistema
            if ($this->request->data['Analise']['fator'] == '0' || $this->request->data['Analise']['fator'] == '') {
                $fatorPadrao = $this->Deflatore->find('first');
                $this->request->data['Analise']['fator'] = $fatorPadrao['Deflatore']['fator'];
            }
            if(!empty($exists['Analise']['fator']) && $exists['Analise']['fator'] != 0){ 
                $total_pf_ajustado_fator = !empty($exists['Analise']['total_pf_ajustado']) ? $exists['Analise']['total_pf_ajustado'] /$exists['Analise']['fator'] : '0';
            }else{
                $total_pf_ajustado_fator = '0';
            }    
            if(empty($total_pf_ajustado)){
                $this->request->data['Analise']['valor_fator'] = $total_pf_ajustado_fator * $this->request->data['Analise']['fator'];
                $this->request->data['Analise']['total_pf_ajustado'] = $total_pf_ajustado_fator * $this->request->data['Analise']['fator'];
            }
            //SOMENTE Análise Detalhada entra no baseline e feita pelo administrador, 0 vai pro baseline e 1 não entra no baseline 
            $role = $this->Session->read('Auth.User.role_id');
            if ($this->request->data['Analise']['metodo_contagem'] == '1' && $role == '1') {
                if ($this->request->data['Analise']['baseline'] == '1') {
                    $this->controlaBaseline($this->request->data, \Dominio\TipoAnalise::$INM);
                    $this->request->data['Analise']['baseline'] = 0;
                } else {
                    $this->request->data['Analise']['baseline'] = 1;
                }
            } else {
                $this->request->data['Analise']['baseline'] = 1;
            }
            //Atualizar funcionalidades para sair ou entrar no baseline
            if (!empty($funcionalidades)) {
                $upFuncionalidades = array();
                $dataFuncAntigo = array();
                $dataFunc = array(); 
                if ($this->request->data['Analise']['baseline'] == 0) {
                    foreach ($funcionalidades as $value) { 
                        $validFuncionalidade = $this->Funcionalidade->find('first', array('conditions' => array('nome' => $value['Funcionalidade']['nome'], 'st_registro' => 'S', 'sistema_id' => $this->request->data['Analise']['sistema_id'], 'baseline' => 0)));
                        if(!empty($validFuncionalidade)){
                            $this->_flash('Existem funcionalidades nessa análise que já compõem o baseline do sistema. A análise não foi salva.');
                            return;
                        }
                    }
                } 
                if ($exists['Analise']['baseline'] != $this->request->data['Analise']['baseline']) { 
                    foreach ($funcionalidades as $value) {
                        //Consulta se existe funcionalidades cadatradas mais recentemente e que estejam no baseline, entao nao realiza nenhuma ação
                        $returnVinculoFuturo = $this->verificaVinculoFuturo($value, $this->request->data['Analise']['baseline']);
                        if (!$returnVinculoFuturo) {
                            $this->verificaVinculoAnterior($value, $this->request->data['Analise']['baseline']);
                        } 
                    } 
                }

            } 
            if ($this->Analise->save($this->request->data) && empty($validFuncionalidade)) {
                $this->getHeader($id); 
                $this->set('fator_padrao', $this->request->data['Analise']['fator']);
                CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} alterou as Informações Gerais da análise ID:' . $id . '.', array('analise'));
                $this->_flash('Análise foi salva.');
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu alterar as Informações Gerais da análise ID:' . $id . '.', array('analise'));
                $this->_flash('Análise não foi salva.', 'error');
            }
        } else {
            $this->request->data = $this->Analise->read();
        }
    }

    public function verificaVinculoFuturo($value, $baseline = null) {
        //Consulta funcionalidades do baseline que estão utilizando a funcionalidade como referencia
        $idFuncionalidade = $value['Funcionalidade']['id'];
        do {
            $funcionalidadesVinculadas = $this->Funcionalidade->find('first', array('conditions' =>
                array('Funcionalidade.id_antigo' => $idFuncionalidade),
                'fields' => array('id', 'baseline', 'id_antigo', 'impacto', 'sistema_id')));
            if (!empty($funcionalidadesVinculadas)) {
                if ($funcionalidadesVinculadas['Funcionalidade']['baseline'] == '0') {
                    return true;
                }
                $idFuncionalidade = $funcionalidadesVinculadas['Funcionalidade']['id'];
            } else {
                $idFuncionalidade = null;
            }
        } while ($idFuncionalidade != null);
        return false;
    }

    /*
     * Verifica se existem funcionalidades que estao referenciadas e verifica se está ativa no baseline antes de ativar a funcionalidade da analise 
     */

    public function verificaVinculoAnterior($value, $baseline = null, $exc = false) { 
        $idFuncionalidade = $value['Funcionalidade']['id_antigo']; 
        do {
            $funcionalidadesAntigasVinculadas = $this->Funcionalidade->find('first', array('conditions' =>
                array('Funcionalidade.id' => $idFuncionalidade),
                'fields' => array('id', 'baseline', 'id_antigo', 'impacto', 'sistema_id', 'st_registro', 'analise_id')));

            if (!empty($funcionalidadesAntigasVinculadas)) {
                $analiseIDAntigo = $this->Analise->find('first', array('conditions' => array('Analise.id' =>
                        $funcionalidadesAntigasVinculadas['Funcionalidade']['analise_id'], 'Analise.st_registro' => 'S'), 'fields' => array('id', 'baseline')));

                if (!empty($analiseIDAntigo['Analise']) && $funcionalidadesAntigasVinculadas['Funcionalidade']['st_registro'] == 'S') {
                    $dataFuncAntigo['id'] = $funcionalidadesAntigasVinculadas['Funcionalidade']['id'];
                    $dataFunc['id'] = $value['Funcionalidade']['id'];  
                    if (($analiseIDAntigo['Analise']['baseline'] == '1') ||
                            ($analiseIDAntigo['Analise']['baseline'] == '0' && $baseline == '0')) { 
                        if (!empty($funcionalidadesAntigasVinculadas['Funcionalidade']['id_antigo']) &&
                                $funcionalidadesAntigasVinculadas['Funcionalidade']['baseline'] == '1') {

                            $idFuncionalidade = !empty($funcionalidadesAntigasVinculadas['Funcionalidade']['id_antigo']) ? $funcionalidadesAntigasVinculadas['Funcionalidade']['id_antigo'] : null;
                        } else if ($funcionalidadesAntigasVinculadas['Funcionalidade']['baseline'] == '1' && $baseline == '1') {

                            if ($funcionalidadesAntigasVinculadas['Funcionalidade']['impacto'] == \Dominio\TipoImpacto::$Exclusao) {
                                $dataFuncAntigo['baseline'] = '1';
                                $dataFuncAntigo['autocomplete'] = 'N';
                            } else {
                                $dataFuncAntigo['baseline'] = '1';
                                $dataFuncAntigo['autocomplete'] = 'N';
                            }
                            if ($value['Funcionalidade']['impacto'] == \Dominio\TipoImpacto::$Exclusao) {
                                $dataFunc['baseline'] = '1';
                                $dataFunc['autocomplete'] = 'N';
                            } else {
                                $dataFunc['baseline'] = '1';
                                $dataFunc['autocomplete'] = '1';
                            }
                            $upFuncionalidadesdataFunc[] = $dataFunc;
                            $upFuncionalidadesdataFuncAntigo[] = $dataFuncAntigo; 
                            $updateFuncionalidades = array_merge($upFuncionalidadesdataFunc, $upFuncionalidadesdataFuncAntigo);
                            $this->Funcionalidade->saveMany($updateFuncionalidades);
                            $this->atualizaBaseline($value);
                            $idFuncionalidade = null;
                        } else { 
                            if ($funcionalidadesAntigasVinculadas['Funcionalidade']['impacto'] == \Dominio\TipoImpacto::$Exclusao) {
                                $dataFuncAntigo['baseline'] = '1';
                                $dataFuncAntigo['autocomplete'] = 'N';
                            } else {
                                $dataFuncAntigo['baseline'] = '1';
                                $dataFuncAntigo['autocomplete'] = 'N';
                            }
                            if ($value['Funcionalidade']['impacto'] == \Dominio\TipoImpacto::$Exclusao) {
                                $dataFunc['baseline'] = '1';
                                $dataFunc['autocomplete'] = 'N';
                            } else {
                                $dataFunc['baseline'] = '0';
                                $dataFunc['autocomplete'] = 'S';
                            }
                            $upFuncionalidadesdataFunc[] = $dataFunc;
                            $upFuncionalidadesdataFuncAntigo[] = $dataFuncAntigo; 
                            $updateFuncionalidades = array_merge($upFuncionalidadesdataFunc, $upFuncionalidadesdataFuncAntigo);
                            $this->Funcionalidade->saveMany($updateFuncionalidades);
                            $this->atualizaBaseline($value);
                            $idFuncionalidade = null;
                        }
                    } else if ($analiseIDAntigo['Analise']['baseline'] == '0' && $baseline == '1') {
                        if ($funcionalidadesAntigasVinculadas['Funcionalidade']['impacto'] == \Dominio\TipoImpacto::$Exclusao) {
                            $dataFuncAntigo['baseline'] = '1';
                            $dataFuncAntigo['autocomplete'] = 'N';
                        } else {
                            $dataFuncAntigo['baseline'] = '0';
                            $dataFuncAntigo['autocomplete'] = 'S';
                        }
                        $dataFunc['baseline'] = '1';
                        $dataFunc['autocomplete'] = 'N';
                        $upFuncionalidadesdataFunc[] = $dataFunc;
                        $upFuncionalidadesdataFuncAntigo[] = $dataFuncAntigo; 
                        $updateFuncionalidades = array_merge($upFuncionalidadesdataFunc, $upFuncionalidadesdataFuncAntigo);
                        $this->Funcionalidade->saveMany($updateFuncionalidades);
                        $this->atualizaBaseline($value);
                        $idFuncionalidade = null;
                    } else if ($analiseIDAntigo['Analise']['baseline'] == '1' && $baseline == '1') { 
                        if ($funcionalidadesAntigasVinculadas['Funcionalidade']['impacto'] == \Dominio\TipoImpacto::$Exclusao) {
                            $dataFuncAntigo['baseline'] = '1';
                            $dataFuncAntigo['autocomplete'] = 'N';
                        } else {
                            $dataFuncAntigo['baseline'] = '0';
                            $dataFuncAntigo['autocomplete'] = 'S';
                        }
                        $dataFunc['baseline'] = '1';
                        $dataFunc['autocomplete'] = 'N';
                        $upFuncionalidadesdataFunc[] = $dataFunc;
                        $upFuncionalidadesdataFuncAntigo[] = $dataFuncAntigo; 
                        $updateFuncionalidades = array_merge($upFuncionalidadesdataFunc, $upFuncionalidadesdataFuncAntigo);
                        $this->Funcionalidade->saveMany($updateFuncionalidades);
                        $this->atualizaBaseline($value);
                        $idFuncionalidade = null;
                    }
                } else {
                    $idFuncionalidade = !empty($funcionalidadesAntigasVinculadas['Funcionalidade']['id_antigo']) ? $funcionalidadesAntigasVinculadas['Funcionalidade']['id_antigo'] : null;
                }
            } else {
                if ($baseline == '0') {
                    $dataFunc['Funcionalidade']['id'] = $value['Funcionalidade']['id'];
                    if ($value['Funcionalidade']['impacto'] == \Dominio\TipoImpacto::$Exclusao) {
                        $dataFunc['baseline'] = '1';
                        $dataFunc['autocomplete'] = 'N';
                    } else { 
                        $dataFunc['Funcionalidade']['baseline'] = '0';
                        $dataFunc['Funcionalidade']['autocomplete'] = 'S';
                    }
                } else {
                    $dataFunc['Funcionalidade']['id'] = $value['Funcionalidade']['id'];
                    if ($value['Funcionalidade']['impacto'] == \Dominio\TipoImpacto::$Exclusao) {
                        $dataFunc['baseline'] = '1';
                        $dataFunc['autocomplete'] = 'N';
                    } else {
                        $dataFunc['Funcionalidade']['baseline'] = '1';
                        $dataFunc['Funcionalidade']['autocomplete'] = 'N';
                    }
                } 
                $this->Funcionalidade->save($dataFunc);
                $this->atualizaBaseline($value);
                $idFuncionalidade = null;
            }
        }while ($idFuncionalidade != null);
        return;
    }

    public function verificaVinculoAnteriorExcluirFuncionalidade($value, $baseline = null) {
        $idFuncionalidade = $value['Funcionalidade']['id_antigo'];
        do {
            $funcionalidadesAntigasVinculadas = $this->Funcionalidade->find('first', array('conditions' =>
                array('Funcionalidade.id' => $idFuncionalidade),
                'fields' => array('id', 'baseline', 'id_antigo', 'impacto', 'sistema_id', 'st_registro', 'analise_id')));
            if (!empty($funcionalidadesAntigasVinculadas)) {
                $analiseIDAntigo = $this->Analise->find('first', array('conditions' => array('Analise.id' =>
                        $funcionalidadesAntigasVinculadas['Funcionalidade']['analise_id'], 'Analise.st_registro' => 'S'), 'fields' => array('id', 'baseline')));

                if (!empty($analiseIDAntigo['Analise']) && $funcionalidadesAntigasVinculadas['Funcionalidade']['st_registro'] == 'S') {
                    $dataFuncAntigo['id'] = $funcionalidadesAntigasVinculadas['Funcionalidade']['id'];
                    $dataFunc['id'] = $value['Funcionalidade']['id'];
                    if ($analiseIDAntigo['Analise']['baseline'] == '1') {
                        if (!empty($funcionalidadesAntigasVinculadas['Funcionalidade']['id_antigo']) &&
                                $funcionalidadesAntigasVinculadas['Funcionalidade']['baseline'] == '1') {
                            $idFuncionalidade = !empty($funcionalidadesAntigasVinculadas['Funcionalidade']['id_antigo']) ? $funcionalidadesAntigasVinculadas['Funcionalidade']['id_antigo'] : null;
                        }
                    } else if ($analiseIDAntigo['Analise']['baseline'] == '0') {
                        if ($funcionalidadesAntigasVinculadas['Funcionalidade']['impacto'] == \Dominio\TipoImpacto::$Exclusao) {
                            $dataFuncAntigo['baseline'] = '1';
                            $dataFuncAntigo['autocomplete'] = 'N';
                        } else {
                            $dataFuncAntigo['baseline'] = '0';
                            $dataFuncAntigo['autocomplete'] = 'S';
                        }
                        $dataFunc['baseline'] = '1';
                        $dataFunc['autocomplete'] = 'N';
                        $upFuncionalidadesdataFunc[] = $dataFunc;
                        $upFuncionalidadesdataFuncAntigo[] = $dataFuncAntigo;


                        $updateFuncionalidades = array_merge($upFuncionalidadesdataFunc, $upFuncionalidadesdataFuncAntigo);
                        $this->Funcionalidade->saveMany($updateFuncionalidades);
                        $this->atualizaBaseline($value);
                        $idFuncionalidade = null;
                    }
                } else {
                    $idFuncionalidade = !empty($funcionalidadesAntigasVinculadas['Funcionalidade']['id_antigo']) ? $funcionalidadesAntigasVinculadas['Funcionalidade']['id_antigo'] : null;
                }
            }
        } while ($idFuncionalidade != null);
        return;
    }

    /*
     * Verifica se existem funcionalidades que estao referenciadas e verifica se está ativa no baseline antes de ativar a funcionalidade da analise 
     */

    /**
     * function deleteDados - Busca a funcionalidade de determinada análise e
     * inativa. Também inativa os itens não mensuráveis da funcionalidade.
     * @param type $id ( Id da Funcionalidade)
     * @param type $analise_id
     */
    public function deleteDados($id, $analise_id) {
        $this->Funcionalidade->read('st_registro', $id);
        $this->Funcionalidade->set(array(
            'st_registro' => 'N',
            'baseline' => '1',
            'autocomplete' => 'N'
        ));
        $saveFuncionalidade = $this->Funcionalidade->save();
        $analise = $this->Analise->find('first', array(
            "fields" => array('id', 'total_pf', 'total_pf_itens', 'total_pf_ajustado', 'fator', 'valor_fator', 'tipo_contagem', 'baseline', 'total_pf_itens','id_contrato'),
            "conditions" => array('id' => $analise_id)
                )
        ); 
        $funcionalidade = $this->Funcionalidade->find('first', array(
            //"fields" => array("id", "qtd_pf", 'id_antigo', 'tipo', 'impacto', 'analise_id', 'sistema_id', 'baseline', 'st_registro'),
            "conditions" => array('id' => $id)
                )
        ); 
        //Retorna a funcionalidade anterior ao baseline 
        $saveUpdateFuncionalidade = true;
        if (!empty($funcionalidade['Funcionalidade']['id_antigo'])) {
            $returnVinculoFuturo = $this->verificaVinculoFuturo($funcionalidade, $analise['Analise']['baseline']);
            if (!$returnVinculoFuturo) {
                $this->verificaVinculoAnteriorExcluirFuncionalidade($funcionalidade, $analise['Analise']['baseline']);
            }
        } 
        //Itens Não Mensuráveis 
        $itens = $this->Rlitensanalise->find('all', array('conditions' => array('Rlitensanalise.funcionalidade_id' => $id,
                'Rlitensanalise.st_registro' => 'S')));

        $pfItens = 0;
        $saveUpdateItens = true; 
        if (!empty($itens)) { 
            foreach ($itens as $value) {
                $valorItem = $this->Item->find('first', array('conditions' =>
                    array('Item.st_registro' => 'S', 'Item.id' => $value['Rlitensanalise']['item_id']),
                    'fields' => 'valor_pf'));

                $updateItens['Rlitensanalise']['id'] = $value['Rlitensanalise']['id'];
                $updateItens['Rlitensanalise']['st_registro'] = 'N';
                $pfItens += $valorItem['Item']['valor_pf'] * $value['Rlitensanalise']['qtde'];
                $saveUpdateItens = $this->Rlitensanalise->save($updateItens);
                $updateItens = array();
            }
        } 
        $saveAnalise['Analise']['id'] = $analise['Analise']['id'];
        $saveAnalise['Analise']['total_pf'] = $analise['Analise']['total_pf'] - $funcionalidade['Funcionalidade']['qtd_pf'];
        $saveAnalise['Analise']['valor_fator'] = (float) $analise['Analise']['valor_fator'] - (float) ($this->ajusteFuncionalidade($funcionalidade, $analise['Analise'] , $funcionalidade['Funcionalidade']['qtd_pf']) *
                $analise['Analise']['fator']) - $pfItens;
        $saveAnalise['Analise']['total_pf_ajustado'] = $analise['Analise']['total_pf_ajustado'] - ($this->ajusteFuncionalidade($funcionalidade, $analise['Analise'] , $funcionalidade['Funcionalidade']['qtd_pf']) *
                $analise['Analise']['fator']);
        $saveAnalise['Analise']['total_pf_itens'] = (float) $analise['Analise']['total_pf_itens'] - $pfItens; 
        $saveTransAnalise = $this->Analise->save($saveAnalise); 
        if ($saveFuncionalidade && $saveUpdateFuncionalidade && $saveUpdateItens && $saveTransAnalise) {
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou a funcionalidade ID:' . $id . '.', array('analise'));
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou os Itens Não Mensuráveis da funcionalidade ID:' . $id . '.', array('item'));
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} alterou o Ponto de Função da análise ID:' . $analise['Analise']['id'] . ' para Valor PF  : ' . $saveAnalise['Analise']['total_pf'] . ' , Valor PF Ajustado : ' . $saveAnalise['Analise']['total_pf_ajustado'] . '.', array('analise'));
            $this->_flash('Funcionalidade deletada com sucesso!', 'success', '/analises/analises/funcionalidades/' . $funcionalidade['Funcionalidade']['tipo'] . '/' . $analise_id);
        } else {
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar a funcionalidade ID:' . $id . '.', array('analise'));
            $this->_flash('Funcionalidade não foi deletada!', 'error', '/analises/analises/funcionalidades/' . $funcionalidade['Funcionalidade']['tipo'] . '/' . $analise_id);
        }
    }

    /**
     * funtion deleteItensFuncionalidade - Deletar Itens de uma funcionalidade alterando o valor de PFs da Analise
     * @param type $idRlitem
     * @param type $idItem
     * @param type $idFuncionalidade
     * @param type $idAnalise
     * @param type $tipoFuncionalidade
     */
    public function deleteItensFuncionalidade($idRlitem, $idItem, $idFuncionalidade, $idAnalise, $tipoFuncionalidade) {
        $this->Rlitensanalise->read('st_registro', $idRlitem);
        $this->Rlitensanalise->set(array(
            'st_registro' => 'N'
        ));
        $saveRl = $this->Rlitensanalise->save();
        $pesoItem = $this->Item->find('first', array('conditions' => array('id' => $idItem), 'fields' => array('valor_pf', 'nome')));
        $rlItem = $this->Rlitensanalise->find('first', array('conditions' => array('Rlitensanalise.id' => $idRlitem)));
        $analise = $this->Analise->find('first', array('conditions' => array('id' => $idAnalise)));
        $analise['Analise']['total_pf_itens'] = $analise['Analise']['total_pf_itens'] - ($rlItem['Rlitensanalise']['qtde'] * $pesoItem['Item']['valor_pf']);
        // $analise['Analise']['total_pf_ajustado'] = $analise['Analise']['total_pf_ajustado'] - ($rlItem['Rlitensanalise']['qtde'] * $pesoItem['Item']['valor_pf']);
        $analise['Analise']['valor_fator'] = $analise['Analise']['valor_fator'] - ($rlItem['Rlitensanalise']['qtde'] * $pesoItem['Item']['valor_pf']);
        $saveAnalise = $this->Analise->save($analise);
        if ($saveRl && $saveAnalise) {
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou o Item não mensurável : ' . $pesoItem['Item']['nome'] . ' da  funcionalidade ID:' . $idFuncionalidade . '.', array('item'));
            $this->_flash('Item deletado com sucesso!', 'success', '/analises/analises/funcionalidades/' . $tipoFuncionalidade . '/' . $idAnalise);
        } else {
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar o Item não mensurável : ' . $pesoItem['Item']['nome'] . ' da  funcionalidade ID:' . $idFuncionalidade . '.', array('item'));
            $this->_flash('Item não foi deletado!', 'success', '/analises/analises/funcionalidades/' . $tipoFuncionalidade . '/' . $idAnalise);
        }
    }

    /**
     * funtion deleteItensAnalise - Deletar Itens de uma análise alterando o valor de PFs da análise
     *
     * @param type $idRlitem
     * @param type $idItem
     * @param type $idFuncionalidade
     * @param type $idAnalise
     * @param type $tipoFuncionalidade
     */
    public function deleteItensAnalise($idRlitem, $idItem, $idAnalise) {  
        $this->Rlitensanalise->read('st_registro', $idRlitem);
        $this->Rlitensanalise->set(array(
            'st_registro' => 'N'
        ));
        $saveRl = $this->Rlitensanalise->save(); 
        $pesoItem = $this->Item->find('first', array('conditions' => array('id' => $idItem), 'fields' => array('nome', 'valor_pf')));
        $rlItem = $this->Rlitensanalise->find('first', array('conditions' => array('Rlitensanalise.id' => $idRlitem)));
        $analise = $this->Analise->find('first', array('conditions' => array('id' => $idAnalise)));
 
        $valorItem = $rlItem['Rlitensanalise']['qtde'] * $pesoItem['Item']['valor_pf']; 
        $analise['Analise']['total_pf_itens'] = $analise['Analise']['total_pf_itens'] - round($valorItem, 2);
        $analise['Analise']['valor_fator'] = $analise['Analise']['valor_fator'] - round($valorItem, 2); 
        if($analise['Analise']['valor_fator'] < 0){
            $analise['Analise']['valor_fator'] = 0;
        }
        if( $analise['Analise']['total_pf_itens'] < 0){
             $analise['Analise']['total_pf_itens'] = 0;
        }
        
        $saveAnalise = $this->Analise->save($analise);
        if ($saveRl && $saveAnalise) { 
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou o Item não mensurável : ' . $pesoItem['Item']['nome'] . ' da  análise ID:' . $idAnalise . '.', array('item'));
            $this->_flash('Item deletado com sucesso!', 'success', '/analises/analises/itens/' . $idAnalise);
        } else { 
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar o Item não mensurável : ' . $pesoItem['Item']['nome'] . ' da  análise ID:' . $idAnalise . '.', array('item'));
            $this->_flash('Item não foi deletado!', 'success', '/analises/analises/itens/' . $idAnalise);
        }
    }

    /**
     * function delete - Inativa uma análise
     * @param type $id
     */
    public function delete($id) {
        $this->Analise->id = $id;
        $analise = $this->Analise->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S')));
        if (empty($analise)) {
            $this->_flash('Análise não existente no sistema.', 'error', '/analises/analises/');
        } 
        $this->Analise->read('st_registro', $id);
        $this->Analise->set(array(
            'st_registro' => 'N',
            'baseline' => '1'
        )); 
        $saveAnalise = $this->Analise->save(); 
        if (!$saveAnalise) { 
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar a  análise ID:' . $id . '.', array('analise'));
            $this->_flash('Analise não foi deletada!', 'error', '/painel');
        } else {
            //Apagar relacionamento dos INMs com a analise após exclusão da análise
            $rlItemAnalise = $this->Rlitensanalise->find('all', array('conditions' => array('analise_id' => $id, 'st_registro' => 'S'))); 
            if (!empty($rlItemAnalise)) {
                $updateRlAnalise = array();
                foreach ($rlItemAnalise as $key => $value) {
                    $dataRl['Rlitensanalise']['id'] = $value['Rlitensanalise']['id'];
                    $dataRl['Rlitensanalise']['st_registro'] = 'N';
                    $updateRlAnalise[] = $dataRl;
                }
                $this->Rlitensanalise->saveMany($updateRlAnalise);
            }
        }
        $funcionalidades = $this->Funcionalidade->find('all', array(
            //'fields' => array("id", "qtd_pf", 'id_antigo', 'tipo', 'impacto', 'analise_id', 'sistema_id', 'baseline', 'st_registro'), 
            'conditions' => array('analise_id' => $id)));

        $this->deleteFuncionalidadesAnalise($funcionalidades); 
        CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou a  análise ID:' . $id . '.', array('analise'));
        $this->_flash('Analise deletada com sucesso!', 'success', '/painel');
    }

    public function deleteFuncionalidadesAnalise($funcionalidades) { 
        foreach ($funcionalidades as $value) {
            $updateFuncionalidade['Funcionalidade']['id'] = $value['Funcionalidade']['id'];
            $updateFuncionalidade['Funcionalidade']['st_registro'] = 'N';
            $updateFuncionalidade['Funcionalidade']['baseline'] = '1';
            $updateFuncionalidade['Funcionalidade']['autocomplete'] = 'N';
            $this->Funcionalidade->save($updateFuncionalidade); 
            //Apagar relacionamento dos INMs com a funcionalidade
            $rlItemFuncionalidade = $this->Rlitensanalise->find('all', array('conditions' => array('funcionalidade_id' => $value['Funcionalidade']['id'], 'st_registro' => 'S')));

            if (!empty($rlItemFuncionalidade)) {
                $updateRlFunc = array();
                foreach ($rlItemFuncionalidade as $k => $v) {
                    $dataRlFunc['Rlitensanalise']['id'] = $v['Rlitensanalise']['id'];
                    $dataRlFunc['Rlitensanalise']['st_registro'] = 'N';
                    $updateRlFunc[] = $dataRlFunc;
                }
            } 

            if (!empty($value['Funcionalidade']['id_antigo'])) {
                $analise = $this->Analise->find('first', array('conditions' => array('Analise.id' =>
                        $value['Funcionalidade']['analise_id'], 'Analise.st_registro' => 'S'), 'fields' => array('id', 'baseline')));
                $returnVinculoFuturo = $this->verificaVinculoFuturo($value, $analise['Analise']['baseline']);

                if (!$returnVinculoFuturo) {
                    $this->verificaVinculoAnteriorExcluirFuncionalidade($value, $analise['Analise']['baseline']);
                }
            }
        }
        if (!empty($updateRlFunc)) {
            $this->Rlitensanalise->saveMany($updateRlFunc);
        }
    }
/**
     * function delete - Inativa uma análise
     * @param type $id
     */
    public function duplicar($id) {      
        $analise = $this->Analise->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S')));
        if (empty($analise)) {
            $this->_flash('Análise não existente no sistema.', 'error', '/analises/analises/');
        }  
        unset($analise['Analise']['id']);
        unset($analise['Analise']['created']);
        unset($analise['Analise']['modified']);       
        $saveAnalise = $this->Analise->save($analise); 
        if (!$saveAnalise) {
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu duplicar a  análise ID:' . $id . '.', array('analise'));
            $this->_flash('Analise não foi duplicada!', 'error', '/painel');
        } else {
            //Apagar relacionamento dos INMs com a analise após exclusão da análise
            $rlItemAnalise = $this->Rlitensanalise->find('all', array('conditions' => array('analise_id' => $id, 'st_registro' => 'S')));
            if (!empty($rlItemAnalise)) {
                $updateRlAnalise = array();
                foreach ($rlItemAnalise as $key => $value) {
                    unset($value['Rlitensanalise']['id']);
                    unset($value['Rlitensanalise']['created']);
                    unset($value['Rlitensanalise']['modified']);
                    unset($value['Rlitensanalise']['analise_id']);
                    unset($value['Rlitensanalise']['user_id']);
                    $dataRl['Rlitensanalise']= $value['Rlitensanalise'];
                    $dataRl['Rlitensanalise']['analise_id'] = $saveAnalise['Analise']['id'];
                    $dataRl['Rlitensanalise']['user_id'] = $this->Session->read('Auth.User.id');
                    $updateRlAnalise[] = $dataRl;
                }
                $this->Rlitensanalise->saveMany($updateRlAnalise);
            }
        }
        $funcionalidades = $this->Funcionalidade->find('all', array( 
            'conditions' => array('analise_id' => $id))); 
        $this->duplicarFuncionalidadesAnalise($funcionalidades, $saveAnalise['Analise']['id'] );  
        $this->duplicarItensAnalise($saveAnalise['Analise']['id'], $id); 
        $this->duplicarDocumentacaoAnalise($saveAnalise['Analise']['id'], $id);
        CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} duplicou a  análise ID:' . $id . '.', array('analise'));
        $this->_flash('Analise duplicada com sucesso!', 'success', '/painel');
    }

    public function duplicarFuncionalidadesAnalise($funcionalidades, $id) {        
        foreach ($funcionalidades as $value) { 
            $rlItemFuncionalidade = $this->Rlitensanalise->find('all', array('conditions' => array('funcionalidade_id' => $value['Funcionalidade']['id'], 'st_registro' => 'S')));         
            unset($value['Funcionalidade']['id']);
            unset($value['Funcionalidade']['created']);
            unset($value['Funcionalidade']['modified']);
            unset($value['Funcionalidade']['analise_id']);
            unset($value['Funcionalidade']['id_antigo']);
            unset($value['Funcionalidade']['user_id']);
            $FuncionalidadeDuplicada = $value;
            $FuncionalidadeDuplicada['Funcionalidade']['analise_id'] = $id;
            $FuncionalidadeDuplicada['Funcionalidade']['user_id'] = $this->Session->read('Auth.User.id');
            $this->Funcionalidade->create();
            $this->Funcionalidade->save($FuncionalidadeDuplicada);  
            // var_dump($NovaFuncionalidade['Funcionalidade']['id']);exit;
            if (!empty($rlItemFuncionalidade)) { 
                foreach ($rlItemFuncionalidade as  $v) { 
                    unset($v['Rlitensanalise']['id']);
                    unset($v['Rlitensanalise']['created']);
                    unset($v['Rlitensanalise']['modified']);
                    unset($v['Rlitensanalise']['funcionalidade_id']);
                    unset($v['Rlitensanalise']['user_id']);
                    $dataRlFunc = $v;  
                    $dataRlFunc['Rlitensanalise']['funcionalidade_id'] = $this->Funcionalidade->getInsertID(); 
                    $dataRlFunc['Rlitensanalise']['user_id'] = $this->Session->read('Auth.User.id'); 
                    $updateRlFunc[] = $dataRlFunc; 
                }
            }  
        } 
        if (!empty($updateRlFunc)) {
            $this->Rlitensanalise->saveMany($updateRlFunc);
        }
    }
    
    /**
     * funtion duplicarItensAnalise - Duplicar Itens de uma análise alterando o valor de PFs da análise 
     * @param type $idAnalise
     * @param type $tipoFuncionalidade
     */
    public function duplicarItensAnalise($idNovo, $idDuplicado) { 
        $rlItem = $this->Rlitensanalise->find('first', array('conditions' => array('Rlitensanalise.analise_id' => $idDuplicado))); 
        foreach ($rlItem as $value) {      
            unset($value['Rlitensanalise']['id']);
            unset($value['Rlitensanalise']['created']);
            unset($value['Rlitensanalise']['modified']);
            unset($value['Rlitensanalise']['funcionalidade_id']);
            unset($value['Rlitensanalise']['analise_id']);
            unset($value['Rlitensanalise']['user_id']);
            $dataRlFunc = $value;  
            $dataRlFunc['Rlitensanalise']['analise_id'] = $idNovo; 
            $dataRlFunc['Rlitensanalise']['user_id'] = $this->Session->read('Auth.User.id'); 
            $updateRlFunc[] = $dataRlFunc;
        }
        if (!empty($updateRlFunc)) {
            $this->Rlitensanalise->saveMany($updateRlFunc);
        } 
    }
    
    public function duplicarDocumentacaoAnalise($idNovo, $idDuplicado) {
         $documentos = $this->Documento->find('all', array( 'conditions' => array('analise_id' => $idDuplicado )));
         foreach ($documentos as $value) {      
            unset($value['Documento']['id']);
            unset($value['Documento']['created']);
            unset($value['Documento']['modified']); 
            unset($value['Documento']['analise_id']);
            unset($value['Documento']['user_id']);
            $dataRlFunc = $value;  
            $dataRlFunc['Documento']['analise_id'] = $idNovo; 
            $dataRlFunc['Documento']['user_id'] = $this->Session->read('Auth.User.id'); 
            $updateRlFunc[] = $dataRlFunc;
        }
        if (!empty($updateRlFunc)) {
            $this->Documento->saveMany($updateRlFunc);
            $this->CopiarArquivosAnalise($idNovo, $idDuplicado);
        }  
    }
    
    public function duplicarFuncionalidade($id, $tipo) {  
 
        $funcionalidade = $this->Funcionalidade->find('first', array('conditions' => array('id' => $id)));  
        $rlItemFuncionalidade = $this->Rlitensanalise->find('all', array('conditions' => array('funcionalidade_id' => $id, 'st_registro' => 'S')));         
        unset($funcionalidade['Funcionalidade']['id']);
        unset($funcionalidade['Funcionalidade']['created']);
        unset($funcionalidade['Funcionalidade']['modified']);
        unset($funcionalidade['Funcionalidade']['id_antigo']);
        unset($funcionalidade['Funcionalidade']['user_id']);
        $FuncionalidadeDuplicada = $funcionalidade; 
        $FuncionalidadeDuplicada['Funcionalidade']['user_id'] = $this->Session->read('Auth.User.id');
        $this->Funcionalidade->create();
        $this->Funcionalidade->save($FuncionalidadeDuplicada);  
        if (!empty($rlItemFuncionalidade)) { 
            foreach ($rlItemFuncionalidade as  $v) { 
                unset($v['Rlitensanalise']['id']);
                unset($v['Rlitensanalise']['created']);
                unset($v['Rlitensanalise']['modified']);
                unset($v['Rlitensanalise']['funcionalidade_id']);
                unset($v['Rlitensanalise']['user_id']);
                $dataRlFunc = $v;  
                $dataRlFunc['Rlitensanalise']['funcionalidade_id'] = $this->Funcionalidade->getInsertID(); 
                $dataRlFunc['Rlitensanalise']['user_id'] = $this->Session->read('Auth.User.id'); 
                $updateRlFunc[] = $dataRlFunc; 
            }
        }  
        if (!empty($updateRlFunc)) {
            $this->Rlitensanalise->saveMany($updateRlFunc);
        }
        CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} duplicou a  funcionalidade ID:' . $id . '.', array('funcionalidade'));
        $this->_flash('Analise duplicada com sucesso!', 'success','/analises/analises/funcionalidades/' . $tipo . '/' . $funcionalidade['Funcionalidade']['analise_id']);
    }
    /**
     * response - retorna grid de listagem
     */
    public function responseDados($id) {
        $this->layout = '';
        $aColumns = array(
            "id",
            "nome",
            "tipo_funcionalidade",
            "impacto",
            "complexidade",
            "qtd_pf",
            "qtd_pf_deflator"
        );

        $sTable = 'funcionalidades';
        $this->autoRender = false;
        $aConditions = ' func.st_registro = "S" AND  func.tipo = 1 AND func.analise_id = ' . $id;
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions, 'lista_funcionalidades'); 
        echo json_encode($output);
    }

    /**
     * response - retorna grid de listagem
     */
    public function responseTransacao($id) {
        $this->layout = '';
        $aColumns = array(
            "id",
            "nome",
            "tipo_funcionalidade",
            "impacto",
            "complexidade",
            "qtd_pf",
            "qtd_pf_deflator"
        );
        $sTable = 'funcionalidades'; 
        $this->autoRender = false;
        $aConditions = ' func.st_registro = "S" AND func.tipo = 2 AND func.analise_id = ' . $id;
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions, 'lista_funcionalidades');
        echo json_encode($output);
    }

    /*
     * Função para gerir as funcionalidades do sistema
     */
    public function funcionalidades($tipo = null, $id = null, $idFunc = null, $edicao= null ) {
        $exists = $this->Analise->find('first', array('conditions' => array('Analise.id' => $id, 'Analise.st_registro' => 'S'), 'fields' => array('sistema_id', 'id','baseline','id_contrato')));
        if (empty($exists)) {
            $this->_flash('Análise não encontrada.', 'error', '/painel/painel');
        }
        $this->Analise->id = $id;
        $this->layout = 'novo';
        $this->dataLock($id, null, $edicao);
        $this->set('tipo', $tipo);
        $items = $this->Item->find('all', array(
            "fields" => array("id",
                "nome", 'valor_pf', 'descricao'),
            'order' => array('nome')
            ,
            'conditions' => array('Item.st_registro' => 'S', 'Item.id_contrato' => $exists['Analise']['id_contrato'])
        ));
        
        $valor_base = $this->Deflatore->find('first');
        $this->set('valor_base', $valor_base);

        $this->set('items', $items);
        $tipoAnalise = $this->Analise->find('first', array(
            "fields" => array(
                "tipo_contagem",
                'metodo_contagem'),
            'conditions' => array('Analise.id' => $id)
                )
        );
        $impactos = ($tipoAnalise['Analise']['tipo_contagem'] == \Dominio\TipoContagem::$contagemAplicação) ? array('1' => 'Inclusão') : \Dominio\TipoImpacto::getTodosImpactos();
        $this->set('impactos', $impactos); 
        $this->getHeader($id); 
        $funcionalidadesAnalise = array();
        $funcionalidades = array(); 
        $funcionalidades = $this->Funcionalidade->find('all', array('conditions' => array(
                'Funcionalidade.st_registro' => 'S',
                'Funcionalidade.analise_id' => $id,
            )), compact('funcionalidades'));
        // contar os pf das funcionalidades dados e transção
        $funcionalidadesAnalise = $this->Funcionalidade->find('all', array('conditions' => array(
                'Funcionalidade.st_registro' => 'S',
                'Funcionalidade.analise_id' => $id,
            )), compact('funcionalidades')); 
        $qtd_dados = 0;
        $qtd_transacao = 0;
        foreach ($funcionalidadesAnalise as $value) { 
            if ($value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI ||
                    $value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) {
                $qtd_dados = $qtd_dados + $value['Funcionalidade']['qtd_pf'];
            } else {
                $qtd_transacao = $qtd_transacao + $value['Funcionalidade']['qtd_pf'];
            }
        } 
        $this->set('qtd_dados', $qtd_dados);
        $this->set('qtd_transacao', $qtd_transacao); 

        $funcionalidades = $this->configFuncionalidades($funcionalidades, $tipoAnalise['Analise']['tipo_contagem']);
        $this->set('funcionalidades', $funcionalidades); 

        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['Funcionalidade']['q'])) { // busca funcionalidades de dados ou transacao
			
                $z = split(' - ', $this->request->data['Funcionalidade']['q']);
				if(!empty($z[1]) ){
					$sistemaBusca = $this->Sistema->find('first', array('fields' => array('id'), 'conditions' => array('st_registro' => 'S', 'nome' => $z[1])));
					$this->getHeader($this->request->data['Funcionalidade']['analise_id']);
					$funcionalidades = $this->Funcionalidade->find('all', array('conditions' => array('Funcionalidade.st_registro' => 'S',
							'Funcionalidade.analise_id' => $this->request->data['Funcionalidade']['analise_id'], 'Funcionalidade.tipo' => $tipo)), compact('funcionalidades'));
					$this->set('funcionalidades', $funcionalidades);
					//BUSCA FUNCIONALIDADES QUE ESTAO NO BASELINE DE TODOS OS SISTEMAS
					$func = $this->Funcionalidade->find('first', array('conditions' => array(
							"Funcionalidade.nome" => "$z[0]",
							'Funcionalidade.tipo' => $tipo,
							'Funcionalidade.sistema_id' => $sistemaBusca['Sistema']['id'],
							'Funcionalidade.baseline' => '0',
							"Funcionalidade.analise_id !=" => $this->data['Funcionalidade']['analise_id'])));
				}else{
					$func = null;
				}	

                $this->Funcionalidade->id = !empty($func['Funcionalidade']['id']) ? $func['Funcionalidade']['id'] : '';
                if ($this->Funcionalidade->exists()) {
                    $this->Funcionalidade->read();
                    $trs = $this->Tdstrsar->find('all', array('conditions' => array('Tdstrsar.funcionalidade_id' => $func['Funcionalidade']['id'],
                            'Tdstrsar.tipo' => '1')));
                    $ars = $this->Tdstrsar->find('all', array('conditions' => array('Tdstrsar.funcionalidade_id' => $func['Funcionalidade']['id'],
                            'Tdstrsar.tipo' => '2')));
                    $tds = $this->Tdstrsar->find('all', array('conditions' =>
                        array('Tdstrsar.funcionalidade_id' => $func['Funcionalidade']['id'], 'Tdstrsar.tipo' => '3')));
                    $resultTrs = '';
                    $resultTds = '';
                    $resultArs = '';
                    if (!empty($trs)) {
                        foreach ($trs as $key => $value) {
                            $resultTrs .= $value['Tdstrsar']['nome'] . '<br>';
                        }
                    }
                    if (!empty($tds)) {
                        foreach ($tds as $k => $v) {
                            $resultTds .= $v['Tdstrsar']['nome'] . '<br>';
                        }
                    }
                    if (!empty($ars)) {
                        foreach ($ars as $ki => $vi) {
                            $resultArs .= $vi['Tdstrsar']['nome'] . '<br>';
                        }
                    }
                    $td = $this->br2nl($resultTds);
                    $tr = $this->br2nl($resultTrs);
                    $ar = $this->br2nl($resultArs);
                    $this->set('td', $td);
                    $this->set('tr', $tr);
                    $this->set('ar', $ar);
                    $this->set('id_busca', $func['Funcionalidade']['id']);
                    $this->set('buscado', $func['Funcionalidade']['id']);
                    $result['Funcionalidade'] = $func['Funcionalidade'];
                    $result['Funcionalidade']['id_antigo'] = $func['Funcionalidade']['id'];
                    $this->set('resultado', $result);
                } else {
                    $this->_flash('Funcionalidade não encontrada.', 'error', '/analises/analises/funcionalidades/' . $tipo . '/' . $this->request->data['Funcionalidade']['analise_id']);
                }
            } else {
                // Campos obrigatorios
                if (empty($this->data['Funcionalidade']['nome']) || empty($this->data['Funcionalidade']['tipo_funcionalidade']) || empty($this->data['Funcionalidade']['impacto'])) {
                    $this->_flash('Preencha os campos obrigatórios!', 'error');
                    return;
                }
                // Valida nome de funcionalidade igual no mesmo sistema
                if (empty($this->data['Funcionalidade']['id']) && empty($this->data['Funcionalidade']['id_busca'])) {
                    $validFuncionalidade = $this->Funcionalidade->find('first', array('conditions' => array('nome' => $this->data['Funcionalidade']['nome'], 'st_registro' => 'S', 'sistema_id' => $exists['Analise']['sistema_id'])));


                    if (!empty($validFuncionalidade) && $validFuncionalidade['Funcionalidade']['baseline'] == 0 && $exists['Analise']['baseline'] == 0) {

                        $this->set('validaBaseline',$validFuncionalidade['Funcionalidade']['analise_id']);
                        //$this->_flash('O nome dessa Funcionalidade já existe no baseline Sistema. Utilize a Busca!', 'error');
                        return;
                    }
                } 
                if (!empty($validFuncionalidade)) {
                    //valida a funcionalidade se ja existe na análise
                    $validFuncionalidadeAnalise = $this->Funcionalidade->find('first', array('conditions' => array('nome' => $this->data['Funcionalidade']['nome'], 'st_registro' => 'S', 'analise_id' => $exists['Analise']['id'])));

                    if (!empty($validFuncionalidadeAnalise)) {
                        $this->_flash('O nome dessa Funcionalidade já existe na análise. Tente novamente!', 'error');
                        return;
                    }
                }  
                $itens = !empty($this->data['Item']) ? $this->data['Item'] : null;
                $id_funcionalidade = $this->saveDados($this->getCalculaAPF($this->data, $tipoAnalise['Analise']['metodo_contagem']), $idFunc, true, $itens);

                if (empty($id_funcionalidade['error'])) {
                    if (isset($this->request->data['Funcionalidade']['associacao']) && $this->request->data['Funcionalidade']['associacao'] == '1') {
                        $this->redirect('/analises/analises/associativa/' . $id_funcionalidade['id'] . '/' . $id);
                    } else {
                        $this->redirect('/analises/analises/funcionalidades/' . $tipo . '/' . $id);
                    }
                    $this->dados = array();
                } else {

                    $id_func = isset($id_funcionalidade['id']) ? $id_funcionalidade['id'] : '';
                    $this->redirect('/analises/analises/funcionalidades/' . $tipo . '/' . $id_funcionalidade['analise'] . '/' . $id_func);
                    $this->dados = array();
                }
            }
        } else { 
            $nomeItens = $this->Item->find('list', array('conditions' => array(
                    'Item.st_registro' => 'S', 'Item.id_contrato' => $exists['Analise']['id_contrato']
                ),
                'fields' => array('id', 'nome')));
            $this->set('nomeItens', $nomeItens);
            $pesoItens = $this->Item->find('list', array('conditions' => array(
                    'Item.st_registro' => 'S'
                ),
                'fields' => array('id', 'valor_pf')));
            $this->set('pesoItens', $pesoItens);
            $dataItensFuncionalidades = array();


            foreach ($funcionalidades as $value) {
                $itensFuncionalidade = $this->Rlitensanalise->find('all', array('conditions' => array(
                        'st_registro' => 'S',
                        'funcionalidade_id' => $value['Funcionalidade']['id']
                ))); 
                if (!empty($itensFuncionalidade)) {
                    foreach ($itensFuncionalidade as $v) {

                        $prepare['funcionalidade'] = $value['Funcionalidade']['nome'];
                        $prepare['funcionalidade_id'] = $value['Funcionalidade']['id'];
                        $prepare['analise_id'] = $id;
                        $prepare['item_id'] = $v['Rlitensanalise']['item_id'];
                        $prepare['rl_id'] = $v['Rlitensanalise']['id'];

                        $prepare['nome'] = $nomeItens[$v['Rlitensanalise']['item_id']];
                        $prepare['peso'] = $pesoItens[$v['Rlitensanalise']['item_id']];
                        $prepare['quantidade'] = $v['Rlitensanalise']['qtde'];
                        $prepare['justificativa'] = $v['Rlitensanalise']['justificativa'];

                        $dataItensFuncionalidades[] = $prepare;
                    }
                }
            }
            $this->set('naomensuravel', $dataItensFuncionalidades);
            if ($idFunc) {

                $func = $this->Funcionalidade->find('first', array('conditions' => array('id' => $idFunc))); 
                $this->Funcionalidade->id = $func['Funcionalidade']['id'];
                if ($this->Funcionalidade->exists()) {
                    $this->Funcionalidade->read();
                    $trs = $this->Tdstrsar->find('all', array('conditions' => array('Tdstrsar.funcionalidade_id' => $func['Funcionalidade']['id'],
                            'Tdstrsar.tipo' => '1')));
                    $ars = $this->Tdstrsar->find('all', array('conditions' => array('Tdstrsar.funcionalidade_id' => $func['Funcionalidade']['id'],
                            'Tdstrsar.tipo' => '2')));
                    $tds = $this->Tdstrsar->find('all', array('conditions' =>
                        array('Tdstrsar.funcionalidade_id' => $func['Funcionalidade']['id'], 'Tdstrsar.tipo' => '3')));
                    $resultTrs = '';
                    $resultTds = '';
                    $resultArs = '';
                    if (!empty($trs)) {
                        foreach ($trs as $key => $value) {
                            $resultTrs .= $value['Tdstrsar']['nome'] . '<br>';
                        }
                    }
                    if (!empty($tds)) {
                        foreach ($tds as $k => $v) {
                            $resultTds .= $v['Tdstrsar']['nome'] . '<br>';
                        }
                    }
                    if (!empty($ars)) {
                        foreach ($ars as $ki => $vi) {
                            $resultArs .= $vi['Tdstrsar']['nome'] . '<br>';
                        }
                    }
                    $tr = $this->br2nl($resultTrs);
                    $td = $this->br2nl($resultTds);
                    $ar = $this->br2nl($resultArs);
                    $this->set('td', $td);
                    $this->set('tr', $tr);
                    $this->set('ar', $ar);
                    $this->set('id', $func['Funcionalidade']['id']); 
                    $resultTotal['Funcionalidade'] = $func['Funcionalidade'];

                    $this->set('resultado', $resultTotal);
                } else {
                    $this->_flash('Funcionalidade não encontrada.', 'error', '/analises/analises/dados/' . $this->request->data['Funcionalidade']['analise_id']);
                }
            }
        }
    }

    public function associativa($idFunc = null, $idAnalise = null) { 
        $this->layout = 'novo';

        $this->getHeader($idAnalise);
        $this->set('funcionalidade', $idFunc);

        $nomeFunc = $this->Funcionalidade->find('first', array('conditions' => array(
                "Funcionalidade.id" => $idFunc),
            'fields' => array('nome')));
        $this->set('nomeFunc', $nomeFunc['Funcionalidade']['nome']);
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['Funcionalidade']['q'])) {
                $z = split(' - ', $this->request->data['Funcionalidade']['q']);


                $func = $this->Funcionalidade->find('first', array('conditions' => array(
                        "Funcionalidade.nome" => "$z[0]",
                        'Funcionalidade.tipo' => array('1', '2'),
                        'Funcionalidade.baseline' => '0'),
                    'fields' => array('id', 'nome', 'sistema_id', 'tipo')));

                $this->Funcionalidade->id = isset($func['Funcionalidade']['id']) ? $func['Funcionalidade']['id'] : '';
                if ($this->Funcionalidade->exists()) {
                    $sistema = $this->Sistema->find('first', array('conditions' => array(
                            "Sistema.id" => $func['Funcionalidade']['sistema_id']),
                        'fields' => array('nome')));
                    $dataFuncionalidade['funcionalidade_id'] = $func['Funcionalidade']['id'];
                    $dataFuncionalidade['nome_sistema'] = $sistema['Sistema']['nome'];
                    $dataFuncionalidade['nome_funcionalidade'] = $func['Funcionalidade']['nome'];
                    $dataFuncionalidade['tipo'] = $func['Funcionalidade']['tipo'];
                    $this->set('dataFuncionalidade', $dataFuncionalidade);
                    //Verifica se já existe TDs associadas e elimina da pesquisa
                    $resultTdsNotIn = $this->Associativa->find('all', array('conditions' => array(
                            'funcionalidade_antiga' => $func['Funcionalidade']['id'],
                            'funcionalidade_nova' => $idFunc,
                            'st_registro' => 'S'
                    )));

                    $tdsNotIn = array();
                    foreach ($resultTdsNotIn as $key => $value) {
                        $tdsNotIn[] = $value['Associativa']['td_id'];
                    }

                    $tds = $this->Tdstrsar->find('all', array('conditions' =>
                        array(
                            'Tdstrsar.funcionalidade_id' => $func['Funcionalidade']['id'],
                            'Tdstrsar.tipo' => '3',
                            "NOT" => array('Tdstrsar.id' => $tdsNotIn)
                        ),
                        'fields' => array('id', 'nome'),
                    )); 
                    $this->set('resultArsAssoc', $tds);
                } else {
                    $this->_flash('Funcionalidade não encontrada.', 'error', '/analises/analises/associativa/' . $idFunc . '/' . $idAnalise);
                }
            } else { 
                $associativa['funcionalidade_nova'] = $this->request->data['Associativa']['funcionalidade_nova'];
                $associativa['funcionalidade_antiga'] = $this->request->data['Associativa']['funcionalidade_antiga'];
                $associativa['analise_id'] = $this->request->data['Associativa']['analise_id'];
                $associativa['sistema'] = $this->request->data['Associativa']['sistema_id'];
                $associativa['user_id'] = $this->request->data['Associativa']['user_id'];
                $associativa['st_registro'] = $this->request->data['Associativa']['st_registro'];
                $arrayAssoc = array();
                $idTds = array(0 => '0');
                foreach ($this->request->data['Associativa']['Td'] as $key => $value) {
                    if ($value == '1') {
                        $td = explode('-', $key);
                        $associativa['td_id'] = $td[1];
                        $associativa['tipo'] = '3';
                        $arrayAssoc[] = $associativa;
                        $idTds[] = $associativa['td_id'];
                    }
                } 
                $TdsAntiga = $this->Tdstrsar->find('all', array('conditions' => array('id IN' => $idTds), 'fields' => 'nome'));
                $arrTdAntiga = array();
                $tdsnome = '';
                $nomeFuncionalidadeAntiga = $this->Funcionalidade->find('first', array(
                    'conditions' => array('id' => $associativa['funcionalidade_antiga']),
                    'fields' => 'nome'));
                foreach ($TdsAntiga as $value) {
                    $arrResult['nome'] = $value['Tdstrsar']['nome'] . ' - ' . $nomeFuncionalidadeAntiga['Funcionalidade']['nome'];
                    $tdsnome .= ' ' . $arrResult['nome'];
                    $arrResult['funcionalidade_id'] = $associativa['funcionalidade_nova'];
                    $arrResult['tipo'] = '3';
                    $arrTdAntiga[] = $arrResult;
                }
                //Salva o nome da funcionalidade como uma TR 
                $nomeFuncionalidadeNova = $this->Funcionalidade->find('first', array(
                    'conditions' => array('id' => $associativa['funcionalidade_nova']),
                    'fields' => 'nome'));

                //verifica se o nome da funcionalidade já foi associado antes
                $retorno = $this->Associativa->find('first', array('conditions' => array('funcionalidade_nova' => $associativa['funcionalidade_nova'], 'funcionalidade_antiga' => $associativa['funcionalidade_antiga'], 'st_registro' => 'S', 'tipo' => '2')));

                if (empty($retorno)) { 
                    $arrFunc['nome'] = $nomeFuncionalidadeAntiga['Funcionalidade']['nome'] . ' - ' . '[A]';
                    $arrFunc['funcionalidade_id'] = $associativa['funcionalidade_nova'];
                    $arrFunc['tipo'] = '2';
                    $arrResultFuncionaliade[] = $arrFunc;
                    $associativaResult = array_merge($arrResultFuncionaliade, $arrTdAntiga); 
                    $this->Tdstrsar->saveMany($associativaResult);
                    //Busca a nova TR para o relacionamento
                    $idFuncionalidadeAntigaTR = $this->Tdstrsar->find('first', array(
                        'conditions' => array('nome' => $arrFunc['nome']),
                        'fields' => 'id')); 
                    if (!empty($idFuncionalidadeAntigaTR)) {
                        $associativa['td_id'] = $idFuncionalidadeAntigaTR['Tdstrsar']['id'];
                        $associativa['tipo'] = '2';
                        $associativa['st_registro'] = 'S';
                        $arrayAssoc[] = $associativa;
                    }
                } else {
                    $this->Tdstrsar->saveMany($arrTdAntiga);
                } 
                $this->recalculaFuncionalidade($associativa['funcionalidade_nova'], $idAnalise);
                if ($this->Associativa->saveMany($arrayAssoc)) {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} associou TDs: {' . $tdsnome . ' } da funcionalidade : ' . $nomeFuncionalidadeAntiga['Funcionalidade']['nome'] . ' na funcionalidade : ' . $nomeFuncionalidadeNova['Funcionalidade']['nome'] . '.', array('analise'));
                    $this->_flash('Funcionalidade associada com sucesso!', 'success', '/analises/analises/associativa/' . $associativa['funcionalidade_nova'] . '/' . $associativa['analise_id'] = $this->request->data['Associativa']['analise_id']);
                } else {
                    CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu associar TDs .', array('analise'));
                    $this->_flash('Funcionalidade não foi associada!', 'error', '/analises/analises/associativa/' . $associativa['funcionalidade_nova'] . '/' . $associativa['analise_id'] = $this->request->data['Associativa']['analise_id']);
                }
            }
        }
    }

    /**
     * recalculaFuncionalidade - Recalcular o valor da funcionalidade após a associação
     * @param type $idFuncionalidade
     */
    public function recalculaFuncionalidade($idFuncionalidade, $idAnalise) {

        $funcionalidade = $this->Funcionalidade->find('first', array(
            'conditions' => array('id' => $idFuncionalidade)));
        $TdTrArs = $this->Tdstrsar->find('all', array('conditions' => array('funcionalidade_id' => $idFuncionalidade),
            'fields' => array('nome', 'tipo')));
        foreach ($TdTrArs as $value) {
            if ($value['Tdstrsar']['tipo'] == '2') {
                $arrAr[] = $value['Tdstrsar']['nome'];
            } else if ($value['Tdstrsar']['tipo'] == '3') {
                $arrTd[] = $value['Tdstrsar']['nome'];
            }
        }
        $ar['ar'] = !empty($arrAr) ? $arrAr : array();
        $td['td'] = !empty($arrTd) ? $arrTd : array();
        $funcionalidade = array_merge($funcionalidade['Funcionalidade'], $ar);
        $funcionalidade = array_merge($funcionalidade, $td);

        unset($funcionalidade['id']);
        unset($funcionalidade['created']);
        unset($funcionalidade['modified']);
        $funcionalidade['item'] = '0';
        $funcionalidade['Item'] = array();
        $analise = $this->Analise->find('first', array('conditions' => array('id' => $idAnalise), 'fields' => array('metodo_contagem')));
        $funcionalidade['metodo_contagem'] = $analise['Analise']['metodo_contagem'];
        $funcionalidade['st_ultimo_registro'] = 'S';
        //$funcionalidade['id_antigo'] = $idFuncionalidade;

        $this->saveDados($this->regrasCalculoAR($funcionalidade), $idFuncionalidade, false);
    }

    /**
     * Savar Funcionalidades na Análise
     * @param type $result
     * @param type $idFunc
     * @return type
     * @throws NotFoundException
     */
    protected function saveDados($result, $idFunc = null, $msg = true, $itens = null) {
        $funcionalidade['Funcionalidade'] = $result;
        $analise = $this->Analise->find('first', array(
            "fields" => array("id", "baseline", "total_pf", "total_pf_itens", "total_pf_ajustado", 'tipo_contagem', 'fator', 'valor_fator', 'id_contrato'),
            "conditions" => array('Analise.id' => $funcionalidade['Funcionalidade']['analise_id'])
                )
        );
        $returnDuplicidade = array();
        //UPDATE na funcionalidade $idFunc vem com o numero 
        if ($idFunc) {
            $funcionalidade['Funcionalidade']['id'] = $idFunc;
            $funcionalidadeAnterior = $this->Funcionalidade->find('first', array(
                "fields" => array(
                    "id",
                    "qtd_pf", 'impacto'
                ),
                "conditions" => array('Funcionalidade.id' => $idFunc)
                    )
            );
            $returnDuplicidade['id'] = $idFunc;
            $analise['Analise']['total_pf'] = $analise['Analise']['total_pf'] - $funcionalidadeAnterior['Funcionalidade']['qtd_pf'];
            $funcionalidade_ajustada = $this->deflatores($funcionalidadeAnterior, $analise);
            $analise['Analise']['total_pf_ajustado'] = $analise['Analise']['total_pf_ajustado'] - ($funcionalidade_ajustada['Funcionalidade']['qtd_pf'] * $analise['Analise']['fator']);
            $analise['Analise']['valor_fator'] = $analise['Analise']['valor_fator'] - ($funcionalidade_ajustada['Funcionalidade']['qtd_pf'] * $analise['Analise']['fator']);
        } 
        //Verifica a duplicidade no nomes das TDs TRs ARs
        $returnDuplicidade = $this->verificaDuplicidadeTdsTrsArs($funcionalidade, $analise, $returnDuplicidade);
        if ($returnDuplicidade['error'] == 'error') {
            return $returnDuplicidade;
        }

        $funcionalidade = $this->validaFuncionalidade($funcionalidade, $analise); 
        if ($this->Funcionalidade->save($funcionalidade)) { 
            if ($idFunc) {
                $id_funcionalidade = $idFunc;
            } else {
                $id_funcionalidade = $this->Funcionalidade->getLastInsertID();
            } 
            //Verifica se está no baseline
            if ($analise['Analise']['baseline'] == '0') {
                $funcionalidade['Funcionalidade']['id'] = $id_funcionalidade;

                $this->atualizaBaseline($funcionalidade);
            }
            $this->Analise->id = $funcionalidade['Funcionalidade']['analise_id'];
            $datasource = $this->Tdstrsar->getDataSource(); 
            //Verifica Duplicidade de TDs ARs TRs e coloca numa transação
            $transacaoTdsTrsArs = true;
            $return['boolean'] = true;

            $this->Tdstrsar->deleteAll(array('Tdstrsar.funcionalidade_id' => $id_funcionalidade, 'Tdstrsar.tipo' => '1'));
            if (isset($funcionalidade['Funcionalidade']['tr'])) {
                $datasource->begin();
                $transacaoTdsTrsArs = $this->configTDTRAR($result['tr'], $id_funcionalidade, '1');
                if (!$transacaoTdsTrsArs) {

                    $return['error'] = 'error';
                    $return['tipo'] = 'TRs';
                    $return['boolean'] = false;
                    $return['analise'] = $analise['Analise']['id'];
                    $return['id'] = $id_funcionalidade;
                    $datasource->rollback();
                }

                $this->Tdstrsar->saveMany($transacaoTdsTrsArs);
                $datasource->commit();
            } 
            $this->Tdstrsar->deleteAll(array('Tdstrsar.funcionalidade_id' => $id_funcionalidade, 'Tdstrsar.tipo' => '2'));
            if (isset($funcionalidade['Funcionalidade']['ar'])) {
                $transacaoTdsTrsArs = $this->configTDTRAR($result['ar'], $id_funcionalidade, '2');
                $datasource->begin();
                if (!$transacaoTdsTrsArs) {
                    $return['error'] = 'error';
                    $return['tipo'] = 'ARs';
                    $return['boolean'] = false;
                    $return['analise'] = $analise['Analise']['id'];
                    $return['id'] = $id_funcionalidade;
                    $datasource->rollback();
                }
                $this->Tdstrsar->saveMany($transacaoTdsTrsArs);
                $datasource->commit();
            }

            $this->Tdstrsar->deleteAll(array('Tdstrsar.funcionalidade_id' => $id_funcionalidade, 'Tdstrsar.tipo' => '3'));
            if (isset($funcionalidade['Funcionalidade']['td'])) {
                $transacaoTdsTrsArs = $this->configTDTRAR($result['td'], $id_funcionalidade, '3');
                $datasource->begin();
                if (!$transacaoTdsTrsArs) {
                    $return['error'] = 'error';
                    $return['analise'] = $analise['Analise']['id'];
                    $return['tipo'] = 'TDs';
                    $return['boolean'] = false;
                    $return['id'] = $id_funcionalidade;
                    $datasource->rollback();
                }
                $this->Tdstrsar->saveMany($transacaoTdsTrsArs);
                $datasource->commit();
            }

            $tdsAssociadas = $transacaoTdsTrsArs; 
            //Calcula PF é responsável por inativar uma funcionalidade caso a mesma for pesquisada e substituida por outra
            $saveAnalise = $this->calculaPF($analise, $funcionalidade, $itens, $id_funcionalidade);

            // Apenas funcionalidades editadas entram nessa função para desassociar possiveis TRs e TDs antigos
            $this->desassociar($tdsAssociadas, $id_funcionalidade);

            if ($result['item'] === '1' && $itens != null) {
                $this->Rlitensanalise->saveMany($this->saveItensAFDFT($itens, $id_funcionalidade));
            } 
            $this->Analise->save($saveAnalise);
            if ($msg) {
                CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou/alterou a funcionalidade : '
                        . $funcionalidade['Funcionalidade']['nome'] . ' o valor da análise ID: ' . $analise['Analise']['id'] . ' foi alterado para Valor PF : ' .
                        $saveAnalise['Analise']['total_pf'] .
                        ' , Valor PF Ajustado : ' . $saveAnalise['Analise']['valor_fator']
                        . ' . O valor anterior da análise era  Valor PF : ' .
                        $analise['Analise']['total_pf'] .
                        ' , Valor PF Ajustado : ' . $analise['Analise']['valor_fator'] . " ."
                        , array('analise'));

                if (empty($funcionalidade['Funcionalidade']['associacao'])) {
                    $this->_flash('Funcionalidade foi salva.', 'success');
                }
            }
            $retorno['id'] = $id_funcionalidade;

            return $retorno;
        } else {
            if ($msg) {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar/alterar a funcionalidade : ' . $funcionalidade['Funcionalidade']['nome'] . '.', array('analise'));
                $this->_flash('Funcionalidade não foi salva.', 'error');
            }
        }
    }

    /**
     * Valida se a funcionalidade deve ou nao figurar o baseline
     * @param type $funcionalidade
     * @param type $analise
     * @return string
     */
    public function validaFuncionalidade($funcionalidade, $analise) {
        // Verifica se a funcionalidade foi buscada no baseline e cadastra uma nova
        if (!empty($funcionalidade['Funcionalidade']['buscado'])) {
            $funcionalidade['Funcionalidade']['id'] = null;
        }
        //Se a análise não pertencer ao baseline a funcionalidade não entra no baseline
        if ($analise['Analise']['baseline'] == '1') {
            $funcionalidade['Funcionalidade']['baseline'] = '1';
        } else {
            //valida caso a funcionalidade for editada e tiver um vinculo com outra funcionalidade que esteja no baseline
            if (!empty($funcionalidade['Funcionalidade']['id'])) {
                $returnVinculoFuturo = $this->verificaVinculoFuturo($funcionalidade, $analise['Analise']['baseline']);
                if ($returnVinculoFuturo) {
                    $funcionalidade['Funcionalidade']['baseline'] = '1';
                    $funcionalidade['Funcionalidade']['autocomplete'] = 'N';
                    return $funcionalidade;
                }
            }
            $funcionalidade['Funcionalidade']['baseline'] = '0';
        }
        //Verifica se a funcionalidade é de exclusão e retira do baseline
        if ($funcionalidade['Funcionalidade']['impacto'] == '3') {
            $funcionalidade['Funcionalidade']['baseline'] = '1';
            $funcionalidade['Funcionalidade']['autocomplete'] = 'N';
        }
        //Verifica se a funcionalidade é de outro Sistema, Caso positivo ela perde o relacionamento de ID_ANTIGO
        $funcionalidadeAntiga = $this->Funcionalidade->find('first', array('conditions' => array('id' => $funcionalidade['Funcionalidade']['id_antigo'], 'baseline' => '0')));
        if (!empty($funcionalidadeAntiga)) {
            if ($funcionalidadeAntiga['Funcionalidade']['sistema_id'] != $funcionalidade['Funcionalidade']['sistema_id']) {
                $funcionalidade['Funcionalidade']['id_antigo'] = null;
            }
        }
        //Verifica se a funcionalidade foi buscada, e inativa a funcionalidade buscada caso o a Analise atual reflita no baseline
        if (!empty($funcionalidade['Funcionalidade']['id_antigo']) && $analise['Analise']['baseline'] == '0') {
            $funcionalidadeUpdate['Funcionalidade']['id'] = $funcionalidade['Funcionalidade']['id_antigo'];
            $funcionalidadeUpdate['Funcionalidade']['baseline'] = '1';
            $funcionalidadeUpdate['Funcionalidade']['autocomplete'] = 'N';
            $funcionalidadeUpdate['Funcionalidade']['sistema_id'] = $funcionalidade['Funcionalidade']['sistema_id'];

            $this->Funcionalidade->save($funcionalidadeUpdate);
            $this->atualizaBaseline($funcionalidadeUpdate);
        }
        return $funcionalidade;
    }

    public function verificaDuplicidadeTdsTrsArs($funcionalidade, $analise, $returnDuplo) {
        $nomes = array(); 
        if (!empty($funcionalidade['Funcionalidade']['tr'])) {
            //verifica duplicidade TR
            $duplicidade = true;
            foreach ($funcionalidade['Funcionalidade']['tr'] as $value) {
                $nomes[] = strtoupper(trim($value));
            }

            if (!empty($nomes)) {
                //valida a ocorrencia dos TDs ARs e TRs
                $count = array_count_values($nomes);
                foreach ($count as $v) {
                    if ($v > 1) {
                        $duplicidade = false;
                    }
                }
            }

            if (!$duplicidade) {
                $this->_flash('Não é permitido cadastrar TR com o mesmo nome em uma Funcionalidade.', 'error');
                $returnDuplo['error'] = 'error';
                $returnDuplo['analise'] = $analise['Analise']['id'];
                return $returnDuplo;
            }
        }
        $nomes = array();
        if (!empty($funcionalidade['Funcionalidade']['td'])) {
            //verifica duplicidade TD
            $duplicidade = true;
            foreach ($funcionalidade['Funcionalidade']['td'] as $value) {
                $nomes[] = strtoupper(trim($value));
            }
            if (!empty($nomes)) {
                //valida a ocorrencia dos TDs ARs e TRs
                $count = array_count_values($nomes);
                foreach ($count as $v) {
                    if ($v > 1) {
                        $duplicidade = false;
                    }
                }
            }
            if (!$duplicidade) {
                $this->_flash('Não é permitido cadastrar TD com o mesmo nome em uma Funcionalidade.', 'error');
                $returnDuplo['error'] = 'error';
                $returnDuplo['analise'] = $analise['Analise']['id'];
                return $returnDuplo;
            }
        }
        $nomes = array();
        if (!empty($funcionalidade['Funcionalidade']['ar'])) {
            //verifica duplicidade TD
            $duplicidade = true;
            foreach ($funcionalidade['Funcionalidade']['ar'] as $value) {
                $nomes[] = strtoupper(trim($value));
            }
            if (!empty($nomes)) {
                //valida a ocorrencia dos TDs ARs e TRs
                $count = array_count_values($nomes);
                foreach ($count as $v) {
                    if ($v > 1) {
                        $duplicidade = false;
                    }
                }
            }
            if (!$duplicidade) {
                $this->_flash('Não é permitido cadastrar AR com o mesmo nome em uma Funcionalidade.', 'error');
                $returnDuplo['error'] = 'error';
                $returnDuplo['analise'] = $analise['Analise']['id'];
                return $returnDuplo;
            }
        }
    }

    public function desassociar($tdsNovos, $idFunc) {

        $assoc = $this->Associativa->find('all', array('conditions' => array('funcionalidade_antiga' => $idFunc
                , 'st_registro' => 'S'), 'fields' => array('DISTINCT  funcionalidade_nova'))); 
        if (empty($assoc)) {
            return;
        }

        $tds = $this->Associativa->find('all', array('conditions' => array('funcionalidade_antiga' => $idFunc
                , 'st_registro' => 'S'), 'fields' => array('td_id', 'id'))); 
        $nomeFuncionalidadeAntiga = $this->Funcionalidade->find('first', array('conditions' => array('id' => $idFunc
                , 'st_registro' => 'S'), 'fields' => array('nome')));

        $tdNome = array();
        $nomesTdsNovos = array(); 
        foreach ($tdsNovos as $value) {
            $nomesTdsNovos[] = $value['Tdstrsar']['nome'];
        } 
        foreach ($tds as $v) {
            $tdValor = $this->Thtdstrsar->findByid_td($v['Associativa']['td_id']); 
            $comparaTd = $tdValor['Thtdstrsar']['nome'] . ' - ' . $nomeFuncionalidadeAntiga['Funcionalidade']['nome']; 
            if (!in_array($comparaTd, $nomesTdsNovos))
                $tdNomeDesassociar[] = $v['Associativa']['id'];
        } 
        $arrAssoc = array();
        foreach ($tdNomeDesassociar as $value) {
            $associativa['id'] = $value;
            $associativa['st_registro'] = 'N';
            $arrAssoc[] = $associativa;
        }

        if (!empty($arrAssoc)) {
            $this->Associativa->saveMany($arrAssoc);
        }
    }

    public function itens($id = null) {
        $exists = $this->Analise->find('first', array('conditions' => array('Analise.id' => $id, 'Analise.st_registro' => 'S')));
        $this->Analise->id = $id;
        if (empty($exists)) {
            $this->_flash('Análise não encontrada.', 'error', '/painel/painel');
        }
        $this->dataLock($id);
        $this->getHeader($id);
        $this->layout = 'novo';
        $items = $this->Item->find('all', array(
            "fields" => array("id",
                "nome", 'valor_pf', 'descricao'),
            'order' => array('nome')
            ,
            'conditions' => array('Item.st_registro' => 'S', 'Item.id_contrato' => $exists['Analise']['id_contrato'])
        ));
        $this->set('items', $items);
        $naomensuravel = $this->Rlitensanalise->find('all', array('conditions' => array(
                'st_registro' => 'S',
                'analise_id' => $id
        )));


        $this->set('naomensuravel', $naomensuravel);
        $nomeItens = $this->Item->find('list', array('conditions' => array(
                'Item.st_registro' => 'S'
            ),
            'fields' => array('id', 'nome')));
        $this->set('nomeItens', $nomeItens);
        $pesoItens = $this->Item->find('list', array('conditions' => array(
                'Item.st_registro' => 'S'
            ),
            'fields' => array('id', 'valor_pf')));
        $this->set('pesoItens', $pesoItens);


        $funcionalidadesAnalise = array();

        $funcionalidadesAnalise = $this->Funcionalidade->find('all', array('conditions' => array(
                'Funcionalidade.st_registro' => 'S',
                'Funcionalidade.analise_id' => $id,
            )), compact('funcionalidades'));
//        


        $qtd_dados = 0;
        $qtd_transacao = 0;
        foreach ($funcionalidadesAnalise as $value) {


            if ($value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI ||
                    $value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) {
                $qtd_dados = $qtd_dados + $value['Funcionalidade']['qtd_pf'];
            } else {
                $qtd_transacao = $qtd_transacao + $value['Funcionalidade']['qtd_pf'];
            }
        } 
        $this->set('qtd_dados', $qtd_dados);
        $this->set('qtd_transacao', $qtd_transacao); 
        if ($this->request->is('post') || $this->request->is('put')) {  
            $retornaSaveItens = $this->configItems($this->request->data['Rlitensanalise']['Item'], $id);

            if ($retornaSaveItens) {
                $saveItens = $this->Rlitensanalise->saveMany($retornaSaveItens); 
                $analise = $this->Analise->find('first', array(
                    "fields" => array(
                        "id",
                        "total_pf_itens",
                        "total_pf_ajustado",
                        'total_pf',
                        'valor_fator'
                    ),
                    "conditions" => array('Analise.id' => $id)
                        )
                ); 
                $saveAnalise['Analise']['id'] = $analise['Analise']['id']; 
                $saveAnalise['Analise']['total_pf_itens'] = $analise['Analise']['total_pf_itens'] + $this->calculaItem($this->request->data['Rlitensanalise']['Item']);
                $saveAnalise['Analise']['valor_fator'] = $analise['Analise']['total_pf_itens'] + $this->calculaItem($this->request->data['Rlitensanalise']['Item']);

                $this->Analise->save($saveAnalise);
                $this->data = array();
                if ($saveItens) {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou Itens a análise ID: {' . $id . '} . ', array('item'));
                    $this->_flash('Itens cadastrados com sucesso.', 'success', '/analises/analises/itens/' . $id);
                } else {
                    CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar Itens a análise ID: {' . $id . '} . ', array('item'));
                    $this->_flash('Itens não foram cadastrados.', 'error', '/analises/analises/itens/' . $id);
                }
            }
        }
    }

    public function usts($id = null) {
        $exists = $this->Analise->find('first', array('conditions' => array('Analise.id' => $id, 'Analise.st_registro' => 'S')));
        $this->Analise->id = $id;
        if (empty($exists)) {
            $this->_flash('Análise não encontrada.', 'error', '/painel/painel');
        }
        $this->dataLock($id);
        $this->getHeader($id);
        $this->layout = 'novo';
        $items = $this->Ust->find('all', array(
            "fields" => array("id",
                "nome", 'valor_pf', 'descricao'),
            'order' => array('nome')
            ,
            'conditions' => array('Ust.st_registro' => 'S')
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
        $funcionalidadesAnalise = array(); 
        $funcionalidadesAnalise = $this->Funcionalidade->find('all', array('conditions' => array(
                'Funcionalidade.st_registro' => 'S',
                'Funcionalidade.analise_id' => $id,
            )), compact('funcionalidades')); 
        $qtd_dados = 0;
        $qtd_transacao = 0;
        foreach ($funcionalidadesAnalise as $value) { 
            if ($value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI ||
                    $value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) {
                $qtd_dados = $qtd_dados + $value['Funcionalidade']['qtd_pf'];
            } else {
                $qtd_transacao = $qtd_transacao + $value['Funcionalidade']['qtd_pf'];
            }
        }

        $this->set('qtd_dados', $qtd_dados);
        $this->set('qtd_transacao', $qtd_transacao); 
        if ($this->request->is('post') || $this->request->is('put')) { 
            $retornaSaveItens = $this->configItems($this->request->data['Rlitensanalise']['Item'], $id);

            if ($retornaSaveItens) {
                $saveItens = $this->Rlitensanalise->saveMany($retornaSaveItens); 
                $analise = $this->Analise->find('first', array(
                    "fields" => array(
                        "id",
                        "total_pf_itens",
                        "total_pf_ajustado",
                        'total_pf',
                        'valor_fator'
                    ),
                    "conditions" => array('Analise.id' => $id)
                        )
                );

                $saveAnalise['Analise']['id'] = $analise['Analise']['id'];
                $saveAnalise['Analise']['total_pf_itens'] = $analise['Analise']['total_pf_itens'] + $this->calculaItem($this->request->data['Rlitensanalise']['Item']);
                $saveAnalise['Analise']['valor_fator'] = $analise['Analise']['valor_fator'] + $this->calculaItem($this->request->data['Rlitensanalise']['Item']);
                $this->Analise->save($saveAnalise);
                $this->data = array();
                if ($saveItens) {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou Itens a análise ID: {' . $id . '} . ', array('item'));
                    $this->_flash('Itens cadastrados com sucesso.', 'success', '/analises/analises/itens/' . $id);
                } else {
                    CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar Itens a análise ID: {' . $id . '} . ', array('item'));
                    $this->_flash('Itens não foram cadastrados.', 'error', '/analises/analises/itens/' . $id);
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
            "tipo_contagem",
            "metodo_contagem",
            "total_pf",
            "valor_fator",
            "created",
            "baseline"
        );
        $sTable = 'analises';
        $this->autoRender = false;
        $role = $this->Session->read('Auth.User.role_id');
        $equipe = $this->Session->read('Equipe_id');
        $aConditions = '';
        if ($role != '1') {
            $aConditions .= ' AND equipe_id =  ' . $equipe;
        } elseif ($role == '1' && !empty($equipe)) {
            $aConditions .= ' AND equipe_id =  ' . $equipe;
        }
         
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions, 'lista_analises');
        $output['aaData'] = $this->retornaGrid($output['aaData']); 
        echo json_encode($output);
    }

    /**
     * Autocomplete da FD
     * @param type $id_sistema
     * @param type $id_analise
     * @param type $tipo
     */
    public function autocomplete($id_sistema, $id_analise, $tipo, $metodo_contagem) {
        Configure::write('debug', 0);
        $this->layout = '';

        $sistemas = $this->Sistema->find('list', array('fields' => array('id', 'nome'), 'conditions' => array('st_registro' => 'S')));


        $params = array(
            'Funcionalidade.st_registro' => 'S',
            'Funcionalidade.analise_id !=' => $id_analise,
            'Funcionalidade.tipo' => $tipo,
            'Funcionalidade.baseline' => '0',
            'Funcionalidade.nome LIKE ' => '%' . $this->params['url']['term'] . '%');
        if ($tipo == '2') {
            $params['sistema_id'] = $id_sistema;
        }


        $funcionalidades = $this->Funcionalidade->find('all', array(
            'conditions' =>
            $params,
            'fields' => array('Funcionalidade.id', 'Funcionalidade.nome', 'Funcionalidade.sistema_id')));


        $arrFuncionalidades = array();
        foreach ($funcionalidades as $value) {
            $value['Funcionalidade']['sistema_id'] = $sistemas[$value['Funcionalidade']['sistema_id']];
            $arrFuncionalidades[] = $value;
        }

        $funcionalidadesArray = Set::extract($arrFuncionalidades, '{n}.Funcionalidade');
        echo $this->params['url']['callback'] . '(' . json_encode($funcionalidadesArray) . ')';
        exit;
    }

    /**
     * Autocomplete da FT.
     * @param type $id_sistema
     */
    public function autocompleteAR($id_sistema) {
        Configure::write('debug', 0);
        $this->layout = '';

        $sistemas = $this->Sistema->find('list', array('fields' => array('id', 'nome'), 'conditions' => array('st_registro' => 'S')));


        $funcionalidades = $this->Funcionalidade->find('all', array('conditions' =>
            array(
                'Funcionalidade.st_registro' => 'S',
                'Funcionalidade.baseline' => '0',
                'Funcionalidade.tipo' => '1',
                'Funcionalidade.sistema_id' => $id_sistema,
                'Funcionalidade.nome LIKE ' => '%' . $this->params['url']['term'] . '%'),
            'fields' => array('id', 'nome', 'sistema_id')));
        $arrFuncionalidades = array();
        foreach ($funcionalidades as $value) {
            $value['Funcionalidade']['sistema_id'] = $sistemas[$value['Funcionalidade']['sistema_id']];
            $arrFuncionalidades[] = $value;
        }
        $funcionalidadesArray = Set::extract($arrFuncionalidades, '{n}.Funcionalidade');
        echo $this->params['url']['callback'] . '(' . json_encode($funcionalidadesArray) . ')';
        exit;
    }

    /**
     * gettipos - Pesquisa AR TR TD de uma funcionalidade e retorna em uma modal
     */
    public function gettipos() {

        $id = $_POST['id'];
        Configure::write('debug', 0);
        $this->layout = '';
        $ars = $this->Tdstrsar->find('all', array('conditions' =>
            array(
                'Tdstrsar.funcionalidade_id' => $id,
                'Tdstrsar.tipo' => \Dominio\Tdtrar::$AR),
            'fields' => array('id', 'nome', 'tipo')));
        $trs = $this->Tdstrsar->find('all', array('conditions' =>
            array(
                'Tdstrsar.funcionalidade_id' => $id,
                'Tdstrsar.tipo' => \Dominio\Tdtrar::$TR),
            'fields' => array('id', 'nome', 'tipo')));
        $tds = $this->Tdstrsar->find('all', array('conditions' =>
            array(
                'Tdstrsar.funcionalidade_id' => $id,
                'Tdstrsar.tipo' => \Dominio\Tdtrar::$TD),
            'fields' => array('id', 'nome', 'tipo')));
        $funcionalidade = $this->Funcionalidade->find('first', array('conditions' =>
            array(
                'Funcionalidade.id' => $id),
            'fields' => array('nome', 'tipo_funcionalidade')));

        $this->set('funcionalidade', $funcionalidade['Funcionalidade']);


        $this->set('tds', $tds);
        $this->set('trs', $trs);
        $this->set('ars', $ars);
    }

    /**
     * gettipos - Pesquisa AR TR TD de uma funcionalidade e retorna em uma modal
     */
    public function gettiposrelatorio() {

        $id = $_POST['id'];
        Configure::write('debug', 0);
        $this->layout = '';
        $ars = $this->Tdstrsar->find('all', array('conditions' =>
            array(
                'Tdstrsar.funcionalidade_id' => $id,
                'Tdstrsar.tipo' => \Dominio\Tdtrar::$AR),
            'fields' => array('id', 'nome', 'tipo')));
        $trs = $this->Tdstrsar->find('all', array('conditions' =>
            array(
                'Tdstrsar.funcionalidade_id' => $id,
                'Tdstrsar.tipo' => \Dominio\Tdtrar::$TR),
            'fields' => array('id', 'nome', 'tipo')));
        $tds = $this->Tdstrsar->find('all', array('conditions' =>
            array(
                'Tdstrsar.funcionalidade_id' => $id,
                'Tdstrsar.tipo' => \Dominio\Tdtrar::$TD),
            'fields' => array('id', 'nome', 'tipo')));
        $funcionalidade = $this->Funcionalidade->find('first', array('conditions' =>
            array(
                'Funcionalidade.id' => $id),
            'fields' => array('nome', 'tipo_funcionalidade')));

        $this->set('funcionalidade', $funcionalidade['Funcionalidade']);


        $this->set('counttds', count($tds));
        $this->set('counttrs', count($trs));
        $this->set('countars', count($ars));

        $this->set('tds', $tds);
        $this->set('trs', $trs);
        $this->set('ars', $ars);
    }

    /**
     * Rastreabilidade - Rastrea se antes de excluir uma Funcionalidade ela não tem TDs referenciadas em outras Funcionalidades
     */
    public function rastreabilidade() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        Configure::write('debug', 0);
        $this->layout = '';


        $assoc = $this->Associativa->find('all', array('conditions' => array('funcionalidade_antiga' => $id
                , 'st_registro' => 'S'), 'fields' => array('DISTINCT  funcionalidade_nova')));


        if (empty($assoc)) {
            return;
        }

        $tds = $this->Associativa->find('all', array('conditions' => array('funcionalidade_antiga' => $id
                , 'st_registro' => 'S'), 'fields' => array('td_id', 'funcionalidade_nova')));
        $tdNome = array();
        $resultado = array();
        $sistemas = $this->Sistema->find('list', array('conditions' => array('st_registro' => 'S'), 'fields' => array('id', 'nome')));
        foreach ($assoc as $value) {
            $funcionalidade = $this->Funcionalidade->find('first', array('conditions' => array('id' => $value['Associativa']['funcionalidade_nova'], 'st_registro' => 'S'), 'fields' => array('nome', 'sistema_id')));
            if (!empty($funcionalidade)) {
                $result['funcionalidade'] = $funcionalidade['Funcionalidade']['nome'];
                $result['sistema'] = $sistemas[$funcionalidade['Funcionalidade']['sistema_id']];
                foreach ($tds as $v) {
                    if ($v['Associativa']['funcionalidade_nova'] == $value['Associativa']['funcionalidade_nova']) {
                        $tdValor = $this->Thtdstrsar->findByid_td($v['Associativa']['td_id']);
                        $tdNome[] = $tdValor['Thtdstrsar']['nome'];
                    }
                }
                $result['tds'] = $tdNome;
                $resultado[] = $result;
            }
            $tdNome = array();
        }

        $this->set('resultado', $resultado);
    }

    /**
     * gettiposhistorico - Pesquisa AR TR TD de uma funcionalidade e retorna em uma modal no histórico da análise
     */
    public function gettiposhistorico() {
        $id = $_POST['id'];
        $history = $_POST['history'];
        Configure::write('debug', 0);
        $this->layout = '';


        $ars = $this->Thtdstrsar->find('all', array('conditions' =>
            array(
                'Thtdstrsar.funcionalidade_id' => $id,
                'Thtdstrsar.history' => $history,
                'Thtdstrsar.tipo' => \Dominio\Tdtrar::$AR),
            'fields' => array('id', 'nome', 'tipo')));

        $trs = $this->Thtdstrsar->find('all', array('conditions' =>
            array(
                'Thtdstrsar.funcionalidade_id' => $id,
                'Thtdstrsar.history' => $history,
                'Thtdstrsar.tipo' => \Dominio\Tdtrar::$TR),
            'fields' => array('id', 'nome', 'tipo')));
        $tds = $this->Thtdstrsar->find('all', array('conditions' =>
            array(
                'Thtdstrsar.funcionalidade_id' => $id,
                'Thtdstrsar.history' => $history,
                'Thtdstrsar.tipo' => \Dominio\Tdtrar::$TD),
            'fields' => array('id', 'nome', 'tipo')));
        $funcionalidade = $this->Thfuncionalidade->find('first', array('conditions' =>
            array(
                'Thfuncionalidade.id' => $id),
            'fields' => array('nome', 'tipo_funcionalidade')));
        $this->set('funcionalidade', $funcionalidade['Thfuncionalidade']);
        $this->set('tds', $tds);
        $this->set('trs', $trs);
        $this->set('ars', $ars);
    }

    /**
     * Compara duas análises
     */
    public function compara() {
        $this->layout = 'novo';
        $sistemas = $this->Sistema->find('list', array(
            "fields" => array("id", "nome"),
            'conditions' => array('Sistema.st_registro' => 'S'),
            'order' => array('Sistema.nome')));
        $this->set('sistemas', $sistemas);
        if ($this->request->is('post') || $this->request->is('put')) {

            $analises = $this->Analise->find('all', array(
                'conditions' => array(
                    'Analise.nu_demanda ' => $this->request->data['Analise']['demanda'],
                    'Analise.sistema_id' => $this->request->data['Analise']['sistema_id'],
                    'Analise.st_registro' => 'S'//,
                  //  'Analise.baseline' => '0' retira a orbigatoriedade do baseline
					),
                'fields' => array('id',
                    'valor_fator',
                    'tipo_contagem', 'metodo_contagem', 'nu_demanda', 'total_pf', 'total_pf_ajustado', 'fase_id', 'sistema_id', 'created', 'total_pf_itens')
                    )
            );
		
            $result = array();
            foreach ($analises as $key => $value) {
                $funcionalidades = $this->Funcionalidade->find('all', array(
                    'conditions' => array(
                        'Funcionalidade.analise_id ' => $value['Analise']['id'],
                        'Funcionalidade.st_registro' => 'S'),
                    'fields' => array('id', 'nome', 'tipo_funcionalidade', 'complexidade', 'impacto', 'qtd_pf', 'observacao')
                        )
                );
                $fase = $this->Fase->find('first', array(
                    'conditions' => array(
                        'Fase.id ' => $value['Analise']['fase_id'],
                        'Fase.st_registro' => 'S'),
                    'fields' => array('nome')
                        )
                );
                $value['Analise']['fase_id'] = isset($fase['Fase']['nome']) ? $fase['Fase']['nome'] : $value['Analise']['fase_id'];
                $result[$key] = $value;
                $result[$key]['Funcionalidade'] = $this->configFuncionalidades($funcionalidades);
            }
            if (!empty($result)) {
                $this->set('result', $result);
            } else {
                $this->_flash('Nenhum registro encontrado.', 'error', '/analises/analises/compara');
            }

            $this->set('result', $result);
        }
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
                'fields' => array('id', 'tipo_contagem', 'metodo_contagem', 'nu_demanda', 'total_pf', 'total_pf_ajustado', 
				'fase_id', 'sistema_id', 'created', 'valor_fator', 'total_pf_itens' ),
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
     * dataLock - Bloqueia a Análise ou verifica se ela está bloqueada
     * @param type $id
     * @param type $status
     */
    public function dataLock($id, $status = null, $edicao = null) {
        if ($this->Session->read('Auth.User.role_id') != '1') {
            $equipeUser = $this->Session->read('Equipe_id');
            $verificaAnaliseEquipe = $this->Analise->find('first', array('conditions' => array('Analise.id' => $id)));

            if ($verificaAnaliseEquipe['Analise']['equipe_id'] != $equipeUser) {
                $this->_flash('Você não tem permissão para acessar essa análise.', 'error', '/painel');
                return;
            }
        }

        $datalock = $this->Datalock->find('first', array('conditions' => array(
                'Datalock.analise_id' => $id,
                'Datalock.st_registro' => 'S',
            'Datalock.tipo' => 'I'
        )));
        if(!$edicao){
            if (!$status) {
                if (empty($datalock)) {
                    $data['Datalock']['analise_id'] = $id;
                    $data['Datalock']['st_registro'] = 'S';
                    $data['Datalock']['user_id'] = $this->Session->read('Auth.User.id');
                    $data['Datalock']['lock'] = 'S';
                    $data['Datalock']['tipo'] = 'I';
                    $this->Datalock->save($data);
                } else {
                    if ($datalock['Datalock']['st_registro'] == 'S' && $datalock['Datalock']['user_id'] != $this->Session->read('Auth.User.id')) {
                        $this->_flash('A análise foi acessada por outro usuário, impossível acessar neste momento.', 'error', '/painel');
                    }
                }
            } else if ($status == 'desbloquear') {
                $data['Datalock']['id'] = $datalock['Datalock']['id'];
                $data['Datalock']['st_registro'] = 'N';
                $data['Datalock']['lock'] = 'N';
                $data['Datalock']['tipo'] = 'I';
                $this->Datalock->save($data);
                $this->createHistory($id);
                CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} desbloqueou análise ID: {' . $id . '} . ', array('analise'));
                $this->_flash('A análise foi desbloqueada.', 'success', '/painel');

            } else {
                $data['Datalock']['id'] = $datalock['Datalock']['id'];
                $data['Datalock']['st_registro'] = 'N';
                $data['Datalock']['lock'] = 'N';
                $data['Datalock']['tipo'] = 'I';
                $this->Datalock->save($data);
                CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} desbloqueou análise ID: {' . $id . '} . ', array('analise'));
                $this->_flash('A análise foi desbloqueada.', 'success', '/painel');
            }
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
                'Datalock.st_registro' => 'S'
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
        $this->getHeader($id);
        $funcionalidades = $this->Funcionalidade->find('all', array('conditions' => array('Funcionalidade.st_registro' => 'S',
                'Funcionalidade.analise_id' => $id),
                'order' => array('Funcionalidade.tipo' => 'desc')), 
                compact('funcionalidades'));

        $tipoAnalise = $this->Analise->find('first', array(
            "fields" => array(
                "tipo_contagem", 'id_contrato'),
            'conditions' => array('Analise.id' => $id)
                )
        );

        $funcionalidades = $this->configFuncionalidades($funcionalidades, $tipoAnalise['Analise']['tipo_contagem']);
        $qtd_dados = 0;
        $qtd_transacao = 0;
        foreach ($funcionalidades as $key => $value) {
            if ($value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI ||
                    $value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) {
                $qtd_dados = $qtd_dados + $value['Funcionalidade']['qtd_pf'];
            } else {
                $qtd_transacao = $qtd_transacao + $value['Funcionalidade']['qtd_pf'];
            }
        }


        $this->set('funcionalidades', $funcionalidades);
        $this->set('qtd_dados', $qtd_dados);
        $this->set('qtd_transacao', $qtd_transacao);
        $nomeItens = $this->Item->find('list', array('conditions' => array(
                'Item.st_registro' => 'S'
            ),
            'fields' => array('id', 'nome')));
        $this->set('nomeItens', $nomeItens);
        $contrato = $this->Contrato->find("first", array('conditions' => array('id' => $tipoAnalise['Analise']['id_contrato'])));
       
        $this->set('valor_base', $contrato);

        $pesoItens = $this->Item->find('list', array('conditions' => array(
                'Item.st_registro' => 'S'
            ),
            'fields' => array('id', 'valor_pf')));
        $this->set('pesoItens', $pesoItens);

        $prepare = array();
        $dataItensFuncionalidades = array();
        foreach ($funcionalidades as $value) {
            $itensFuncionalidade = $this->Rlitensanalise->find('all', array('conditions' => array(
                    'st_registro' => 'S',
                    'funcionalidade_id' => $value['Funcionalidade']['id']
            )));

            if (!empty($itensFuncionalidade)) {
                foreach ($itensFuncionalidade as $v) {

                    $prepare['funcionalidade'] = $value['Funcionalidade']['nome'];
                    $prepare['nome'] = $nomeItens[$v['Rlitensanalise']['item_id']];
                    $prepare['peso'] = $pesoItens[$v['Rlitensanalise']['item_id']];
                    $prepare['quantidade'] = $v['Rlitensanalise']['qtde'];
                    $prepare['justificativa'] = $v['Rlitensanalise']['justificativa'];


                    $dataItensFuncionalidades[] = $prepare;
                }
            }
        }


        $this->set('naomensuravelFuncionalidade', $dataItensFuncionalidades);
        $naomensuravelAnalise = $this->Rlitensanalise->find('all', array('conditions' => array(
                'st_registro' => 'S',
                'analise_id' => $id
        )));



        $this->set('naomensuravelAnalise', $naomensuravelAnalise);
        $result = $this->getResumo($funcionalidades);


        $this->set('imprimir', $acao);
        $this->set('result', $result);
    }

    /**
     * Histórico de uma analise.
     * @param type $id
     */
    public function history($id) {
        $this->layout = 'novo';
        $th = $this->Thanalise->find('all', array('conditions' => array('analise_id' => $id, 'history != ' => '')));
        $result = array();
        if (!empty($th)) {
            foreach ($th as $value) {
                $funcionalidades = $this->Thfuncionalidade->find('all', array('conditions' => array('history' => $value['Thanalise']['history'], 'st_registro' => 'S')));
                $user = $this->User->find('first', array('conditions' => array('id' => $value['Thanalise']['user_id'])));
                $value['Thanalise']['user'] = !empty($user['User']['name']) ? $user['User']['name'] : $user['User']['username'];
                $value['Thanalise']['email'] = !empty($user['User']['email']) ? $user['User']['email'] : 'indisponível';
                $value['Thanalise']['perfil'] = $user['User']['role_id'];
                $fase = $this->Fase->find('first', array('conditions' => array('id' => $value['Thanalise']['fase_id'])));
                $value['Thanalise']['fase_id'] = !empty($fase['Fase']['nome']) ? $fase['Fase']['nome'] : 'indisponível';
                $resultado['Analise'] = $value['Thanalise'];
                $resultado['Analise']['Funcionalidade'] = $this->configHistoryFuncionalidades($funcionalidades);
                $result[] = $resultado;
            }
        }

        $this->set('result', $result);
    }

    /**
     * Assistente - Responde o assitente de Funcionalidades
     * @param type $id
     * @param type $dado
     * @return type
     */
    public function assistente($id = null, $dado = null) {
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if (!$dado) {
                $this->set('post', $id);
            } else {
                $this->set('dado', $dado);
                if ($id == '1' && !empty($this->request->data)) {
                    $this->set('post', $id);
                    if ($this->request->data['Analise']['opt1'] == '2') {
                        $this->set('result', 'Não foi possível identificar a funcionalidade como Função de Dado.');
                        return;
                    }
                    if ($this->request->data['Analise']['opt1'] == '1' && $this->request->data['Analise']['opt2'] == '1') {
                        $this->set('result', 'Esta funcionalidade pode ser um ALI.');
                        return;
                    }
                    if ($this->request->data['Analise']['opt1'] == '1' && $this->request->data['Analise']['opt2'] == '2' && $this->request->data['Analise']['opt3'] == '2') {
                        $this->set('result', 'Não foi possível identificar a funcionalidade como Função de Dado.');
                        return;
                    }
                        $this->set('result', 'Esta funcionalidade pode ser um AIE.');
                        return;
                    }
                    if ($this->request->data['Analise']['opt1'] == '1' && $this->request->data['Analise']['opt2'] == '2' && $this->request->data['Analise']['opt3'] == '1' && $this->request->data['Analise']['opt4'] == '2') {
                        $this->set('result', 'Não foi possível identificar a funcionalidade como Função de Dado.');
                        return;
                    }
                } 
                if ($id == '2' && !empty($this->request->data)) { 
                    $this->set('post', $id);
                    if ($this->request->data['Analise']['opt1'] == '1') {
                        $this->set('result', 'Esta funcionalidade pode ser uma Entrada Externa.');
                        return;
                    }
                    if ($this->request->data['Analise']['opt1'] == '2' && $this->request->data['Analise']['opt2'] == '2') {
                        $this->set('result', 'Não foi possível identificar a funcionalidade como função de transação.');
                        return;
                    }
                    if ($this->request->data['Analise']['opt1'] == '2' && $this->request->data['Analise']['opt2'] == '1' && $this->request->data['Analise']['opt3'] == '2') {
                        $this->set('result', 'Não foi possível identificar a funcionalidade como função de transação.');
                        return;
                    }
                    if ($this->request->data['Analise']['opt1'] == '2' && $this->request->data['Analise']['opt2'] == '1' && $this->request->data['Analise']['opt3'] == '1' && $this->request->data['Analise']['opt4'] == '1') {
                        $this->set('result', 'Esta funcionalidade pode ser uma Saída Externa.');
                        return;
                    }

                    if ($this->request->data['Analise']['opt1'] == '2' && $this->request->data['Analise']['opt2'] == '1' && $this->request->data['Analise']['opt3'] == '1' && $this->request->data['Analise']['opt4'] == '2' && $this->request->data['Analise']['opt5'] == '1') {
                        $this->set('result', 'Esta funcionalidade pode ser uma Saída Externa.');
                        return;
                    }
                    if ($this->request->data['Analise']['opt1'] == '2' && $this->request->data['Analise']['opt2'] == '1' && $this->request->data['Analise']['opt3'] == '1' && $this->request->data['Analise']['opt4'] == '2' && $this->request->data['Analise']['opt5'] == '2') {
                        $this->set('result', 'Esta funcionalidade pode ser uma Consulta Externa.');
                        return;
                    }
                    if ($this->request->data['Analise']['opt1'] == '2' && $this->request->data['Analise']['opt2'] == '1' && $this->request->data['Analise']['opt3'] == '2' && $this->request->data['Analise']['opt4'] == '2' && $this->request->data['Analise']['opt5'] == '1') {
                        $this->set('result', 'Esta funcionalidade pode ser uma Consulta Externa.');
                        return;
                    }
                }
            }
        }
        
    public function documentos($id = null) {
        $exists = $this->Analise->find('first', array('conditions' => array('Analise.id' => $id, 'Analise.st_registro' => 'S')));
        $this->Analise->id = $id;
        if (empty($exists)) {
            $this->_flash('Análise não encontrada.', 'error', '/painel/painel');
        }
        $this->dataLock($id);
        $this->getHeader($id);
        $this->layout = 'novo';
        $documentos= $this->Documento->find('all', array(
                "fields" => array("analise_id", "nome",  'descricao', 'nomeFisico'),
                'order' => array('nome')
                ,
                'conditions' => array('Documento.st_registro' => 'S', 'Documento.analise_id' => $id)
                ));
        $this->set('documentos', $documentos);
        if ($this->request->is('post') || $this->request->is('put')) {
            $retornaSaveDocs = array();
            $cont= 0; 
            for ($i = 1; $i <= 5; $i++) {
                
                $uploadData = $this->data['Documentos']['arquivo'.$i];
                $uploadDescricao = $this->data['Documentos']['documentacao'.$i];
                if ( $uploadData['size'] != 0 || $uploadData['error'] === 0) { 
                    $retornaSaveDocs[$cont] = $this->configDocs($uploadData,$uploadDescricao, $id);
                     
                    if($retornaSaveDocs[$cont] == 0 ){ // arquivo não permitido
                      $this->_flash('Tipo de documento não permitido no sistema. Tente novamente com outro arquivo.', 'error', '/analises/analises/documentos/' . $id);
                    
                        
                    }
                    $cont++;
                } 
            }
            var_dump ($arquivoInvalido);exit;
          
            if ($retornaSaveDocs) {
                $saveDocs = $this->Documento->saveMany($retornaSaveDocs);
            } 
            if ($saveDocs) {
                CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou Documentos a análise ID: {' . $id . '} . ', array('documento'));
                $this->_flash('Documentos cadastrados com sucesso.', 'success', '/analises/analises/documentos/' . $id);
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar Documentos a análise ID: {' . $id . '} . ', array('documento'));
                $this->_flash('Documentos não foram cadastrados.', 'error', '/analises/analises/documentos/' . $id);
            }
        }   
    }
    public function downloadDocumentosAnalise($id, $name) {
        $this->layout = 'novo'; 
        $this->autoRender = false; 
        $download = WWW_ROOT. 'documentos' . DS . $id . DS . $name;
         
        if( !file_exists($download) ){
            $this->_flash('Documento não encontrado.', 'error', '/analises/analises/documentos/' . $id); 
        }
        header("Content-disposition: attachment; filename=$name");
        header("Content-type: application/pdf");
        readfile($download);
      
    }
    
    public function deleteDocumentosAnalise($id, $name) {
        $this->layout = 'novo'; 
        $this->autoRender = false; 
        $download = WWW_ROOT. 'documentos' . DS . $id . DS . $name; 
        if(file_exists($download) ){ 
            $documento = $this->Documento->find('first', array("fields" => array("id"),'conditions' => array('analise_id' => $id, 'nomeFisico' => $name )));
            $this->Documento->read('st_registro', $documento['Documento']['id']);
            $this->Documento->set(array(
                'st_registro' => 'N'
            ));
            $this->Documento->save(); 
            unlink($download);
            $this->_flash('Documento excluído com sucesso.', 'success', '/analises/analises/documentos/' . $id); 
        }else{ 
            $this->_flash('Documento não encontrado.', 'error', '/analises/analises/documentos/' . $id);
        } 
    }
 
}    
  

 