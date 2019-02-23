<?php

App::uses('AppController', 'Controller');

class AnaliustsAppController extends AppController {

    public $uses = array('Analise', 'Analiust','Fases.Fase', 'Usts.Ust',
        'Sistemas.Sistema', 'Funcionalidade', 'Tdstrsar', 'Linguagens.Linguagem', 'Thanalise','Thanaliust', 'Thfuncionalidade', 'Thtdstrsar',
        'Equipes.Equipe', 'Itens.Item', 'Rlitensanalises.Rlitensanalise', 'Deflatores.Deflatore', 'Datalock', 'Users.User');

    

    public function createHistory($id) {
        $identificador = uniqid(time());
        $analise = $this->Analiust->find('first', array('conditions' => array('id' => $id)));
        $thanalise['Thanaliust'] = $analise['Analiust'];
        $thanalise['Thanaliust']['history'] = $identificador;
        $thanalise['Thanaliust']['analise_id'] = $analise['Analiust']['id'];
        $thanalise['Thanaliust']['id'] = null;

        $this->Thanaliust->save($thanalise);

       
    }

    public function configItems($usts, $idAnalise) {
        $Rlusts = array();
        $cont = 0;
    

        foreach ($usts as $key => $value) {
            if ($value['qtd'] != '' && $value['qtd'] != '0') {
              
                $Rlusts[$cont]['Rlustsanalise']['qtde'] = $value['qtd'];
                $Rlusts[$cont]['Rlustsanalise']['analise_id'] = $idAnalise;
                $Rlusts[$cont]['Rlustsanalise']['ust_id'] = $value['ust_id'];
                $Rlusts[$cont]['Rlustsanalise']['user_id'] = $this->Session->read('Auth.User.id');
                $Rlusts[$cont]['Rlustsanalise']['justificativa'] = $value['justificativa'];
                $Rlusts[$cont]['Rlustsanalise']['st_registro'] = 'S';
                $cont++;
            }
        }
        if (empty($Rlusts)) {

            return false;
        }
        return $Rlusts;
    }

    public function calculaUsts($usts) {
        if (empty($usts)) {
            return;
        }
        $total = array();
        foreach ($usts as $value) {
            if ($value['qtd'] > '0' && $value['qtd'] != '') { 
                
                $valorPfUst = $this->Ust->find('first', array('conditions' => array(
                        'id' => $value['ust_id'],
                        'st_registro' => 'S'
                    ),
                    'fields' => 'valor_pf'));

                $totalValor = $valorPfUst['Ust']['valor_pf'] * $value['qtd'];
                $total[] =round($totalValor, 2);
            }
        }
        $totalpf = 0;
        foreach ($total as $value) {
            $totalpf = $totalpf + $value;
        }


        return round($totalpf, 2);
    }

    protected function retornaGrid($aaData) {
        $data = array();
        foreach ($aaData as $value) {
            if ($value[9] == '0') {
                $value[0] = $value[0] . ' *';
            }
            $dt = strtotime($value[8]); //make timestamp with datetime string 
            $value[8] = date("d/m/Y", $dt); //echo the year of the datestamp just created 

            $data[] = $value;
        }
        return $data;
    }

    public function br2nl($string) {
        return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
    }

}
