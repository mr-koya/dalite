<?php

function post(&$a) {
    if (array_key_exists('question_num', $a)) {
        $a['question_num']++;

        //reset request var
        $request = [
            'pathname' => $a['request']['pathname'],
            'assignment' => $a['request']['assignment']];
        unset($a['request']);

        $a['request'] = $request;

        if ($a['question_num'] >= count($a['question'])) {
            unset($a['question']);
            unset($a['question_num']);
            unset($a['request']);
            $a['message_dlg'] = 'Bravo, you have completed this assignment';
            Edu8\Http::Redirect('/', $a);
        } else {
            unset($a['message_dlg']);
        }
    }
}

?>
