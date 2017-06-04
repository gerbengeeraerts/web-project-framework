<?php

$mainDAO = new MainDAO();

/* CHECK IF USERNAME EXISTS *********************************************************************************/
$app->get('/players/checkUsername/', function() use ($mainDAO,$app){

  $POST = $app->request->get();
  if(!empty($POST) && !empty($POST['username'])){
    $username = $POST['username'];

    $username = htmlentities($username, ENT_QUOTES, "UTF-8");
    $username = strtolower($username);

    $check = $mainDAO->selectItemWhere('players', 'username', $username);
    if(!empty($check)){
      $response = array(
        'value'=>'0',
        'response'=>'A player already goes by that name.'
      );
    }else{
      $response = array(
        'value'=>'1',
        'response'=>'[NO REMARKS]'
      );
    }

  }else{
    $response = array(
      'value'=>'0',
      'response'=>'Username cannot be empty.'
    );
  }

  header("Content-Type: application/json");
  echo json_encode($response, JSON_NUMERIC_CHECK);
  exit();

});

/* CHECK IF EMAIL EXISTS *********************************************************************************/
$app->get('/players/checkEmail/', function() use ($mainDAO,$app){

  $POST = $app->request->get();
  if(!empty($POST) && !empty($POST['email'])){
    $email = $POST['email'];

    $email = htmlentities($email, ENT_QUOTES, "UTF-8");
    $email = strtolower($email);

    $check = $mainDAO->selectItemWhere('players', 'email', $email);
    if(!empty($check)){
      $response = array(
        'value'=>'0',
        'response'=>'A player already goes by that email.'
      );
    }else{
      $response = array(
        'value'=>'1',
        'response'=>'[NO REMARKS]'
      );
    }

  }else{
    $response = array(
      'value'=>'0',
      'response'=>'Email cannot be empty.'
    );
  }

  header("Content-Type: application/json");
  echo json_encode($response, JSON_NUMERIC_CHECK);
  exit();

});
/* CREATE PLAYER *********************************************************************************/
$app->post('/players/createPlayer/', function() use ($mainDAO,$app){

  $POST = $app->request->post();
  if(!empty($POST) && !empty($POST['username']) && !empty($POST['password']) && !empty($POST['email'])){

    $email = $POST['email'];
    $username = $POST['username'];
    $password = $POST['password'];
    $referralUsername = $POST['referral'];

    $email = htmlentities($email, ENT_QUOTES, "UTF-8");
    $email = strtolower($email);
    $username = htmlentities($username, ENT_QUOTES, "UTF-8");
    $username = strtolower($username);
    $referralUsername = htmlentities($referralUsername, ENT_QUOTES, "UTF-8");
    $referralUsername = strtolower($referralUsername);

    include '../assets/phpass/Phpass.php';

    $hasher = new \Phpass\Hash;
    $hash = $hasher->HashPassword($password);

    $dataArray = array(
      'email'=>$email,
      'username'=>$username,
      'password'=>$hash,
      'account_created'=>date('Y-m-d H:i:s'),
      'account_status'=>'verify'
    );

    $insertPlayer = $mainDAO->insertItem($dataArray,'players');

    if(!empty($insertPlayer)){

      /* referral bonus */
      $setting = $mainDAO->selectItemWhere('settings', 'setting', 'root_url');

      $_SESSION['user'] = $mainDAO->selectItemWhere('players', 'id', $insertPlayer);

      $response = array(
        'value'=>'1',
        'response'=>'[NO REMARKS]',
        'redirect'=>$setting['value'].'verify',
        'id'=>$insertPlayer,
      );
    }else{
      $response = array(
        'value'=>'0',
        'response'=>'Errors occured on MYSQL Backend.'
      );
    }

  }else{
    $response = array(
      'value'=>'0',
      'response'=>'Errors occured on empty fields.'
    );
  }

  header("Content-Type: application/json");
  echo json_encode($response, JSON_NUMERIC_CHECK);
  exit();

});
/* LOGIN PLAYER *********************************************************************************/
$app->post('/players/loginPlayer/', function() use ($mainDAO,$app){

  $POST = $app->request->post();
  if(!empty($POST) && !empty($POST['password']) && !empty($POST['email'])){

    $email = $POST['email'];
    $password = $POST['password'];

    $email = htmlentities($email, ENT_QUOTES, "UTF-8");
    $email = strtolower($email);

    include '../assets/phpass/Phpass.php';

    $user = $mainDAO->selectItemWhere('players', 'email', $email);
    if(!empty($user)){
      $hasher = new \Phpass\Hash;
      if($hasher->checkPassword($password, $user['password'])){

        $updateLastLogin = $mainDAO->updateItem(array('account_last_login'=>date('Y-m-d H:i:s')), 'players', $user['id']);

        $insertPlayerLog = $mainDAO->insertItem(array(
          'player_id'=>$user['id'],
          'player_ip'=>$_SERVER['REMOTE_ADDR'],
          'datetime'=>date('Y-m-d H:i:s'),
          'description'=>'Logged in'
        ),'player_logs');

        $_SESSION['user'] = $user;

        $setting = $mainDAO->selectItemWhere('settings', 'setting', 'root_url');

        $response = array(
          'value'=>'1',
          'response'=>'[NO REMARKS]',
          'redirect'=>$setting['value'].$user['account_status']
        );
      }else{
        //wrong password
        $response = array(
          'value'=>'0',
          'response'=>'wrong password.'
        );
      }
    }else{
      //wrong username
      $response = array(
        'value'=>'0',
        'response'=>'wrong username.'
      );
    }

  }else{
    $response = array(
      'value'=>'0',
      'response'=>'Errors occured on empty fields.'
    );
  }

  header("Content-Type: application/json");
  echo json_encode($response, JSON_NUMERIC_CHECK);
  exit();

});

?>
