<?php

App::uses('AppController', 'Controller');

class SistemasAppController extends AppController {
    public function getResumo($funcionalidades)
    {
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

}
