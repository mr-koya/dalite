<?php

namespace Edu8;

class Route {

    public static function getRoutes($path) {
        $routes = new \Symfony\Component\Routing\RouteCollection();
        $finder = new \Symfony\Component\Finder\Finder();

        $finder->name('*.php');
        $finder->files()->in($path);
        if (!$finder->count())
            throw new Exception('No routes found in ' . $path);

        foreach ($finder as $entry) {
            $route_path = $entry->getRelativePath();
            $basename = $entry->getBasename('.php');
            $cleaned = str_replace('/', '_', str_replace('-', '_', $route_path . $basename));
            $route = $route_path . (($basename === 'index') ? '' :'/'. $basename);
/*
            if (strrchr($route, '-')) {
                $sluglen = strlen(strrchr($route, '-'));
                $route2 = substr($route, 0, strlen($route) - $sluglen + 1) . '{slug}';
                $basename2 = substr($basename, 0, $basename - $sluglen + 1);
            } else {
                $route2 = $route;
                $basename2 = $basename;
            }
 */
            $routes->add($cleaned, new \Symfony\Component\Routing\Route($route
                    , ['_controller' => 'build', 'php_file' => $entry->getRealPath(), 'file_root' => $route_path.'/'.$basename, 'name' => '.+']));
            $routes->add('slash'.$cleaned, new \Symfony\Component\Routing\Route($route.'/'
                    , ['_controller' => 'build', 'php_file' => $entry->getRealPath(), 'file_root' => $route_path.'/'.$basename, 'name' => '.+']));
        }

        return $routes;
    }

}

?>
