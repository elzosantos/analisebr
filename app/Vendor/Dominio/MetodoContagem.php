<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dominio;

class MetodoContagem {

    public static $detalhada = '1';
    public static $estimada = '2';
    public static $indicativa = '3';
    
    private static $metodos = array
        (
        '1' => 'Detalhada (IFPUG)',
        '2' => 'Estimada (NESMA)',
        '3' => 'Indicativa (NESMA)',
    );

    public static function getTodosMetodos()
    {
        return self::$metodos;
    }
    
    public static function getMetodoById($id){
        return self::$metodos[$id];
    }

}
