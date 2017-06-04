<?php

$mainDAO = new MainDAO();


/* SALVAGE PART *********************************************************************************/
$app->post('/parts/salvage-part/', function() use ($mainDAO,$app){

  if(isset($_SESSION['user']) && !empty($_SESSION['user'])){

    $POST = $app->request->post();
    $id = $POST['id'];
    if(is_numeric($id)){

      $part = $mainDAO->selectItemWhere('parts', 'id', $id);

    /* market value */
      $marketTotalCount = $mainDAO->countAllInTable('marketplace');
      $marketItemCount = $mainDAO->countAllInTableWhere('marketplace', 'part_id', $id);
      if($marketTotalCount['count']!='0' && $marketItemCount['count']!='0'){
        //$percentageInMarketplace = ($marketTotalCount['count'] / 100)*$marketItemCount['count'];
        $percentageInMarketplace = $mainDAO->map_range($marketItemCount['count'],0,$marketTotalCount['count'],0,100);
        $marketExtraValue = $part['value']/$percentageInMarketplace;
      }else{
        $marketExtraValue = '0';
        $percentageInMarketplace='0';
      }

    /* inventory value */
      $inventoryTotalCount = $mainDAO->countAllInTable('player_parts');
      $inventoryItemCount = $mainDAO->countAllInTableWhere('player_parts', 'part_id', $id);
      if($inventoryTotalCount['count']!='0' && $inventoryItemCount['count']!='0'){
        //$percentageInInventory = ($inventoryTotalCount['count'] / 100)*$inventoryItemCount['count'];
        $percentageInInventory = $mainDAO->map_range($inventoryItemCount['count'],0,$inventoryTotalCount['count'],0,100);
        $inventoryExtraValue = $part['value']/$percentageInInventory;
      }else{
        $inventoryExtraValue = '0';
        $percentageInInventory='0';
      }

    /* calculate value */
      $possibleSellValue = (($part['value']/100)*50) + ($marketExtraValue) + ($inventoryExtraValue);
    /* salvage value */
      $possibleSellValue = ($possibleSellValue/100)*25;

    /* log toevoegen */
    $insertPlayerLog = $mainDAO->insertItem(array(
      'player_id'=>$_SESSION['user']['id'],
      'player_ip'=>$_SERVER['REMOTE_ADDR'],
      'datetime'=>date('Y-m-d H:i:s'),
      'table_'=>'player_parts',
      'item_id'=>$part['id'],
      'description'=>'Salvaged an item.'
    ),'player_logs');
    /* part uit inventory halen */
    $deleteItem = $mainDAO->deleteItemWhere('player_parts','id',$POST['inventoryId']);

    /* geld toevoegen */
    $mainDAO->addCredits($possibleSellValue);

    $playerData = $mainDAO->selectItemWhere('players', 'id', $_SESSION['user']['id']);

      $response = array(
        'value'=>'1',
        'response'=>'Part succesfully salvaged.',
        'data'=>array(
          'credits'=>$playerData['credits']
        )
      );

    }else{
      $response = array();
    }

  }else{
    $response = array(
      'value'=>'0',
      'response'=>'User is not logged in.'
    );
  }

  header("Content-Type: application/json");
  echo json_encode($response, JSON_NUMERIC_CHECK);
  exit();

});


?>
