<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dominio;

class ListaAnalise {

    public static $id = '0';
    public static $status = '1';
    public static $sistema_id = '2';
    public static $nu_demanda = '3';
    public static $user_id = '4';
    public static $equipe_id = '5';
    public static $tipo_contagem = '6';
    public static $metodo_contagem = '7';
    public static $total_pf = '8';
    public static $valor_fator = '9';
    public static $created= '10';
    
    private static $colunms = array
        (
        
           '0' => "id",
           '1' =>  "status",
           '2' => "sistema_id",
           '3' => "nu_demanda",
           '4' =>"user_id",
           '5' => "equipe_id",
           '6' => "tipo_contagem",
           '7' => "metodo_contagem",
           '8' =>"total_pf",
           '9' => "valor_fator",
           '10' => "created"
        
    );

    public static function getLista()
    {
        return self::$colunms;
    }
    
    public static function getListaById($id){
        
        return self::$colunms[$id];
    }

}
