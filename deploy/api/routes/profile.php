<?php

$mainDAO = new MainDAO();

/* CHECK IF USERNAME EXISTS *********************************************************************************/
$app->get('/profile/getCruiseFind/', function() use ($mainDAO){

  //$POST = $app->request->get();
  if(isset($_SESSION['user']) && !empty($_SESSION['user'])){

    function weighted_random($values, $weights){
      $count = count($values);
      $i = 0;
      $n = 0;
      $num = mt_rand(0, array_sum($weights));
      while($i < $count){
          $n += $weights[$i];
          if($n >= $num){
              break;
          }
          $i++;
      }
      return $values[$i];
    }

    $userisOnCruise = $mainDAO->isPlayerOnCruise();
    $lastPartFoundOnCruise = $mainDAO->lastPartFoundOnCruise();
      if(empty($lastPartFoundOnCruise)){
        $lastPartFoundOnCruise['datetime'] = '0000-00-00 00:00:00';
      }
    $to_time = strtotime(date('Y-m-d H:i:s'));
    $from_time = strtotime($lastPartFoundOnCruise['datetime']);
    $minutesBetween = round(abs($to_time - $from_time) / 60,2);
    $allowedMinutesBetween = 15;

    if(rand(1,100)<=5 && !empty($userisOnCruise) && $minutesBetween >= $allowedMinutesBetween){

      /*$values = array('A','B','C');
      $weights = array(1,50,100);
      $weighted_value = weighted_random($values, $weights);*/

      $randomParts = $mainDAO->selectRandom('parts', 5);
      $weights = array();
      $values = array();
      foreach($randomParts as $part){
        $weights[] = $part['rarity'];
        $values[] = $part['id'];
      }

      $prizePart = weighted_random($values, $weights);

      $insertArray = array(
        'player_id'=>$_SESSION['user']['id'],
        'part_id'=>$prizePart
      );
      $mainDAO->insertItem($insertArray, 'player_parts');

      $partInfo = $mainDAO->selectItemById($prizePart, 'parts');

      $insertPlayerLog = $mainDAO->insertItem(array(
        'player_id'=>$_SESSION['user']['id'],
        'player_ip'=>$_SERVER['REMOTE_ADDR'],
        'datetime'=>date('Y-m-d H:i:s'),
        'table_'=>'parts',
        'item_id'=>$prizePart,
        'description'=>'Found a part on a cruise'
      ),'player_logs');

      $response = array(
        'value'=>'1',
        'response'=>'[NO REMARKS]',
        'data'=>array(
          'file'=>'assets/parts/'.$partInfo['file'],
          'part_file'=>'assets/parts/'.$partInfo['file'],
          'part_name'=>$partInfo['title'],
        )
      );

    }else{

      if(empty($userisOnCruise)){
        $response = array(
          'value'=>'0',
          'response'=>'User is not on a cruise'
        );
      }else if($minutesBetween < $allowedMinutesBetween){
        $response = array(
          'value'=>'0',
          'response'=>'Has recently found a part'
        );
      }else{
        $response = array(
          'value'=>'0',
          'response'=>'No luck this time.'
        );
      }



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

/* GET GARAGE *********************************************************************************/
$app->get('/profile/getGarage/', function() use ($mainDAO){

  //$POST = $app->request->get();
  if(isset($_SESSION['user']) && !empty($_SESSION['user'])){

    $garage = $mainDAO->getAllFromTableWhereOrderByDESC('player_garage','player_id',$_SESSION['user']['id'],'id');
    $data = array();
    foreach($garage as $car){

      $selectedCar = $mainDAO->selectItemWhere('cars', 'id', $car['car_id']);

      $data[] = array(
        'car_id'=>$car['car_id'],
        'car_id_md5'=>md5($car['car_id']),
        'car_file'=>'assets/cars/'.$selectedCar['file'],
        'onacruise'=>$car['onacruise'],
        'car_name'=>$car['car_name']
      );
    }

      $response = array(
        'value'=>'1',
        'response'=>'[NO REMARKS]',
        'data'=>$data
      );

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

/* GET INVENTORY *********************************************************************************/
$app->get('/profile/getInventory/', function() use ($mainDAO){

  //$POST = $app->request->get();
  if(isset($_SESSION['user']) && !empty($_SESSION['user'])){

    $parts = $mainDAO->getAllFromTableWhereOrderByDESC('player_parts','player_id',$_SESSION['user']['id'],'id');
    $data = array();
    foreach($parts as $part){

      $selectedPart = $mainDAO->selectItemWhere('parts', 'id', $part['part_id']);

      $data[] = array(
        'part_id'=>$part['part_id'],
        'part_id_md5'=>md5($part['part_id']),
        'part_file'=>'assets/parts/'.$selectedPart['file'],
        'part_name'=>$selectedPart['title'],
        'inventory_id'=>$part['id']
      );
    }

      $response = array(
        'value'=>'1',
        'response'=>'[NO REMARKS]',
        'data'=>$data
      );

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
