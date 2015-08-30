<?php

function preg_grep_keys($pattern, $input, $flags = 0) {
    $keys = preg_grep($pattern, array_keys($input), $flags);
    $vals = array();
    $i = 0;
    foreach ($keys as $key) {
        $vals[$i++] = intval(ltrim($key, 'C'));
    }
    return $vals;
}

function preg_grep_keys_return_values($pattern, $input, $flags = 0) {
    $keys = preg_grep($pattern, array_keys($input), $flags);
    $vals = array();
    $i = 0;
    foreach ($keys as $key) {
        $vals[$i++] = $input[$key];
    }
    return $vals;
}

function post(&$a) {
    if ($a['request']['pathname'] != '/question-part4' && $a['request']['pathname'] != '/question-part3') {
        $a['message_dlg'] = 'Please complete this question first.';
        \Edu8\Http::Redirect('/question-part3', $a);
    } else {
        if($a['request']['pathname'] == '/question-part4') {
            unset($a['message_dlg']);
        }
    }
    
    if ($a['request']['pathname'] == '/question-part4') {
        if (array_key_exists('question_num', $a)) {
            $concepts = implode(",", preg_grep_keys_return_values('/^tag/', $a['request']));
            $connection = \Edu8\Config::initDb();
            
            if($a['question'][$a['question_num']]['alpha'] == "1")
                    $a['request']['second_answer'] = $a['from_alpha'][$a['request']['second_answer']];
            
            if (!$a['student']['is_professor']) {
                try {
                    $voted_rationale_ = $a['request']['response_'];                    
                    
                    if (strlen($a['request']['response_'])){
                        unset($voted_rationale_);
                        $connection->exec('update response SET votes=votes+1 WHERE response_ =' . $a['request']['response_']);
                    }
                    $connection->insert('response', ['student_' => $a['student']['student_'], 'voted_rationale' => $voted_rationale_, 'assignment_' => $a['assignment'], 'question_' => $a['question'][$a['question_num']]['question_'], 'answer' => $a['request']['answer'], 'second_answer' => $a['request']['second_answer'], 'rationale' => $a['request']['rationale'], 'concepts' => $concepts]);
                } catch (Exception $e) {
                    unset($e);
                    //echo 'RESUBMIT ignored.';
                }
            }
        }
    }
}

?>