<?php
function build (&$a){
    if (isset($a['auth'])) {
        $response = new \Symfony\Component\HttpFoundation\RedirectResponse('/');
        $response->send();
    }

}
?>
