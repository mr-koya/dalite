<?php

function build (&$a){
    $connection = \Edu8\Config::initDb();
    
    $answered_questions = \Edu8\Sql::runStatement($connection, 'answered_questions');
    $a['answered_questions'] = $answered_questions->fetchAll();
    
    //Get the question id from the post var or from the top of the list of questions.
    $question_ = isset($a['request']['question_']) ? $a['request']['question_'] : $a['answered_questions'][0]['question_'];
    
    $question = \Edu8\Sql::runStatement($connection, 'question_graph', ['question_' => $question_]);
    $question_graph = $question->fetchAll()[0];
    
    $question_answers = \Edu8\Sql::runStatement($connection, 'question_answers_graph', ['question_' => $question_]);
    $question_answers_graph = $question_answers->fetchAll();
    
    $answers_tags = \Edu8\Sql::runStatement($connection, 'answers_tags_graph', ['question_' => $question_]);
    $answers_tags_graph = $answers_tags->fetchAll();
    
    $a['alpha'] = $question_graph['alpha'];
    
    $a['num_choice'] = $question_graph['num_choice'];
    $a['num_choice_col1'] = floor($question_graph['num_choice'] / 2);
    
    $a['correct_choices'] = $question_graph['answer'] . ', ' . $question_graph['second_choice'];
    
    $a['media1'] = $question_graph['media1'];
    
    $a['question_answers_graph'] = [];
    
    //Initialize the choices graph.
    for($i = 0; $i < $question_graph['num_choice']; $i++) {
        $a['question_answers_graph'][$i] = 0;
    }
    
    //Populate the choices graph.
    for($i = 0; $i < count($question_answers_graph); $i++) {
        $a['question_answers_graph'][$question_answers_graph[$i]['answer'] - 1] = $question_answers_graph[$i]['count'];
    }
    
    $a['question_answers_graph'] = implode($a['question_answers_graph'], ', ');
    
    $question_tag_graph = explode(',', $question_graph['concepts']);
    sort($question_tag_graph);
    $a['question_tag_graph'] = '"' . implode($question_tag_graph, '" ,"') . '"';
    
    //Initialize the tag graphs.
    $a['answers_tags_graphs'] = [];
    $answer_counter = [];
    for($i = 0; $i < $question_graph['num_choice']; $i++) {
        $a['answers_tags_graphs'][$i] = [];
        $answer_counter[$i] = 0;
        
        for($j = 0; $j < count($question_tag_graph); $j++) {
            $a['answers_tags_graphs'][$i][$j] = 0;
        }
    }
    
    //Populate the tag graphs.
    for($i = 0; $i < count($answers_tags_graph); $i++) {
        $tags = explode(',', $answers_tags_graph[$i]['concepts']);
        $answer = $answers_tags_graph[$i]['answer'] - 1;
        
        $answer_counter[$answer]++;
        for($j = 0; $j < count($question_tag_graph); $j++) {
            if(array_search($question_tag_graph[$j], $tags) !== false) {
                $a['answers_tags_graphs'][$answer][$j]++;
            }
        }
    }
    
    //Normalize the tag graphs.
    for($i = 0; $i < count($a['answers_tags_graphs']); $i++) {
        for($j = 0; $j < count($a['answers_tags_graphs'][$i]); $j++) {
            if($answer_counter[$i] > 0) {
                $a['answers_tags_graphs'][$i][$j] *= 100 / $answer_counter[$i];
            }
        }
    }
    
    for($i = 0; $i < $question_graph['num_choice']; $i++) {
        $a['answers_tags_graphs'][$i] = implode($a['answers_tags_graphs'][$i], ', ');
    }
}
?>
