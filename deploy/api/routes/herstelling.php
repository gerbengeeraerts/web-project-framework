<?php

$HerstellingDAO = new HerstellingDAO();

$app->post('/herstelling/?', function() use ($app,$HerstellingDAO){
    header("Content-Type: application/json");
    //echo json_encode($KlantDAO->selectAllKlanten(), JSON_NUMERIC_CHECK);
    $post = $app->request->post();
    $result = $HerstellingDAO->updateAction($post['type'],$post['value'],$post['id']);

    echo json_encode($result, JSON_NUMERIC_CHECK);
    exit();
});

$app->post('/herstelling/interneOpmerking/?', function() use ($app,$HerstellingDAO){
    header("Content-Type: application/json");
    //echo json_encode($KlantDAO->selectAllKlanten(), JSON_NUMERIC_CHECK);
    $post = $app->request->post();
    $result = $HerstellingDAO->updateInterneOpmerking($post['opmerking'],$post['id']);
    echo json_encode($result, JSON_NUMERIC_CHECK);
    exit();
});

?>
