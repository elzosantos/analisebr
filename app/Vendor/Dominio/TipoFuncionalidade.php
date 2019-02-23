<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dominio;

class TipoFuncionalidade {

 

    public static $ALI = '1';
    public static $AIE = '2';
    public static $SE = '3';
    public static $CE = '4';
    public static $EE = '5';
    
    private static $tipos = array
        (
        '1' => 'ALI',
        '2' => 'AIE',
        '3' => 'SE',
        '4' => 'CE',
        '5' => 'EE'
    );

    public static function getTodosTipos()
    {
        return self::$tipos;
    }
    
    public static function getTipoById($id){
        return self::$tipos[$id];
    }

}
