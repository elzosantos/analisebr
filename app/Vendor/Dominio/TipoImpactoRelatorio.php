<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dominio;

class TipoImpactoRelatorio {

    public static $Inclusao = '1';
    public static $Alteracao = '2';
    public static $Exclusao = '3';
    private static $impactos = array
        (
        '1' => 'I',
        '2' => 'A',
        '3' => 'E'
    );

    public static function getTodosImpactos()
    {
        return self::$impactos;
    }
    
    public static function getImpactoById($id){
        return self::$impactos[$id];
    }

}
