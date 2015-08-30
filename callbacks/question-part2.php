<?php

function post(&$a) {
    if($a['request']['pathname'] != '/question-part3' && $a['request']['pathname'] != '/question-part2'){
       $a['message_dlg'] = 'Please complete this question first.';
        \Edu8\Http::Redirect('/question-part2', $a);
    } else {
        if($a['request']['pathname'] == '/question-part3') {
            unset($a['message_dlg']);
        }
    }
}
?>
