<?php
$config = new \Doctrine\DBAL\Configuration();
$connectionParams = [
'dbname' => 'dalite',
    'user' => 'root',
    'password' => 'koyaa77',
    'host' => '127.0.0.1',
    'driver' => 'pdo_mysql'];
return \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
?>
