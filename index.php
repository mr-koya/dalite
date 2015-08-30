<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;
use Edu8\Http;

function main() {
    $request = Request::createFromGlobals();
    Http::Init();
    
    //Get routes and match with incomming url
    $context = new Routing\RequestContext();
    $context->fromRequest($request);
    $routes = Edu8\Route::getRoutes(__DIR__ . '/../routes/');
    $matcher = new Routing\Matcher\UrlMatcher($routes, $context);

    try {
        $request->attributes->add($matcher->match($request->getPathInfo() ) );
        $file_root = $request->attributes->get('file_root');
        $slug = $request->attributes->get('slug');
    } catch(\Exception $e) {
        $file_root = rtrim($request->getPathInfo(),'/');
        $slug = '';//$request->attributes->get('slug');
    }
    $twig_vars = Http::GetSession();

    if (empty($twig_vars['request']))
        $twig_vars['request'] = $request->request->all();
    else
        $twig_vars['request'] = array_merge($twig_vars['request'], $request->request->all());

    $twig_vars['request']['pathname'] = $request->getPathInfo();
    if ($request->files->has('file')) {
        $twig_vars['request']['file'] = $request->files->get('file')->getPathname();
    }
    Http::SetSession($twig_vars);

    if (isset($twig_vars['auth']) && $file_root === '/login') {
        Http::Redirect('/');
    }
    
    if (!isset($twig_vars['auth']) && $file_root !== '/login') {
        Http::Redirect('/login');
    }

    //Merge session and post variables 
  try{
      if(isset($_SERVER['HTTP_REFERER'])){
        //Get routes and match with refer url
        $routes2 = Edu8\Route::getRoutes(__DIR__ . '/../callbacks/');
        $matcher2 = new Routing\Matcher\UrlMatcher($routes2, $context);
        $try = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
        $attribs = $matcher2->match($try);

        //Dispatch post() from appropriate file
        if(is_file($attribs['php_file'])){
            include $attribs['php_file'];
            post($twig_vars);
        }
      }
    }catch(Routing\Exception\ResourceNotFoundException $e){
       
    }

    //Dispatch build() from appropriate file
    if(is_file($request->attributes->get('php_file'))){
           include $request->attributes->get('php_file');
        build($twig_vars);
    }
    Http::SetSession($twig_vars);

    if (strpos($twig_vars['request']['pathname'],'admin') && $twig_vars['student']['is_professor'] != 1) {
        Http::Redirect('/');
    }

    //Render twig with varables assembled in build()
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates');
    $twig = new Twig_Environment($loader);

    $response = new Symfony\Component\HttpFoundation\Response($twig->render($file_root . $slug . '.html.twig', $twig_vars));
    $response->send();
    unset($twig_vars['message_dlg']);

}

try {
    try {
        //MAIN--------------
        main();
        
        
    } catch (\Doctrine\DBAL\DBALException $e) {
        throw new \Doctrine\DBAL\DBALException(
                'ERROR IN SQL Statement. <br>' . $e->getMessage()
                , preg_filter("/.*?SQLSTATE\[\D*(\d*).*$/s", "$1", $e->getMessage()));

    } catch (Routing\Exception\ResourceNotFoundException $e) {
        throw new \Edu8\Exception('Routing\Exception\ResourceNotFoundException Not Found', 404);

    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage()
                , preg_filter("/.*?SQLSTATE\[\D*(\d*).*$/s", "$1"
                , $e->getMessage()));
    }
} catch (Exception $e) {
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates');
    $twig = new Twig_Environment($loader);
    
    $twig_vars['debug_message'] =
            '=== TOP level Exception DEBUG handler === CLASS:'
            . get_class($e) . 'Code:' . $e->getCode(). $e->getMessage();
    
    $response = new \Symfony\Component\HttpFoundation\Response($twig->render('error.html.twig', $twig_vars)
            , $e->getCode() == 404 ? 404 : 500);
    
    $response->send();

}

?>
