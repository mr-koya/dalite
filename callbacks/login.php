<?php
function post (&$a){
    if($a['request']['log']){
        $connection = \Edu8\Config::initDb();
        $db_statement = \Edu8\Sql::runStatement($connection,
                'login', ['login' => $a['request']['log']]);
        $students = $db_statement->fetchAll();
        if(count($students)){
            $a['student'] = $students[0];
            if(!strcmp($a['student']['password'],$a['request']['pwd'])){
                $a['auth'] = true;
                return;
            }
        }
    $a['message_dlg'] = 'Please provide correct login and password';    
    } 
}
?>
