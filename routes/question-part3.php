<?php

function chooseRationales(&$rows) {
    $results = [];
    $expert = [];
    $votes = [];
    $max_vote = 0;
    if (count($rows) > 4) {
        for ($i = 0; $i < count($rows); $i++)
            $max_vote = $max_vote > intval ($rows[$i]['votes']) ? $max_vote : intval($rows[$i]['votes']);

        foreach ($rows as $row)
            if ($row['expert'])
                $expert[] = $row;
            elseif ($row['votes'] > floor($max_vote / 2))
                $votes[] = $row;
            else
                $remain_rows[] = $row;

        if (count($expert))
            $results[] = $expert[array_rand($expert)];

        if (count($votes))
            $results[] = $votes[array_rand($votes)];

        $rand_remain = array_rand($remain_rows, 4 - count($results));

        for ($i = 0; $i < count($rand_remain); $i++)
            $results[] = $remain_rows[$rand_remain[$i]];
    } else {
        $results = $rows;
    }
    
    shuffle($results);
    return($results);
}

function build(&$a) {
    $connection = \Edu8\Config::initDb();
    $q = $a['question'][$a['question_num']];
    unset($a['request']['C1']);
    unset($a['request']['C2']);
    unset($a['request']['C3']);
    unset($a['request']['C4']);
    unset($a['request']['C5']);

    if ($a['request']['answer'] == $q['answer'])
        $second_choice = $q['second_choice'];
    else
        $second_choice = $a['request']['answer'];

    $db_statement = \Edu8\Sql::runStatement($connection, 'rationales', ['question' => $q['question_'],
                'answer' => $second_choice,]);
    $a['rationales2'] = chooseRationales($db_statement->fetchAll());

    $db_statement2 = \Edu8\Sql::runStatement($connection, 'rationales', ['question' => $q['question_'],
                'answer' => $q['answer'],]);
    $a['rationales'] = chooseRationales($db_statement2->fetchAll());

    $a['other'] = $second_choice;
    $a['swap'] = rand(0, 1);
}
