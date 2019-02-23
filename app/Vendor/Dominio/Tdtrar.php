<?php

namespace Dominio;

class Tdtrar {

    public static $TR = '1';
    public static $AR = '2';
    public static $TD = '3';
    
    private static $tdtrar = array
        (
        '1' => 'TR',
        '2' => 'AR',
        '3' => 'TD'
    );

    public static function getTodos()
    {
        return self::$tdtrar;
    }
    
    public static function getById($id){
        
        return self::$tdtrar[$id];
    }

}
