<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dominio;

class TipoComplexidade {

    public static $Baixa = '1';
    public static $Media = '2';
    public static $Alta = '3';
    private static $complexidades = array
        (
        '1' => 'Baixa',
        '2' => 'Média',
        '3' => 'Alta',
    );

    public static function getTodasComplexidades()
    {
        return self::$complexidades;
    }
    
    public static function getComplexidadeById($id){
        return self::$complexidades[$id];
    }

}
