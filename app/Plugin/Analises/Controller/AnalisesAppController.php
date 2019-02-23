<?php

App::uses('AppController', 'Controller');

class AnalisesAppController extends AppController {

    public $uses = array('Analise', 'Contratos.Contrato', 'Fases.Fase',
        'Sistemas.Sistema', 'Funcionalidade', 'Tdstrsar', 'Linguagens.Linguagem', 'Thanalise', 'Thfuncionalidade', 'Thtdstrsar',
        'Equipes.Equipe', 'Itens.Item', 'Rlitensanalises.Rlitensanalise', 'Deflatores.Deflatore', 'Datalock', 'Users.User', 'Contratos.Contrato');

    public function getHeader($id) {
        $analise = $this->Analise->find('first', array('conditions' => array(
                'Analise.id' => $id)));
        $sistema = $this->Sistema->find('first', array('fields' => array('nome', 'id', 'linguagem_id'),
            'conditions' => array('Sistema.id' => $analise['Analise']['sistema_id'])));
        $campo = '';


        if (!empty($analise['Analise']['tipo_contagem'])) {
            if ($analise['Analise']['tipo_contagem'] == '1') {
                $campo = 'produtividade_desen';
            } else
            if ($analise['Analise']['tipo_contagem'] == '3') {
                $campo = 'produtividade_desen';
            } else
            if ($analise['Analise']['tipo_contagem'] == '2') {
                $campo = 'produtividade_mel';
            }
            $linguagem = $this->Linguagem->find('first', array('fields' => array($campo),
                'conditions' => array('Linguagem.id' => $sistema['Sistema']['linguagem_id'])));
        }

        $analise['Analise']['cofator'] = isset($linguagem['Linguagem'][$campo]) ? $linguagem['Linguagem'][$campo] : '0';
        $analise['Analise']['sistema'] = $sistema['Sistema']['nome'];
        $analise['Analise']['sistema_id'] = $sistema['Sistema']['id'];
        $usuario = $this->User->find('first', array('fields' => array('name'),
            'conditions' => array('User.id' => $analise['Analise']['user_id'])));


        $equipe = $this->Equipe->find('first', array('fields' => array('nome'),
            'conditions' => array('Equipe.id' => $analise['Analise']['equipe_id'])));
        $analise['Analise']['usuario'] = $usuario['User']['name'];
        $analise['Analise']['equipe'] = !empty($equipe['Equipe']['nome']) ? $equipe['Equipe']['nome'] : 'Administrador';
        
        $this->set('analise', $analise);
    }

    public function createHistory($id) {
        $identificador = uniqid(time());
        $analise = $this->Analise->find('first', array('conditions' => array('id' => $id)));
        $thanalise['Thanalise'] = $analise['Analise'];
        $thanalise['Thanalise']['history'] = $identificador;
        $thanalise['Thanalise']['analise_id'] = $analise['Analise']['id'];
        $thanalise['Thanalise']['id'] = null;

        $test = $this->Thanalise->save($thanalise);

        $funcionalidade = $this->Funcionalidade->find('all', array('conditions' => array('analise_id' => $id)));
        $funcionalidades = array();
        foreach ($funcionalidade as $value) {
            $tdartr = $this->Tdstrsar->find('all', array('conditions' => array('funcionalidade_id' => $value['Funcionalidade']['id'])));
            $value['Funcionalidade']['history'] = $identificador;
            $value['Funcionalidade']['funcionalidade_id'] = $value['Funcionalidade']['id'];
            $value['Funcionalidade']['id'] = null;
            $funcionalidades[]['Thfuncionalidade'] = $value['Funcionalidade'];
            $funcoes = array();
            foreach ($tdartr as $v) {
                $v['Tdstrsar']['history'] = $identificador;
                $v['Tdstrsar']['id_td'] = $v['Tdstrsar']['id'];
                $v['Tdstrsar']['id'] = null;
                $funcoes[]['Thtdstrsar'] = $v['Tdstrsar'];
            }
            $this->Thtdstrsar->saveMany($funcoes);
        }
        $this->Thfuncionalidade->saveMany($funcionalidades);
    }

    /**
     * Relatorio
     * @param type $funcionalidades
     * @return type
     */
    public function getResumo($funcionalidades) {
        $cont_baixa_ali = '';
        $cont_baixa_aie = '';
        $cont_baixa_se = '';
        $cont_baixa_ce = '';
        $cont_baixa_ee = '';

        $cont_media_ali = '';
        $cont_media_aie = '';
        $cont_media_se = '';
        $cont_media_ce = '';
        $cont_media_ee = '';

        $cont_alta_ali = '';
        $cont_alta_aie = '';
        $cont_alta_se = '';
        $cont_alta_ce = '';
        $cont_alta_ee = '';

        $comp_baixa_ali = '';
        $comp_baixa_aie = '';
        $comp_baixa_se = '';
        $comp_baixa_ce = '';
        $comp_baixa_ee = '';

        $comp_media_ali = '';
        $comp_media_aie = '';
        $comp_media_se = '';
        $comp_media_ce = '';
        $comp_media_ee = '';

        $comp_alta_ali = '';
        $comp_alta_aie = '';
        $comp_alta_se = '';
        $comp_alta_ce = '';
        $comp_alta_ee = '';
        foreach ($funcionalidades as $value) {
            switch ($value['Funcionalidade']['tipo_funcionalidade']) {
                case '1':
                    if ($value['Funcionalidade']['complexidade'] == '1') {
                        $comp_baixa_ali = $comp_baixa_ali + $value['Funcionalidade']['qtd_pf'];
                        $cont_baixa_ali +=1;
                    } elseif ($value['Funcionalidade']['complexidade'] == '2') {
                        $comp_media_ali = $comp_media_ali + $value['Funcionalidade']['qtd_pf'];
                        $cont_media_ali +=1;
                    } else if ($value['Funcionalidade']['complexidade'] == '3') {
                        $comp_alta_ali = $comp_alta_ali + $value['Funcionalidade']['qtd_pf'];
                        $cont_alta_ali +=1;
                    }
                    break;
                case '2':

                    if ($value['Funcionalidade']['complexidade'] == '1') {
                        $comp_baixa_aie = $comp_baixa_aie + $value['Funcionalidade']['qtd_pf'];
                        $cont_baixa_aie +=1;
                    } elseif ($value['Funcionalidade']['complexidade'] == '2') {
                        $comp_media_aie = $comp_media_aie + $value['Funcionalidade']['qtd_pf'];
                        $cont_media_aie +=1;
                    } else if ($value['Funcionalidade']['complexidade'] == '3') {
                        $comp_alta_aie = $comp_alta_aie + $value['Funcionalidade']['qtd_pf'];
                        $cont_alta_aie +=1;
                    }
                    break;
                case '3':

                    if ($value['Funcionalidade']['complexidade'] == '1') {
                        $comp_baixa_se = $comp_baixa_se + $value['Funcionalidade']['qtd_pf'];
                        $cont_baixa_se +=1;
                    } elseif ($value['Funcionalidade']['complexidade'] == '2') {
                        $comp_media_se = $comp_media_se + $value['Funcionalidade']['qtd_pf'];
                        $cont_media_se +=1;
                    } else if ($value['Funcionalidade']['complexidade'] == '3') {
                        $comp_alta_se = $comp_alta_se + $value['Funcionalidade']['qtd_pf'];
                        $cont_alta_se +=1;
                    }
                    break;
                case '4':
                    if ($value['Funcionalidade']['complexidade'] == '1') {
                        $comp_baixa_ce = $comp_baixa_ce + $value['Funcionalidade']['qtd_pf'];
                        $cont_baixa_ce +=1;
                    } elseif ($value['Funcionalidade']['complexidade'] == '2') {
                        $comp_media_ce = $comp_media_ce + $value['Funcionalidade']['qtd_pf'];
                        $cont_media_ce +=1;
                    } else if ($value['Funcionalidade']['complexidade'] == '3') {
                        $comp_alta_ce = $comp_alta_ce + $value['Funcionalidade']['qtd_pf'];
                        $cont_alta_ce +=1;
                    }

                    break;
                case '5':
                    if ($value['Funcionalidade']['complexidade'] == '1') {
                        $comp_baixa_ee = $comp_baixa_ee + $value['Funcionalidade']['qtd_pf'];
                        $cont_baixa_ee +=1;
                    } elseif ($value['Funcionalidade']['complexidade'] == '2') {
                        $comp_media_ee = $comp_media_ee + $value['Funcionalidade']['qtd_pf'];
                        $cont_media_ee +=1;
                    } else if ($value['Funcionalidade']['complexidade'] == '3') {
                        $comp_alta_ee = $comp_alta_ee + $value['Funcionalidade']['qtd_pf'];
                        $cont_alta_ee +=1;
                    }
                    break;
                default:
                    break;
            }
        }
        $result = array();
        $result['total'] = sizeof($funcionalidades);
        $result['ALI']['baixa'] = $cont_baixa_ali;
        $result['ALI']['media'] = $cont_media_ali;
        $result['ALI']['alta'] = $cont_alta_ali;

        $result['AIE']['baixa'] = $cont_baixa_aie;
        $result['AIE']['media'] = $cont_media_aie;
        $result['AIE']['alta'] = $cont_alta_aie;

        $result['SE']['baixa'] = $cont_baixa_se;
        $result['SE']['media'] = $cont_media_se;
        $result['SE']['alta'] = $cont_alta_se;

        $result['CE']['baixa'] = $cont_baixa_ce;
        $result['CE']['media'] = $cont_media_ce;
        $result['CE']['alta'] = $cont_alta_ce;

        $result['EE']['baixa'] = $cont_baixa_ee;
        $result['EE']['media'] = $cont_media_ee;
        $result['EE']['alta'] = $cont_alta_ee;

        $result['ALI']['comp_baixa'] = $comp_baixa_ali;
        $result['ALI']['comp_media'] = $comp_media_ali;
        $result['ALI']['comp_alta'] = $comp_alta_ali;

        $result['AIE']['comp_baixa'] = $comp_baixa_aie;
        $result['AIE']['comp_media'] = $comp_media_aie;
        $result['AIE']['comp_alta'] = $comp_alta_aie;

        $result['SE']['comp_baixa'] = $comp_baixa_se;
        $result['SE']['comp_media'] = $comp_media_se;
        $result['SE']['comp_alta'] = $comp_alta_se;

        $result['CE']['comp_baixa'] = $comp_baixa_ce;
        $result['CE']['comp_media'] = $comp_media_ce;
        $result['CE']['comp_alta'] = $comp_alta_ce;

        $result['EE']['comp_baixa'] = $comp_baixa_ee;
        $result['EE']['comp_media'] = $comp_media_ee;
        $result['EE']['comp_alta'] = $comp_alta_ee;
        return $result;
    }

    protected function retornaGrid($aaData) {
        $data = array();

        foreach ($aaData as $value) {
           if($value[11] == '0'){
               $value[0] = $value[0] . ' *';
           }

            $dt = strtotime($value[10]); //make timestamp with datetime string 
            $value[10] = date("d/m/Y", $dt); //echo the year of the datestamp just created 

            $data[] = $value;
        }
        return $data;
    }

    public function getCalculaAPF($dados, $metodoContagem) {


        if ($metodoContagem == \Dominio\MetodoContagem::$detalhada) {

            $dados['Funcionalidade']['td'] = $this->getCountTRTDAR($dados['Funcionalidade']['td']);
            if (isset($dados['Funcionalidade']['tr'])) {
                $dados['Funcionalidade']['tr'] = isset($dados['Funcionalidade']['tr']) ? $this->getCountTRTDAR($dados['Funcionalidade']['tr']) : array();
                return $this->regrasCalculoTR($dados['Funcionalidade']);
            } else if (isset($dados['Funcionalidade']['ar'])) {
                $dados['Funcionalidade']['ar'] = isset($dados['Funcionalidade']['ar']) ? $this->getCountTRTDAR($dados['Funcionalidade']['ar']) : array();
                return $this->regrasCalculoAR($dados['Funcionalidade']);
            }
        } else if ($metodoContagem == \Dominio\MetodoContagem::$estimada) {
            //Funcionalidade não reflete no BASELINE
            $dados['Funcionalidade']['baseline'] = 1;
            if ($dados['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI) {
                $dados['Funcionalidade']['qtd_pf'] = 7;
                $dados['Funcionalidade']['complexidade'] = \Dominio\TipoComplexidade::$Baixa;
            }
            if ($dados['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) {
                $dados['Funcionalidade']['qtd_pf'] = 5;
                $dados['Funcionalidade']['complexidade'] = \Dominio\TipoComplexidade::$Baixa;
            }
            if ($dados['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$SE) {
                $dados['Funcionalidade']['qtd_pf'] = 5;
                $dados['Funcionalidade']['complexidade'] = \Dominio\TipoComplexidade::$Media;
            }
            if ($dados['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$CE) {
                $dados['Funcionalidade']['qtd_pf'] = 4;
                $dados['Funcionalidade']['complexidade'] = \Dominio\TipoComplexidade::$Media;
            }
            if ($dados['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$EE) {
                $dados['Funcionalidade']['qtd_pf'] = 4;
                $dados['Funcionalidade']['complexidade'] = \Dominio\TipoComplexidade::$Media;
            }
        } else if ($metodoContagem == \Dominio\MetodoContagem::$indicativa) {
            if ($dados['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI) {
                $dados['Funcionalidade']['qtd_pf'] = 35;
                $dados['Funcionalidade']['complexidade'] = \Dominio\TipoComplexidade::$Baixa;
            }
            if ($dados['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) {
                $dados['Funcionalidade']['qtd_pf'] = 15;
                $dados['Funcionalidade']['complexidade'] = \Dominio\TipoComplexidade::$Baixa;
            }
        }
        return $dados['Funcionalidade'];
    }

    public function saveItensAFDFT($dados, $id_funcionalidade) {
        $itens = array();
        $result = array();


        foreach ($dados as $key => $value) {
            if ($value['qtd'] > '0' && $value['qtd'] != '') {
                $itens['Rlitensanalise']['qtde'] = $value['qtd'];
                $itens['Rlitensanalise']['user_id'] = $this->Session->read('Auth.User.id');
                $itens['Rlitensanalise']['justificativa'] = $value['justificativa'];
                $itens['Rlitensanalise']['funcionalidade_id'] = $id_funcionalidade;
                $itens['Rlitensanalise']['item_id'] = $value['item_id'];
                $itens['Rlitensanalise']['st_registro'] = 'S';
                $result[] = $itens;
            }
        }


        return $result;
    }

    public function getCountTRTDAR($value) {
        $trtdNova = explode("\r\n", $value);
        $data = array();
        foreach ($trtdNova as $value) {
            if (!empty($value)) {
                $data[] = $value;
            }
        }
        return $data;
    }

    /**
     * 
     * @param type $dados
     * @return int
     */
    public function regrasCalculoTR($dados) {
        $complexidade = null;
        $qtdPf = 0;


        if ($dados['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI) {
            if (sizeof($dados['tr']) == 1 && sizeof($dados['td']) < 20) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 7;
            } else

            if (sizeof($dados['tr']) == 1 && ( sizeof($dados['td']) >= 20 && sizeof($dados['td']) <= 50 )) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 7;
            } else
            if (sizeof($dados['tr']) == 1 && sizeof($dados['td']) > 50) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 10;
            } else

            if ((sizeof($dados['tr']) >= 2 && sizeof($dados['tr']) <= 5) && sizeof($dados['td']) < 20) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 7;
            } else

            if ((sizeof($dados['tr']) >= 2 && sizeof($dados['tr']) <= 5) && ( sizeof($dados['td']) >= 20 && sizeof($dados['td']) <= 50 )) {

                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 10;
            } else
            if ((sizeof($dados['tr']) >= 2 && sizeof($dados['tr']) <= 5) && sizeof($dados['td']) > 50) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 15;
            } else
            if (sizeof($dados['tr']) > 5 && sizeof($dados['td']) < 20) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 10;
            } else

            if (sizeof($dados['tr']) > 5 && ( sizeof($dados['td']) >= 20 && sizeof($dados['td']) <= 50 )) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 15;
            } else
            if (sizeof($dados['tr']) > 5 && sizeof($dados['td']) > 50) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 15;
            }
        } else if ($dados['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) {
            if (sizeof($dados['tr']) == 1 && sizeof($dados['td']) < 20) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 5;
            } else

            if (sizeof($dados['tr']) == 1 && ( sizeof($dados['td']) >= 20 && sizeof($dados['td']) <= 50 )) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 5;
            } else
            if (sizeof($dados['tr']) == 1 && sizeof($dados['td']) > 50) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 7;
            } else

            if ((sizeof($dados['tr']) >= 2 && sizeof($dados['tr']) <= 5) && sizeof($dados['td']) < 20) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 5;
            } else

            if ((sizeof($dados['tr']) >= 2 && sizeof($dados['tr']) <= 5) && ( sizeof($dados['td']) >= 20 && sizeof($dados['td']) <= 50 )) {

                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 7;
            } else
            if ((sizeof($dados['tr']) >= 2 && sizeof($dados['tr']) <= 5) && sizeof($dados['td']) > 50) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 10;
            } else
            if (sizeof($dados['tr']) > 5 && sizeof($dados['td']) < 20) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 7;
            } else

            if (sizeof($dados['tr']) > 5 && ( sizeof($dados['td']) >= 20 && sizeof($dados['td']) <= 50 )) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 10;
            } else
            if (sizeof($dados['tr']) > 5 && sizeof($dados['td']) > 50) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 10;
            }
        }

        $dados['complexidade'] = $complexidade;
        $dados['qtd_pf'] = $qtdPf;
        return $dados;
    }

    /**
     * 
     * @param type $dados
     * @return int
     */
    public function regrasCalculoAR($dados) {
        $complexidade = null;
        $qtdPf = 0;
        if ($dados['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$CE) {
            // Regras CE
            if (sizeof($dados['ar']) < 2 && sizeof($dados['td']) < 6) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 3;
            } else

            if (sizeof($dados['ar']) < 2 && ( sizeof($dados['td']) >= 6 && sizeof($dados['td']) <= 19 )) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 3;
            } else
            if (sizeof($dados['ar']) < 2 && sizeof($dados['td']) > 19) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 4;
            } else
            if ((sizeof($dados['ar']) >= 2 && sizeof($dados['ar']) <= 3) && sizeof($dados['td']) < 6) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 3;
            } else
            if ((sizeof($dados['ar']) >= 2 && sizeof($dados['ar']) <= 3) && ( sizeof($dados['td']) >= 6 && sizeof($dados['td']) <= 19 )) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 4;
            } else
            if ((sizeof($dados['ar']) >= 2 && sizeof($dados['ar']) <= 3) && sizeof($dados['td']) > 19) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 6;
            } else
            if (sizeof($dados['ar']) > 3 && sizeof($dados['td']) < 6) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 4;
            } else

            if (sizeof($dados['ar']) > 3 && ( sizeof($dados['td']) >= 6 && sizeof($dados['td']) <= 19 )) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 6;
            } else
            if (sizeof($dados['ar']) > 3 && sizeof($dados['td']) > 19) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 6;
            }
        } else
        if ($dados['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$SE) {
            // Regras SE
            if (sizeof($dados['ar']) < 2 && sizeof($dados['td']) < 6) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 4;
            } else

            if (sizeof($dados['ar']) < 2 && ( sizeof($dados['td']) >= 6 && sizeof($dados['td']) <= 19 )) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 4;
            } else
            if (sizeof($dados['ar']) < 2 && sizeof($dados['td']) > 19) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 5;
            } else

            if ((sizeof($dados['ar']) >= 2 && sizeof($dados['ar']) <= 3) && sizeof($dados['td']) < 6) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 4;
            } else
            if ((sizeof($dados['ar']) >= 2 && sizeof($dados['ar']) <= 3) && ( sizeof($dados['td']) >= 6 && sizeof($dados['td']) <= 19 )) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 5;
            } else
            if ((sizeof($dados['ar']) >= 2 && sizeof($dados['ar']) <= 3) && sizeof($dados['td']) > 19) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 7;
            } else
            if (sizeof($dados['ar']) > 3 && sizeof($dados['td']) < 6) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 5;
            } else

            if (sizeof($dados['ar']) > 3 && ( sizeof($dados['td']) >= 6 && sizeof($dados['td']) <= 19 )) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 7;
            } else
            if (sizeof($dados['ar']) > 3 && sizeof($dados['td']) > 19) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 7;
            }
        } else if ($dados['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$EE) {
            // Regras EE
            if (sizeof($dados['ar']) < 2 && sizeof($dados['td']) < 5) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 3;
            } else

            if (sizeof($dados['ar']) < 2 && ( sizeof($dados['td']) >= 5 && sizeof($dados['td']) <= 15 )) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 3;
            } else
            if (sizeof($dados['ar']) < 2 && sizeof($dados['td']) > 15) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 4;
            } else
            if (sizeof($dados['ar']) == 2 && sizeof($dados['td']) < 5) {
                $complexidade = \Dominio\TipoComplexidade::$Baixa;
                $qtdPf = 3;
            } else
            if (sizeof($dados['ar']) == 2 && (sizeof($dados['td']) >= 5 && sizeof($dados['td']) <= 15)) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 4;
            } else
            if (sizeof($dados['ar']) == 2 && sizeof($dados['td']) > 15) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 6;
            } else
            if (sizeof($dados['ar']) > 2 && sizeof($dados['td']) < 5) {
                $complexidade = \Dominio\TipoComplexidade::$Media;
                $qtdPf = 4;
            } else

            if (sizeof($dados['ar']) > 2 && ( sizeof($dados['td']) >= 5 && sizeof($dados['td']) <= 15 )) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 6;
            } else
            if (sizeof($dados['ar']) > 2 && sizeof($dados['td']) > 15) {
                $complexidade = \Dominio\TipoComplexidade::$Alta;
                $qtdPf = 6;
            }
        }
        $dados['complexidade'] = $complexidade;
        $dados['qtd_pf'] = $qtdPf;
        return $dados;
    }

    /**
     * 
     * @param type $data
     * @param type $funcionalidade_id
     * @return type
     */
    public function configTDTRAR($data, $funcionalidade_id, $tipo) {
        $arrData = array();
        $return = array();
        $nomes = array();
        foreach ($data as $value) {
            $arrData['Tdstrsar']['nome'] = trim($value);
            $arrData['Tdstrsar']['funcionalidade_id'] = $funcionalidade_id;
            $arrData['Tdstrsar']['tipo'] = $tipo;
            $nomes[] = $value;
            $return[] = $arrData;
        }


        return $return;
    }

    public function configItems($itens, $idAnalise) {
        $Rlitens = array();
        $cont = 0;
        foreach ($itens as $key => $value) {
            if ($value['qtd'] != '' && $value['qtd'] != '0') {
                $Rlitens[$cont]['Rlitensanalise']['qtde'] = $value['qtd'];
                $Rlitens[$cont]['Rlitensanalise']['analise_id'] = $idAnalise;
                $Rlitens[$cont]['Rlitensanalise']['item_id'] = $value['item_id'];
                $Rlitens[$cont]['Rlitensanalise']['user_id'] = $this->Session->read('Auth.User.id');
                $Rlitens[$cont]['Rlitensanalise']['justificativa'] = $value['justificativa'];
                $Rlitens[$cont]['Rlitensanalise']['st_registro'] = 'S';
                $cont++;
            }
        }
        if (empty($Rlitens)) {

            return false;
        }
        return $Rlitens;
    }
    
     public function configDocs($docs,$descricao, $idAnalise) {
        $Rldocs = array();
        
        $uploadFolder = WWW_ROOT. 'documentos' . DS . $idAnalise; 
        $filename = basename($docs['name']);
        $file = explode('.', $filename);
        $arquivosPermitidos =array('pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'zip', 'sql', 'ppt', 'pps', 'html', 'htm', 'svg');
        if(in_array($file[1], $arquivosPermitidos)){
            $filename = time() .'_'. $filename; 
            $Rldocs['Documento']['analise_id'] = $idAnalise;
            $Rldocs['Documento']['user_id'] = $this->Session->read('Auth.User.id');
            $Rldocs['Documento']['descricao'] = $descricao;
            $Rldocs['Documento']['nome'] = $docs['name'];
            $Rldocs['Documento']['nomeFisico'] = $filename;
            $Rldocs['Documento']['st_registro'] = 'S';

            $uploadPath =  $uploadFolder .  DS .$filename;
            if( !file_exists($uploadFolder) ){
                mkdir($uploadFolder); 
            }
            move_uploaded_file($docs['tmp_name'], $uploadPath);        
            if (empty($Rldocs)) {
                return array();
            }
            return $Rldocs;
        
        }else{
            return 0;
        }
    }
    
    public function CopiarArquivosAnalise($idNovo, $idDuplicado){
        
        $diretorio = WWW_ROOT. 'documentos' . DS . $idDuplicado; 
        $destino = WWW_ROOT. 'documentos' . DS . $idNovo; 
        if ($destino{strlen($destino) - 1} == '/'){
            $destino = substr($destino, 0, -1);
        }
        if (!is_dir($destino)){
            mkdir($destino, 0755);
        } 
        $folder = opendir($diretorio);
        while ($item = readdir($folder)){
            if ($item == '.' || $item == '..'){
                continue;
            }
            if (is_dir("{$diretorio}/{$item}")){
                copy_dir("{$diretorio}/{$item}", "{$destino}/{$item}");
            }else{ 
                copy("{$diretorio}/{$item}", "{$destino}/{$item}");
            }
        }
   }

    public function calculaItem($itens) {
        if (empty($itens)) {
            return;
        }
        $total = array();


        foreach ($itens as $key => $value) {

           
            if ($value['qtd'] > '0' && $value['qtd'] != '') {
                

                $valorPfItem = $this->Item->find('first', array('conditions' => array(
                        'id' => $value['item_id'],
                        'st_registro' => 'S'
                    ),
                    'fields' => 'valor_pf'));

                $totalValor = $valorPfItem['Item']['valor_pf'] * $value['qtd'];
                 
                $total[] =round($totalValor, 2);
                 
            }
        }
        $totalpf = 0;
        foreach ($total as $value) {
            $totalpf = $totalpf + $value;
        }
        return round($totalpf, 2);
    }

    public function configFuncionalidades($funcionalidades, $tipo_contagem = null) {
        $dataFuncionalidade = array();
        foreach ($funcionalidades as $value) {
            $value['Funcionalidade']['tds'] = $this->Tdstrsar->find('all', array('conditions' =>
                array(
                    'Tdstrsar.funcionalidade_id' => $value['Funcionalidade']['id'],
                    'Tdstrsar.tipo' => \Dominio\Tdtrar::$TD),
                'fields' => array('id', 'nome', 'tipo'),
                'order' => array('nome')));
            if ($value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE || $value['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI) {
                $value['Funcionalidade']['trs'] = $this->Tdstrsar->find('all', array('conditions' =>
                    array(
                        'Tdstrsar.funcionalidade_id' => $value['Funcionalidade']['id'],
                        'Tdstrsar.tipo' => \Dominio\Tdtrar::$TR),
                    'fields' => array('id', 'nome', 'tipo'),
                    'order' => array('nome')));
            } else {
                $value['Funcionalidade']['ars'] = $this->Tdstrsar->find('all', array('conditions' =>
                    array(
                        'Tdstrsar.funcionalidade_id' => $value['Funcionalidade']['id'],
                        'Tdstrsar.tipo' => \Dominio\Tdtrar::$AR),
                    'fields' => array('id', 'nome', 'tipo'),
                    'order' => array('nome')));
            }
            $dataFuncionalidade[] = $value;
        }

        return $dataFuncionalidade;
    }

    public function configHistoryFuncionalidades($funcionalidades, $tipo_contagem = null) {

        $dataFuncionalidade = array();
        foreach ($funcionalidades as $value) {


            $value['Thfuncionalidade']['tds'] = $this->Thtdstrsar->find('all', array('conditions' =>
                array(
                    'Thtdstrsar.funcionalidade_id' => $value['Thfuncionalidade']['funcionalidade_id'],
                    'Thtdstrsar.history' => $value['Thfuncionalidade']['history'],
                //          'Thtdstrsar.tipo' => \Dominio\Tdtrar::$TD
                ),
                'fields' => array('id', 'nome', 'tipo')));


            if ($value['Thfuncionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE || $value['Thfuncionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI) {
                $value['Thfuncionalidade']['trs'] = $this->Thtdstrsar->find('all', array('conditions' =>
                    array(
                        'Thtdstrsar.funcionalidade_id' => $value['Thfuncionalidade']['funcionalidade_id'],
                        'Thtdstrsar.history' => $value['Thfuncionalidade']['history'],
                        'Thtdstrsar.tipo' => \Dominio\Tdtrar::$TR),
                    'fields' => array('id', 'nome', 'tipo')));
            } else {
                $value['Thfuncionalidade']['ars'] = $this->Thtdstrsar->find('all', array('conditions' =>
                    array(
                        'Thtdstrsar.funcionalidade_id' => $value['Thfuncionalidade']['funcionalidade_id'],
                        'Thtdstrsar.history' => $value['Thfuncionalidade']['history'],
                        'Thtdstrsar.tipo' => \Dominio\Tdtrar::$AR),
                    'fields' => array('id', 'nome', 'tipo')));
            }

            $dataFuncionalidade[] = $value;
        }

        return $dataFuncionalidade;
    }

    public function calculaPF($analise, $funcionalidade, $itens = null, $id_funcionalidade = null) {
        $saveAnalise = array();

        $saveAnalise['Analise']['total_pf'] = $analise['Analise']['total_pf'] + $funcionalidade['Funcionalidade']['qtd_pf'];
        $funcionalidade_ajustada = $this->deflatores($funcionalidade, $analise);
        $saveAnalise['Analise']['total_pf_itens'] = 0;
        $total_itens = 0;
        if (isset($funcionalidade['Funcionalidade']['item']) ) {
                
                if( !empty($itens) ){
                    $saveAnalise['Analise']['total_pf_itens'] = $analise['Analise']['total_pf_itens'] + $this->calculaItem($itens);
                    $total_itens = $this->calculaItem($itens);
                }
        }

        $valorFator = empty($analise['Analise']['fator']) ? '1' : $analise['Analise']['fator'];
        $saveAnalise['Analise']['total_pf_ajustado'] = ( $funcionalidade_ajustada['Funcionalidade']['qtd_pf'] * $valorFator ) + $analise['Analise']['total_pf_ajustado'];
        $saveAnalise['Analise']['valor_fator'] = $analise['Analise']['valor_fator'] + ( $funcionalidade_ajustada['Funcionalidade']['qtd_pf'] * $valorFator ) + $total_itens;
        return $saveAnalise;
    }

    public function deflatores($funcionalidade, $analise) {
       // $deflatores = $this->Deflatore->find("first");
        $contrato = $this->Contrato->find("first", array('conditions' => array('id' => $analise['Analise']['id_contrato'])));
       
        if ($analise['Analise']['tipo_contagem'] == \Dominio\TipoContagem::$projetoMelhoria || $analise['Analise']['tipo_contagem'] == \Dominio\TipoContagem::$projetoDesenvolvimento) {
            switch ($funcionalidade['Funcionalidade']['impacto']) {
                case \Dominio\TipoImpacto::$Inclusao:
                    $funcionalidade['Funcionalidade']['qtd_pf'] = $funcionalidade['Funcionalidade']['qtd_pf'] * ( $contrato['Contrato']['inclusao'] / 100 );
                    break;
                case \Dominio\TipoImpacto::$Alteracao:
                    $funcionalidade['Funcionalidade']['qtd_pf'] = $funcionalidade['Funcionalidade']['qtd_pf'] * ( $contrato['Contrato']['alteracao'] / 100 );
                    break;
                case \Dominio\TipoImpacto::$Exclusao:
                    $funcionalidade['Funcionalidade']['qtd_pf'] = $funcionalidade['Funcionalidade']['qtd_pf'] * ( $contrato['Contrato']['exclusao'] / 100 );
                    break;

                default:
                    break;
            }
        }
        return $funcionalidade;
    }

    /**
     * Calcula o valor da funcionalidade e diminui o valor ajustado
     * @param type $funcionalidade
     * @param type $tipo_contagem
     * @return type
     */
    public function ajusteFuncionalidade($funcionalidade, $analise, $total_pf) {
        $funcionalidade['Funcionalidade']['qtd_pf_ajustado'] = 0;
                
        $contrato = $this->Contrato->find("first", array('conditions' => array('id' => $analise['id_contrato'])));
       
        $tipo_contagem = $analise['tipo_contagem'];
        if ($tipo_contagem == \Dominio\TipoContagem::$projetoMelhoria || $tipo_contagem == \Dominio\TipoContagem::$projetoDesenvolvimento) {
                
            switch ($funcionalidade['Funcionalidade']['impacto']) {
                case \Dominio\TipoImpacto::$Inclusao:
                    $funcionalidade['Funcionalidade']['qtd_pf_ajustado'] = $funcionalidade['Funcionalidade']['qtd_pf'] * ( $contrato['Contrato']['inclusao'] / 100 );
                    break;
                case \Dominio\TipoImpacto::$Alteracao:
                    $funcionalidade['Funcionalidade']['qtd_pf_ajustado'] = $funcionalidade['Funcionalidade']['qtd_pf'] * ( $contrato['Contrato']['alteracao'] / 100 );
                    break;
                case \Dominio\TipoImpacto::$Exclusao:
                    $funcionalidade['Funcionalidade']['qtd_pf_ajustado'] = $funcionalidade['Funcionalidade']['qtd_pf'] * ( $contrato['Contrato']['exclusao'] / 100 );
                    break;

                default:
                    break;
            }
            return " " . $funcionalidade['Funcionalidade']['qtd_pf_ajustado'];
        } else {

            return $total_pf;
        }
    }

    public function br2nl($string) {
        return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
    }

}
