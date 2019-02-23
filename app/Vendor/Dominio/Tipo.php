<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dominio;

class Tipo {

 

    public static $DADOS = '1';
    public static $TRANSACAO = '2';

    
    private static $tipos = array
        (
        '1' => 'DADOS',
        '2' => 'TRANSACAO'
    );

    public static function getTodosTipos()
    {
        return self::$tipos;
    }
    
    public static function getTipoById($id){
        return self::$tipos[$id];
    }

}
