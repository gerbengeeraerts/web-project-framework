<?php

$mainDAO = new MainDAO();

//je groep ophalen
$app->get('/dagen/?',function() use ($mainDAO){
    header("Content-Type: application/json");
    echo json_encode($mainDAO->selectDagen($_SESSION['groep']['id']), JSON_NUMERIC_CHECK);
    exit();
});

//toevoegen
$app->post('/dagen/?', function() use ($app, $mainDAO){
    header("Content-Type: application/json");
    $post = $app->request->post();
    if(empty($post)){
        $post = (array) json_decode($app->request()->getBody());
    }
    echo json_encode($mainDAO->insertScore($post,$_SESSION['groep']['id'], $_SESSION['user']['id']), JSON_NUMERIC_CHECK);
    exit();
});

?>