<?php

Class PainelController extends PainelAppController {

    const REL_EQUIPE = 'a';
    const REL_SISTEMA = 'b';
    const REL_ANALISTA = 'c';
    const REL_SISEQP = 'd';

    public $uses = array('Analise', 'Rluserequipe', 'Equipe', 'Sistema', 'Fase', 'User');

    public function index($param = null) {
        $this->layout = 'novo';

        //verifica o login do analista e verifica se ele escolheu alguma equipe
        $role = $this->Session->read('Auth.User.role_id');
        $group = $this->Session->read('Equipe_id');



        if ($role != '1') {
            if ($group == null) {
                return $this->redirect('/users/users/control/');
            }
        }

        //realizar download do manual de ajuda
        if ($param == '1') {
            $this->autoRender = false;
            header("Content-disposition: attachment; filename=APFBr_Manual_Usuario.pdf");
            header("Content-type: application/pdf");
            readfile(realpath(APP . "/tmp/APFBr_Manual_Usuario.pdf"));
        }
        $userId = $this->Session->read('Auth.User.role_id');

        $equipeId = $this->Session->read('Equipe_id');


        if ($userId == '1') {
            $equipes = $this->Equipe->find('list', array(
                "fields" => array("id", "nome"),
                'conditions' => array('Equipe.st_registro' => 'S'),
                'order' => array('Equipe.nome')));
            $equipes[0] = '[ Escolha uma equipe ]';
            $equipes[999999] = 'Administrador';
        } else {

            $equipes = $this->Equipe->find('list', array(
                "fields" => array("id", "nome"),
                'conditions' => array('Equipe.st_registro' => 'S', 'Equipe.id' => $equipeId),
                'order' => array('Equipe.nome')));
        }
        ksort($equipes);
        $this->set('equipes', $equipes);
    }

    public function relatorios($type) {
        $this->layout = 'novo';
        $usuario = $this->User->find('list', array(
            "fields" => array("id", "name"),
            'conditions' => array('User.st_registro' => 'S'),
            'order' => array('User.name')
        ));
        $sistemas = $this->Sistema->find('list', array(
            "fields" => array("id", "nome"),
            'conditions' => array('Sistema.st_registro' => 'S'),
            'order' => array('Sistema.nome')));
        $this->set('sistemas', $sistemas);

        $equipes = $this->Equipe->find('list', array(
            "fields" => array("id", "nome"),
            'conditions' => array('Equipe.st_registro' => 'S'),
            'order' => array('Equipe.nome')));
        $equipes[0] = 'Administrador';
        asort($equipes);
        $this->set('equipes', $equipes);
        $this->set('usuarios', $usuario);
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->prepareRelatorio($type, $this->request->data['Analise']);
        }
        $this->render_view($type);
    }

    protected function prepareRelatorio($relatorio, $dataPost = null) {

        if (self::REL_EQUIPE == $relatorio) {
            $where = !empty($dataPost['equipe_id']) ? array(
                //'Analise.baseline' => '0',
                'Analise.st_registro' => 'S',
                'Analise.equipe_id' => $dataPost['equipe_id']) : array(
               // 'Analise.baseline' => '0',
                'Analise.st_registro' => 'S',
                'Analise.equipe_id' => null);
            $analises = $this->Analise->find('all', array(
                'conditions' => $where,
                'fields' => array('id', 'tipo_contagem', 'metodo_contagem', 'nu_demanda',
                    'total_pf', 'total_pf_ajustado', 'fase_id', 'sistema_id', 'created', 'valor_fator', 'total_pf_itens')));
			 		
            if (!empty($analises)) {
                $pf_total = 0;
                $pf_ajustado_total = 0;
                $valor_fator = 0;
                foreach ($analises as $value) {
                    $pf_total = $pf_total + $value['Analise']['total_pf'];
                    $pf_ajustado_total = $pf_ajustado_total + $value['Analise']['total_pf_ajustado'];
                    $valor_fator = $valor_fator + $value['Analise']['total_pf_ajustado'] + $value['Analise']['total_pf_itens'];
                }
                $result = $this->configRelatorio($analises);
                $info['qtd_analise'] = sizeof($analises);
                $info['pf_total'] = $pf_total;
                $info['pf_total_ajustado'] = $pf_ajustado_total;
				$info['pf_total_itens'] = $valor_fator;
                $info['valor_fator'] = $valor_fator;
				
                $this->set('info', $info);
            } else {
                $this->_flash('Nenhum registro encontrado.', 'error');
                $this->render('relatorios_pf');
                return;
            }
            $this->set('result', $result);
            $this->render('relatorios_pf');
        } elseif (self::REL_SISEQP == $relatorio) {
            if (!empty($dataPost['equipe_id'])) {
                $where = ' and ana.equipe_id = ' . $dataPost['equipe_id'];
            } else {
                if ($dataPost['equipe_id'] == '0') {
                    $where = ' and ana.equipe_id is null ';
                } else {
                    $where = null;
                }
            }
            $query = 'SELECT ana.id, ana.tipo_contagem, ana.metodo_contagem, ana.nu_demanda, eqp.nome as equipe,
                    ana.total_pf, ana.total_pf_ajustado, ana.fase_id, sis.nome as sistema, ana.created, ana.valor_fator, ana.total_pf_itens 
                    FROM Analises ana '
                    . ' inner join Sistemas sis on sis.id = ana.sistema_id  '
                    . ' left join Equipes eqp on eqp.id = ana.equipe_id  '
                    . ' where ana.st_registro = "S" and ana.sistema_id = ' . $dataPost['sistema_id'] . $where;
            $return = $this->Analise->query($query);
            if (!empty($return)) {
                $this->set('result', $return);
            } else {
                $this->_flash('Nenhum registro encontrado.', 'error');
                $this->render('relatorios_sistema');
                return;
            }
            $this->render('relatorios_sistema');
        } elseif (self::REL_ANALISTA == $relatorio || self::REL_SISTEMA == $relatorio) {

            if (self::REL_ANALISTA == $relatorio) {
                $where = array(
                    //'Analise.baseline' => '0',
                    'Analise.user_id' => $dataPost['usuario'],
                    'Analise.st_registro' => 'S');
            } elseif (self::REL_SISTEMA == $relatorio) {
                $where = array(
                   // 'Analise.baseline' => '0',
                    'Analise.sistema_id' => $dataPost['sistema_id'],
                    'Analise.st_registro' => 'S');
            }

            if (!empty($dataPost['data_ini']) && !empty($dataPost['data_fim'])) {
                $where = array_merge($where, array('Analise.created  BETWEEN ? AND ?' => array(implode("-", array_reverse(explode("/", $dataPost['data_ini']))) . ' 00:00:00', implode("-", array_reverse(explode("/", $dataPost['data_fim']))) . ' 23:59:59'))
                );
            } else
            if (!empty($dataPost['data_ini'])) {
                $where = array_merge($where, array('Analise.created >= ' => implode("-", array_reverse(explode("/", $dataPost['data_ini']))) . ' 00:00:00'));
            } else
            if (!empty($dataPost['data_fim'])) {
                $where = array_merge($where, array('Analise.created <= ' => implode("-", array_reverse(explode("/", $dataPost['data_fim']))) . ' 23:59:59'));
            }
            if ($dataPost['equipe_id'] == '0') {
                $equipe['Equipe']['nome'] = 'Administrador';
                $where = array_merge($where, array('Analise.equipe_id' => null));
            } else
            if (!empty($dataPost['equipe_id'])) {
                $equipe = $this->Equipe->find('first', array(
                    'conditions' => array('Equipe.id' => $dataPost['equipe_id']),
                    'fields' => array('nome')));

                $where = array_merge($where, array('Analise.equipe_id' => $dataPost['equipe_id']));
            }
            if (!empty($dataPost['tipo_contagem'])) {
                $where = array_merge($where, array('Analise.tipo_contagem' => $dataPost['tipo_contagem']));
            }
            if (!empty($dataPost['metodo_contagem'])) {
                $where = array_merge($where, array('Analise.metodo_contagem' => $dataPost['metodo_contagem']));
            }
            $analises = $this->Analise->find('all', array(
                'conditions' => $where,
                'fields' => array('id', 'tipo_contagem', 'metodo_contagem', 'nu_demanda',
                    'total_pf', 'total_pf_ajustado', 'fase_id', 'sistema_id', 'created', 'valor_fator', 'total_pf_itens')));
            if (!empty($analises)) {
                $pf_total = 0;
                $pf_ajustado_total = 0;
                $valor_fator = 0;
                foreach ($analises as $value) {
                    $pf_total = $pf_total + $value['Analise']['total_pf'];
                    $pf_ajustado_total = $pf_ajustado_total + $value['Analise']['total_pf_ajustado'];
                    $valor_fator = $valor_fator + $value['Analise']['total_pf_ajustado'] + $value['Analise']['total_pf_itens'];
                }
                $result = $this->configRelatorio($analises);
                $this->set('result', $result);
			
                $user = $this->User->find('first', array(
                    "fields" => array('name', 'role_id', 'username'),
                    'conditions' => array('User.id' => $dataPost['usuario'], 'User.st_registro' => 'S')
                ));
				 
                $info['usuario'] = $user['User']['name'];
                $info['username'] = $user['User']['username'];
                $info['perfil'] = Dominio\Perfil::getPerfilById($user['User']['role_id']);
                $info['qtd_analise'] = sizeof($analises);
                $info['equipe'] = !empty($equipe['Equipe']['nome']) ? $equipe['Equipe']['nome'] : null;
                $info['pf_total'] = $pf_total;
                $info['pf_total_ajustado'] = $pf_ajustado_total;
                $info['valor_fator'] = $valor_fator;
                $info['tipo_contagem'] = !empty($dataPost['tipo_contagem']) ? \Dominio\TipoContagem::getTipoById($dataPost['tipo_contagem']) : null;
                $info['metodo_contagem'] = !empty($dataPost['metodo_contagem']) ? \Dominio\MetodoContagem::getMetodoById($dataPost['metodo_contagem']) : null;
                $this->set('info', $info);
            } else {
                $this->_flash('Nenhum registro encontrado.', 'error');
            }
            if (self::REL_ANALISTA == $relatorio) {
                $this->render('relatorios_desempenho');
            } elseif (self::REL_SISTEMA == $relatorio) {
				 
				 
                $this->render('relatorios_analise');
            }
        }
    }

    protected function configRelatorio($analises) {
        $sistemas = array();
        foreach ($analises as $value) {
            if (!in_array($value['Analise']['sistema_id'], $sistemas)) {
                $sistemas[] = $value['Analise']['sistema_id'];
            }
        }
        foreach ($sistemas as $value) {
            foreach ($analises as $v) {
                if ($value == $v['Analise']['sistema_id']) {
                    $data[] = $v['Analise'];
                }
            }
            $nome = $this->Sistema->find('first', array(
                'fields' => 'nome',
                'conditions' => array('Sistema.id' => $value, 'Sistema.st_registro' => 'S')));
            $arraTemp[] = array('qtdAnalise' => sizeof($data), 'nomeSistema' => $nome['Sistema']['nome'], 'sistema_id' => $value);
            $arrayDados[] = $data;
            $data = array();
        }


        $pf_total = 0;
        $pf_ajustado_total = 0;
        $valor_fator_total = 0;
        $pf_sis = 0;
        $pf_sis_ajus = 0;
        $pf_valor_fator = 0;

        foreach ($analises as $key => $v) {
            $pf_total = $pf_total + $v['Analise']['total_pf'];
            $pf_ajustado_total = $pf_ajustado_total + $v['Analise']['total_pf_ajustado'];
            $valor_fator_total = $valor_fator_total + $v['Analise']['total_pf_ajustado']+ $v['Analise']['total_pf_itens'];
        }

        foreach ($arrayDados as $key => $value) {
            foreach ($value as $v) {
                $pf_sis += $v['total_pf'];
                $pf_sis_ajus += $v['total_pf_ajustado'];
                $pf_valor_fator += $v['total_pf_ajustado'] + $v['total_pf_itens'];
                $sistema_id = $v['sistema_id'];
            }

            $data['total_pf'] = $pf_sis;
            $data['total_pf_ajustado'] = $pf_sis_ajus;
            $data['pf_valor_fator'] = $pf_valor_fator;
            $data['sistema_id'] = $sistema_id;
            $arrPrepared[] = $data;
            $pf_sis = 0;
            $pf_sis_ajus = 0;
            $pf_valor_fator = 0;
            $data = array();
        }


        foreach ($arraTemp as $value) {
            foreach ($arrPrepared as $v) {
                if ($value['sistema_id'] == $v['sistema_id']) {
                    $data['nome'] = $value['nomeSistema'];
                    $data['por_qtd'] = !empty($analises) ? number_format(($value['qtdAnalise'] * 100 ) / sizeof($analises), 2) : '0';
                    $data['qtd'] = $value['qtdAnalise'];
                    $data['por_pf_total'] = !empty($pf_total) ? number_format(($v['total_pf'] * 100 ) / $pf_total, 2) : '0';
                    $data['pf_total'] = $v['total_pf'];
                    $data['pf_valor_fator_total'] = $v['pf_valor_fator'];
                    $data['por_valor_fator'] = !empty($valor_fator_total) ? number_format(($v['pf_valor_fator'] * 100 ) / $valor_fator_total, 2) : '0';
                    $data['por_pf_ajustado_total'] = !empty($pf_ajustado_total) ? number_format(($v['total_pf_ajustado'] * 100 ) / $pf_ajustado_total, 2) : '0';
                    $data['pf_ajustado_total'] = $v['total_pf_ajustado'];
                }
            }
            $result[] = $data;
            $data = array();
        }

        return $result;
    }

    public function render_view($type) {
        if ($type == 'a') {
            $this->render('relatorios_pf');
        } else if ($type == 'b') {
            $this->render('relatorios_analise');
        } else if ($type == 'c') {
            $this->render('relatorios_desempenho');
        } else if ($type == 'd') {
            $this->render('relatorios_sistema');
        }
    }

    public function logs() {
        $this->layout = 'novo';
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->autoRender = false;
            $type = $this->request->data['LOG']['log_name'];
            header("Content-disposition: attachment; filename=$type.log");
            header("Content-type: application/pdf");
            readfile(realpath(APP . "/tmp/logs/$type.log"));
        }
    }

}
