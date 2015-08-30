<?php 
    $out = shell_exec("svn up ../");
    echo nl2br($out);
?>

