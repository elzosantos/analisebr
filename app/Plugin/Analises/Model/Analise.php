<?php

App::uses('AnalisesAppModel', 'Analises.Model');

class Analise extends AnalisesAppModel {

    public $name = 'Analise';
    public $belongsTo = array(
        'Sistema' => array(
            'className' => 'Sistema',
            'foreignKey' => 'sistema_id',
            'conditions' => array('Sistema.st_registro' => 'S'),
            'fields' => array('Sistema.id', 'Sistema.nome', 'Sistema.st_registro'),
            'counterCache' => 'true',
            'counterScope' => array(),
            'order' => array('Sistema.nome' => 'ASC')
        )
    );

    
     /**
     * 
     * @param type $dados
     * @return int
     */
    public function regrasCalculoTR($dados)
    {
        $complexidade = null;
        $qtdPf = 0;
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

        $dados['complexidade'] = $complexidade;
        $dados['qtd_pf'] = $qtdPf;
        return $dados;
    }

    /**
     * 
     * @param type $dados
     * @return int
     */
    public function regrasCalculoAR($dados)
    {


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
    public function configTR($data, $funcionalidade_id)
    {
        $arrData = array();
        $return = array();
        foreach ($data['tr'] as $key => $value) {
            $arrData['Tr']['nome'] = $value;
            $arrData['Tr']['sistema_id'] = $data['sistema_id'];
            $arrData['Tr']['funcionalidade_id'] = $funcionalidade_id;
            $return[] = $arrData;
        }
        return $return;
    }

    /**
     * 
     * @param type $data
     * @param type $funcionalidade_id
     * @return type
     */
    public function configTD($data, $funcionalidade_id)
    {
        $arrData = array();
        $return = array();
        foreach ($data['td'] as $key => $value) {
            $arrData['Td']['nome'] = $value;
            $arrData['Td']['sistema_id'] = $data['sistema_id'];
            $arrData['Td']['funcionalidade_id'] = $funcionalidade_id;
            $return[] = $arrData;
        }
        return $return;
    }

    /**
     * 
     * @param type $data
     * @param type $funcionalidade_id
     * @return type
     */
    public function configAR($data, $funcionalidade_id)
    {
        $arrData = array();
        $return = array();
        foreach ($data['ar'] as $key => $value) {
            $arrData['Ar']['nome'] = $value;
            $arrData['Ar']['sistema_id'] = $data['sistema_id'];
            $arrData['Ar']['funcionalidade_id'] = $funcionalidade_id;
            $return[] = $arrData;
        }
        return $return;
    }


}
