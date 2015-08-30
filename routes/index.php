<?php

function build(&$a) {
            unset($a['question_num']);
    unset($a['message_dlg']);

    $connection = \Edu8\Config::initDb();
    $db_statement = \Edu8\Sql::runStatement($connection, 'student_assignment', ['student_' => $a['student']['student_']]);
    $a['assignments'] = $db_statement->fetchAll();
}

?>
