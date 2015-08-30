<?php

function post(&$a) {
    parse_str($a['request']['postvar']);
    
    if (isset($q)) {
        $connection = \Edu8\Config::initDb();
        $connection->insert('assignment', ['name' => $a['request']['name'], 'published' => 1]);
        $ass_id = $connection->lastInsertId();
        
        for ($i = 0; $i < count($q); $i++) {
            $connection->insert('assignment_question', ['assignment_' => $ass_id, 'question_' => $q[$i], '`order`' => $i]);
        }
        $connection->insert('course_assignment', ['assignment_' => $ass_id, 'course_' => $a['request']['course']]);
    }
}

?>
