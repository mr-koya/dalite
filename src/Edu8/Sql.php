<?php

namespace Edu8;

class Sql {
    public static function getStatement($statement) {
        $filename = __DIR__ . '/../../sql/' . $statement . '.sql';
        if (is_file($filename)) {
            ob_start();
            include $filename;
            return ob_get_clean();
        }
        throw new Exception('No sql statement named: ' . $statement, 100001);
    }


    public static function runStatement($connection, $statement, $vars = []) {
             $db_statement = $connection->prepare(Sql::getStatement($statement));
            foreach($vars as $key => $val){
                $db_statement->bindValue($key, $val);
            }
            $db_statement->execute();
            return $db_statement;
    }


}

?>
