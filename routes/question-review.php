<?php

$counter = 1;

function tagLabels(&$labels) {
    global $counter;
     
    foreach ($labels as &$label) {
        if(isset($label[1]) && is_array($label[1])) {
            tagLabels($label[1]);
        }
        else {
             $label = [$label, $counter]; 
             $counter++;
        }
    }
}

function build(&$a) {
    if (!array_key_exists('assignment', $a['request'])) {
        unset($a['question_num']);
        \Edu8\Http::redirect('/');
    }

    if ($a['question_num'] < $a['question_total'] - 1)
    {
        if (array_key_exists('question_num', $a))
        {
            $a['question_num']++;
        } else {
            $a['question_num'] = 0;
        }
            
    } else {
        unset($a['question_num']);
        \Edu8\Http::redirect('/');
    }

    $a['alpha'] = ['Z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
    $a['from_alpha'] = ['Z' => 0, 'A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7, 'H' => 8, 'I' => 9];
    $a['assignment'] = $a['request']['assignment'];
    $connection = \Edu8\Config::initDb();

    if ($a['question_num'] == 0) {
        $question_statement = \Edu8\Sql::runStatement($connection, 'assignment_question_response', ['student' => $a['student']['student_'], 'assignment' => $a['assignment']]);
        $a['question'] = $question_statement->fetchAll();
        
        $question_total_statement = \Edu8\Sql::runStatement($connection, 'assignment_question_count', ['assignment' => $a['assignment']]);
        $a['question_total'] = reset($question_total_statement->fetch());
        
        /* foreach ($a['question'] as &$q) {
          $q['concepts'] = preg_split('/,/', $q['concepts']);
          } */
   } 
}


?>
