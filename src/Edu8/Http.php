<?php

namespace Edu8;

error_reporting(E_ALL);

class Http {
    private static $session;
    
    public static function Init(){
        Http::$session = new \Symfony\Component\HttpFoundation\Session\Session();
        Http::$session->start();
    }
    
    public static function SetSession(&$vars)
    {
            Http::$session->set('twig_vars', $vars);
    }
    
    public static function GetSession()
    {
        if(!Http::$session)
            throw new \Edu8\Exception('Session not intialized');
    
        return Http::$session->get('twig_vars', []);
    }

    public static function Redirect($url, &$vars = null) {
        if(isset($vars))
            Http::SetSession($vars);        
        $response = new \Symfony\Component\HttpFoundation\RedirectResponse($url);
        $response->send();
        exit(0);
    }

}
?>
