<?php
function build (&$a){
    
        $connection = \Edu8\Config::initDb();
        $questions = \Edu8\Sql::runStatement($connection, 'assignment_question', ['assignment' => $a['request']['assignment']]);
        $results = \Edu8\Sql::runStatement($connection, 'results', ['assignment' => $a['request']['assignment']]);
        $a['question_list'] = $questions->fetchAll();

        $rows = $results->fetchAll();
        $lastSid = $rows[0]['student_'];
        $a['student_results'] = [];
        $work = [];
        foreach ($rows as $row){
            if ($row['student_'] != $lastSid)
            {
                $lastSid = $row['student_'];
                $a['student_results'][] = $work;
                $work = [];
            }
            $work[] = $row;
        }
        $a['student_results'][] = $work;
               
} 
?>
