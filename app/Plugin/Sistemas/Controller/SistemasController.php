<?php

Class SistemasController extends SistemasAppController {

    public $uses = array('Sistemas.Sistema', 'Linguagens.Linguagem',
        'Datatable', 'Baseline', 'Analises.Analise', 'Analiust', 'Funcionalidade', 'Tdstrsar', 'Deflatore', 'Rlustsanalise', 'Ust', 'Contratos.Contrato');

    public function index() {

        $this->layout = 'novo';
    }

    public function response() {


        $this->layout = '';
        $aColumns = array("id", "nome", "sigla", "linguagem_id");
        $sTable = 'sistemas';
        $aConditions = ' st_registro = "S" ';
        $this->autoRender = false;
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions);


        $output['aaData'] = $this->retornaGridList($output['aaData']);


        echo json_encode($output);
    }

    public function retornaGridList($aaData) {
        $linguagens = $this->Linguagem->find('list', array('conditions' => array('st_registro' => 'S'), 'fields' => array('id', 'nome')));
        $data = array();
        foreach ($aaData as $value) {
            $value[3] = $linguagens[$value[3]];
            $data[] = $value;
        }
        return $data;
    }

    public function baseresponse() {

        $this->layout = '';
        $aColumns = array("id", "sistema_id", 'modified');
        $sTable = 'baselines';
        $this->autoRender = false;
        $aConditions = ' st_ultimo_registro = "S"   and tipo = "I" ';
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions);
        $output['aaData'] = $this->retornaGrid($output['aaData']);
        echo json_encode($output);
    }

    public function baseresponseusts() {

        $this->layout = '';
        $aColumns = array("id", "sistema_id", 'modified');
        $sTable = 'baselines';
        $this->autoRender = false;
        $aConditions = ' st_ultimo_registro = "S"   and tipo = "U" ';
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions);
        $output['aaData'] = $this->retornaGridUst($output['aaData']);
        echo json_encode($output);
    }

    protected function retornaGridUst($aaData) {

        $data = array();
        foreach ($aaData as $key => $value) {
            $nomeSistema = $this->Sistema->find('first', array(
                "fields" => array('id', "nome", 'sigla'),
                'conditions' => array('Sistema.id' => $value[1])));
            $timestamp = strtotime($value[2]);
            $dataFormat = date('d/m/Y H:i:s', $timestamp);
            $value[0] = $nomeSistema['Sistema']['id'];
            $value[1] = $nomeSistema['Sistema']['nome'];
            $value[2] = $nomeSistema['Sistema']['sigla'];
            $value[3] = $dataFormat; //echo the year of the datestamp just created 
            $analises = $this->Analiust->find('all', array(
                'fields' => 'total_ust',
                'conditions' => array(
                    'sistema_id' => $value[0],
                    'st_registro' => 'S',
                    'baseline' => '0',
            )));
            $total_ust = 0;
            foreach ($analises as $a) {
                $total_ust = $total_ust + $a['Analiust']['total_ust'];
            }

            $value[4] = $total_ust;
            $data[] = $value;
        }
        return $data;
    }

    protected function retornaGrid($aaData) {
        $data = array();
        foreach ($aaData as $key => $value) {
            $nomeSistema = $this->Sistema->find('first', array(
                "fields" => array('id', "nome", 'sigla'),
                'conditions' => array('Sistema.id' => $value[1])));
            $funcionalidades = $this->Funcionalidade->find('all', array(
                'fields' => 'qtd_pf',
                'conditions' => array(
                    'Funcionalidade.sistema_id' => $value[1],
                    'Funcionalidade.st_registro' => 'S',
                    'Funcionalidade.baseline' => '0',
            )));
            $total_pf = 0;
            foreach ($funcionalidades as $f) {
                $total_pf = $total_pf + $f['Funcionalidade']['qtd_pf'];
            }
            $timestamp = strtotime($value[2]); // Gera o timestamp de $data_mysql
            $dataFormat = date('d/m/Y H:i:s', $timestamp);
            $value[3] = $dataFormat; //echo the year of the datestamp just created 
            $value[0] = $nomeSistema['Sistema']['id'];
            $value[1] = $nomeSistema['Sistema']['nome'];
            $value[2] = $nomeSistema['Sistema']['sigla'];
            $value[4] = $total_pf;
            $data[] = $value;
        }
        return $data;
    }

    public function baselines() {
        $this->layout = 'novo';
    }

    public function baselineusts() {
        $this->layout = 'novo';
    }

    public function baseviewusts($id, $imprimir = 0) {
        if ($imprimir == 1) {
            $this->layout = 'novo_impressao';
        } else {
            $this->layout = 'novo';
        }

        $sistema = $this->Sistema->find('first', array(
            'conditions' => array('st_registro' => 'S', 'id' => $id),
            "fields" => array(
                "nome", 'sigla')
                )
        );

        $analises = $this->Analiust->find('all', array(
            'fields' => array('total_ust', 'id'),
            'conditions' => array(
                'sistema_id' => $id,
                'st_registro' => 'S',
                'baseline' => '0',
        )));
        $total_ust = 0;
        $idAnalise = array();
        foreach ($analises as $a) {
            $total_ust = $total_ust + $a['Analiust']['total_ust'];
            $idAnalise[] = $a['Analiust']['id'];
        }

        

        $this->set('sistema', $sistema['Sistema']['nome']);
        $this->set('imprimir', $imprimir);
        $this->set('sigla', $sistema['Sistema']['sigla']);
           $baseline = $this->Baseline->find('first', array(
            'conditions' => array('sistema_id' => $id
            ))
        );
 $usts = $this->Rlustsanalise->find('all', array('conditions' => array(
                'st_registro' => 'S',
                'analise_id' => $idAnalise
        )));
    


        $this->set('usts', $usts);
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
        $this->set('baseline', $baseline);
        $this->set('total_ust', $total_ust);
    }

    public function baseview($id, $imprimir = 0) { 
        if ($imprimir == 1) {
            $this->layout = 'novo_impressao';
        } else {
            $this->layout = 'novo';
        }
        $baseline = $this->Baseline->find('first', array(
            'conditions' => array('sistema_id' => $id
            ))
        ); 
        $funcionalidades = $this->Funcionalidade->find('all', array('conditions' => array(
                'Funcionalidade.st_registro' => 'S',
                'Funcionalidade.sistema_id' => $id,
                'Funcionalidade.baseline' => '0',
            ),
            'order' => array('Funcionalidade.nome')), compact('funcionalidades'));

        $ali = 0;
        $aie = 0;
        $ce = 0;
        $se = 0;
        $ee = 0;

        foreach ($funcionalidades as $value) {
            if ($value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) {
                $aie = $aie + $value['Funcionalidade']['qtd_pf'];
            } elseif ($value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI) {
                $ali = $ali + $value['Funcionalidade']['qtd_pf'];
            } elseif ($value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$EE) {
                $ee = $ee + $value['Funcionalidade']['qtd_pf'];
            } elseif ($value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$CE) {
                $ce = $ce + $value['Funcionalidade']['qtd_pf'];
            } elseif ($value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$SE) {
                $se = $se + $value['Funcionalidade']['qtd_pf'];
            }
                
            $analiseId = $value['Funcionalidade']['analise_id'];
        }
        $analise = $this->Analise->find("first", array('conditions' => array('Analise.id' => $analiseId)));

        $this->set('funcionalidades', $this->configFuncionalidades($funcionalidades));
        $sistema = $this->Sistema->find('first', array(
            'conditions' => array('Sistema.st_registro' => 'S', 'Sistema.id' => $id),
            "fields" => array(
                "nome", 'sigla')
                )
        ); 
        $this->set('sistema', $sistema['Sistema']['nome']);
        $this->set('imprimir', $imprimir);
        $this->set('baseline', $baseline);
        
        
        $contrato = $this->Contrato->find("first", array('conditions' => array('Contrato.id' => $analise['Analise']['id_contrato'])));
                
        $this->set('valor_base', $contrato);
        $this->set('sigla', $sistema['Sistema']['sigla']);
        $total_pf = $aie + $ali + $ce + $se + $ce;
        $this->set('qtd_aie', $aie);
        $this->set('qtd_ali', $ali);
        $this->set('qtd_ee', $ee);
        $this->set('qtd_se', $se);
        $this->set('qtd_ce', $ce);
        $this->set('total_pf', $total_pf);

        $result = $this->getResumo($funcionalidades);

        $this->set('result', $result);
    }

    public function add($id = null) {
        $this->layout = 'novo';
        $linguagems = $this->Linguagem->find('list', array(
            'conditions' => array('st_registro' => 'S'),
            "fields" => array("id",
                "nome")
                )
        );
        $this->set('linguagems', $linguagems);

        if ($this->request->is('post') || $this->request->is('put')) {

            $validSistema = $this->Sistema->find('first', array('conditions' => array('nome' => $this->data['Sistema']['nome'], 'st_registro' => 'S')));
            if (!empty($validSistema) && $validSistema['Sistema']['id'] != $id) {
                $this->_flash('O nome desse Sistema já existe. Tente novamente!', 'error');
                return;
            }

            if (!empty($this->data['Sistema']['id'])) {
                $guardaSistema = $this->Sistema->find('first', array('conditions' => array('id' => $this->data['Sistema']['id'], 'st_registro' => 'S')));
            }

            if ($this->Sistema->save($this->request->data)) {
                if (empty($this->data['Sistema']['id'])) {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou o Sistema, Nome:\'' . $this->request->data['Sistema']['nome'] . '\', Sigla:\'' . $this->request->data['Sistema']['sigla'] . '\', Linguagem:\'' . $linguagems[$this->request->data['Sistema']['linguagem_id']] . '\', Descrição:\'' . $this->request->data['Sistema']['descricao'] . '\'.', array('sistema'));
                    $this->_flash('Sistema cadastrado com sucesso!', 'success', '/sistemas/sistemas/index/');
                } else {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} alterou o Sistema, Nome:\'' . $guardaSistema['Sistema']['nome'] . '\' para \'' . $this->request->data['Sistema']['nome'] . '\', Sigla:\'' . $guardaSistema['Sistema']['sigla'] . '\' para \'' . $this->request->data['Sistema']['sigla'] . '\', Linguagem:\'' . $linguagems[$guardaSistema['Sistema']['linguagem_id']] . '\' para \'' . $linguagems[$this->request->data['Sistema']['linguagem_id']] . '\', Descrição:\'' . $guardaSistema['Sistema']['descricao'] . '\' para \'' . $this->request->data['Sistema']['descricao'] . '\'.', array('sistema'));
                    $this->_flash('Sistema cadastrado com sucesso!', 'success', '/sistemas/sistemas/index/');
                }
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar a Sistema.', array('sistema'));
                $this->_flash('Sistema não foi cadastrado!', 'error', '/sistemas/sistemas/add/');
            }
        } elseif ($id != null) {
            $sistema = $this->Sistema->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S'), 'fields' => 'nome'));
            if (empty($sistema)) {
                $this->_flash('Sistema não existente.', 'error', '/sistemas/sistemas/');
            }
            $this->Sistema->id = $id;
            $this->request->data = $this->Sistema->read();
        }
    }

    public function delete($id) {
        $this->Sistema->id = $id;
        $sistema = $this->Sistema->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S'), 'fields' => 'nome'));
        if (empty($sistema)) {
            $this->_flash('Sistema não existente.', 'error', '/sistemas/sistemas/');
        }
        $integridade = $this->Analise->find('first', array('conditions' => array('Analise.sistema_id' => $id, 'Analise.st_registro'
                => 'S'), 'fields' => array('id')));
        if (!empty($integridade)) {
            $this->_flash('Sistema não foi deletado pois contém análise.', 'error', '/sistemas/sistemas/');
        }
        $this->Sistema->read('st_registro', $id);
        $this->Sistema->set(array(
            'st_registro' => 'N',
        ));


        if ($this->Sistema->save()) {
            $updateBaseline = $this->Baseline->find('first', array('conditions' => array('sistema_id' => $id)));
            if (!empty($updateBaseline)) {
                $updateBaseline['Baseline']['id'] = $updateBaseline['Baseline']['id'];
                $updateBaseline['Baseline']['st_ultimo_registro'] = 'N';
            }
            $this->Baseline->save($updateBaseline);
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou o Sistema : ' . $sistema['Sistema']['nome'] . '.', array('sistema'));
            $this->_flash('Sistema foi deletado com sucesso.', 'success', '/sistemas/sistemas/');
        } else {
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar o Sistema : ' . $sistema['Sistema']['nome'] . '.', array('sistema'));

            $this->_flash('Sistema não foi deletado.', 'error', '/sistemas/sistemas/');
        }
    }

    public function history() {
        $this->layout = 'novo';
        if ($this->request->is('post') || $this->request->is('put')) {
            $data_ini = implode("-", array_reverse(explode("/", $this->request->data['Sistema']['data_ini']))) . ' 00:00:01';
            $data_fim = implode("-", array_reverse(explode("/", $this->request->data['Sistema']['data_fim']))) . ' 23:59:59';

            $funcionalidades = $this->Funcionalidade->find('all', array(
                'conditions' => array(
                    'Funcionalidade.created >= ' => $data_ini,
                    'Funcionalidade.created <= ' => $data_fim,
                    'Funcionalidade.sistema_id ' => $this->request->data['Sistema']['sistema_id'],
                    'Funcionalidade.st_registro =' => 'S',
                    'Funcionalidade.baseline =' => '0'),
                'order' => array('Funcionalidade.nome')
                    )
            );
            $this->set('funcionalidades', $funcionalidades);
            $result = $this->configHistory($funcionalidades);
            $result['sistema'] = $this->Sistema->find('first', array(
                "fields" => array("nome"),
                'conditions' => array('Sistema.id' => $this->request->data['Sistema']['sistema_id']),
                'order' => array('nome')));

            $this->set('result', $result);
        }
        $sistemas = $this->Sistema->find('list', array(
            "fields" => array("id", "nome"),
            'conditions' => array('Sistema.st_registro' => 'S'),
            'order' => array('nome')));
        $this->set('sistemas', $sistemas);
    }

    /**
     * Método para configurar o cabeçalho do historico quando houver uma pesquisa
     * @param type $funcionalidades
     * @return type array $result
     */
    public function configHistory($funcionalidades) {
        $demandas = array();
        $total_incluido = 0;
        $total_alterado = 0;
        $total_excluido = 0;
        $total_convencao = 0;
        $qtd_pf = 0;
        foreach ($funcionalidades as $key => $value) {
            $qtd_pf = $qtd_pf + $value['Funcionalidade']['qtd_pf'];
            $demandas[] = $value['Funcionalidade']['analise_id'];
            switch ($value['Funcionalidade']['impacto']) {
                case '1':
                    $total_incluido = $total_incluido + $value['Funcionalidade']['qtd_pf'];
                    break;
                case '2':
                    $total_alterado = $total_alterado + $value['Funcionalidade']['qtd_pf'];
                    break;
                case '3':
                    $total_excluido = $total_excluido + $value['Funcionalidade']['qtd_pf'];
                    break;
                case '4':
                    $total_convencao = $total_convencao + $value['Funcionalidade']['qtd_pf'];
                    break;
                default:
                    break;
            }
        }
        $result['total_pf'] = $qtd_pf;
        $result['total_demanda'] = sizeof(array_unique($demandas));
        $result['total_incluido'] = $total_incluido;
        $result['total_alterado'] = $total_alterado;
        $result['total_excluido'] = $total_excluido;
        $result['total_convencao'] = $total_convencao;
        return $result;
    }

    public function gettipos() {
        $id = $_POST['id'];
        Configure::write('debug', 0);
        $this->layout = '';
        $tipos = $this->Tdstrsar->find('all', array('conditions' =>
            array(
                'Tdstrsar.funcionalidade_id' => $id),
            'fields' => array('id', 'nome', 'tipo')));
        $funcionalidade = $this->Funcionalidade->find('first', array('conditions' =>
            array(
                'Funcionalidade.id' => $id),
            'fields' => array('nome', 'tipo')));


        $this->set('funcionalidade', $funcionalidade['Funcionalidade']);
        $this->set('tipos', $tipos);
    }

    public function configFuncionalidades($funcionalidades, $tipo_contagem = null) {
        $dataFuncionalidade = array();
        foreach ($funcionalidades as $value) {
            $value['Funcionalidade']['tds'] = $this->Tdstrsar->find('all', array('conditions' =>
                array(
                    'Tdstrsar.funcionalidade_id' => $value['Funcionalidade']['id'],
                    'Tdstrsar.tipo' => \Dominio\Tdtrar::$TD),
                'fields' => array('id', 'nome', 'tipo'), 'order' => array('nome')
            ));
            if ($value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE || $value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI) {
                $value['Funcionalidade']['trs'] = $this->Tdstrsar->find('all', array('conditions' =>
                    array(
                        'Tdstrsar.funcionalidade_id' => $value['Funcionalidade']['id'],
                        'Tdstrsar.tipo' => \Dominio\Tdtrar::$TR),
                    'fields' => array('id', 'nome', 'tipo'), 'order' => array('nome')));
            } else {
                $value['Funcionalidade']['ars'] = $this->Tdstrsar->find('all', array('conditions' =>
                    array(
                        'Tdstrsar.funcionalidade_id' => $value['Funcionalidade']['id'],
                        'Tdstrsar.tipo' => \Dominio\Tdtrar::$AR),
                    'fields' => array('id', 'nome', 'tipo'), 'order' => array('nome')));
            }
            $dataFuncionalidade[] = $value;
        }

        return $dataFuncionalidade;
    }

}
