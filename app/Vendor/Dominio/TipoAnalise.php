<?php


namespace Dominio;

class TipoAnalise {

    public static $INM = 'I';
    public static $UST = 'U';
    
    private static $tipos = array
        (
        'I' => 'INM',
        'U' => 'UST'
    );

    public static function getTodosTipos()
    {
        return self::$tipos;
    }
    
    public static function getTipoById($id){
        
        return self::$tipos[$id];
    }

}
