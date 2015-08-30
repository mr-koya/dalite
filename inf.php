<?php 
require_once __DIR__ . '/../vendor/autoload.php';

    //Render twig with varables assembled in build()
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates');
    $twig = new Twig_Environment($loader);
    $twig_vars = ['hello'];
    $response = new \Symfony\Component\HttpFoundation\Response($twig->render('info.html.twig', $twig_vars));
    $response->send();
?>

