<?php

function readLogins($path) {
    foreach (file($path) as $row) {
        $logins[] = ltrim(rtrim(explode(',', $row)[0], "\""), "\"");
    }
    array_shift($logins); //drop the first line

    return $logins;
}

function post(&$a) {
    if (isset($a['request']['file'])) {
        $filename = $a['request']['file'];
        ini_set("auto_detect_line_endings", true); //Fix for mac etc. ;)
        //perform mysql import
        system('chmod 444 ' . $filename);
        $outfile = fopen('/tmp/student.csv', 'w');
        $file = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($file as $line) {
            fputs($outfile, $line . PHP_EOL);
        }
            fclose($outfile);

            system('mysqlimport --ignore-lines=1 -vv --local --columns=login,password,firstname,lastname --fields-optionally-enclosed-by="\"" --fields-terminated-by="," -u root --password=xxxxxx dalite /tmp/student.csv', $noerr);
            $params = readLogins('/tmp/student.csv');

            if (!noerr || !count($params))
                throw new Edu8\Exception("import error");

            $params[] = $a['student']['login']; //Add prof to assignment
            system('rm /tmp/student.csv');

            $connection = \Edu8\Config::initDb();
            $connection->insert('course', ['professor_' => $a['student']['student_'], '`name`' => $a['request']['name'], '`accessible`' => '1']);
            $course_id = $connection->lastInsertId();

            ## get use the where in (logins) from the file to get the student_ ids to add to student_course
            $sql = Edu8\Sql::getStatement('insert-students-by-login');
            $connection->executeQuery($sql, [$course_id, $params], [\PDO::PARAM_INT, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY]);
    }
}

?>
