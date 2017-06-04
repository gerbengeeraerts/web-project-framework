<?php

require_once WWW_ROOT . 'controller' . DS . 'Controller.php';
require_once WWW_ROOT . 'dao' . DS . 'MainDAO.php';

require_once WWW_ROOT . 'assets/phpass/Phpass.php';
require_once WWW_ROOT . 'assets/simpleImage/simple_image.php';

class MainController extends Controller {

	private $mainDAO;

	function __construct() {
		$this->mainDAO = new MainDAO();
	}

	public function index() {

	}

	public function resetaccount() {
		if(!empty($_POST['reset-account'])){

			if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password-confirm'])){

				$password = htmlentities($_POST['password'], ENT_QUOTES, "UTF-8");
				$passwordconfirm = htmlentities($_POST['password-confirm'], ENT_QUOTES, "UTF-8");

				$email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
		    $email = strtolower($email);

				$hasher = new \Phpass\Hash;
		    $hash = $hasher->HashPassword($password);

			}

		}
	}

	public function market(){

		//$marketItems = $this->mainDAO->selectSomeWhere();
		$page = isset($_GET['action']) ? $_GET['action'] : 1;
		$pageSize = 35;
		$marketItems = $this->mainDAO->selectWherePagination('DESC','marketplace', 'buyer', '0',$page, $pageSize);
		$pageMarketItems = array();
		foreach($marketItems as $item){
			$seller = $this->mainDAO->selectItemWhere('players', 'id', $item['player_id']);
			$itemData = $this->mainDAO->selectItemWhere('parts', 'id', $item['part_id']);

			$pageMarketItems[] = array(
				'sale'=>$item,
				'seller'=>$seller,
				'itemData'=>$itemData
			);
		}
		$this->set('marketItems', $pageMarketItems);

	}

	public function logout(){

		$insertPlayerLog = $this->mainDAO->insertItem(array(
			'player_id'=>$_SESSION['user']['id'],
			'player_ip'=>$_SERVER['REMOTE_ADDR'],
			'datetime'=>date('Y-m-d H:i:s'),
			'description'=>'Logged out'
		),'player_logs');

		unset($_SESSION['user']);

		$this->redirect('home');
	}

	public function verify(){

		$updateArray = array(
			'account_status'=>'assign-car',
		);

		$playerCars = $this->mainDAO->getAllFromTableWhere('player_garage', 'player_id', $_SESSION['user']['id']);
		if(count($playerCars)==0){

			$car = $this->mainDAO->selectSingleRandom('cars');
			$insertArray = array(
					'player_id'=>$_SESSION['user']['id'],
					'car_id'=>$car['id'],
					'car_name'=>$car['title']
			);
			$this->mainDAO->insertItem($insertArray,'player_garage');

		}

	}

	public function garage(){

		if(isset($_GET['action']) && !empty($_GET['action'])){
			switch($_GET['action']){
				case 'return-from-cruise':

					$car = $this->mainDAO->selectItemWhereMD5('player_garage', 'car_id', $_GET['id']);

					if(!empty($car)){

						$updateArray = array(
							'onacruise'=>'0',
						);
						$this->mainDAO->updateItem($updateArray, 'player_garage', $car['id']);

						$insertPlayerLog = $this->mainDAO->insertItem(array(
							'player_id'=>$_SESSION['user']['id'],
							'player_ip'=>$_SERVER['REMOTE_ADDR'],
							'datetime'=>date('Y-m-d H:i:s'),
							'table_'=>'player_garage',
							'item_id'=>$car['id'],
							'description'=>'Went home'
						),'player_logs');

						$this->redirect('../../garage');
					}
					$this->redirect('../../garage');

					break;
				case 'go-on-cruise':

					$car = $this->mainDAO->selectItemWhereMD5('player_garage', 'car_id', $_GET['id']);

					if(!empty($car)){

						$updateArray = array(
							'onacruise'=>date('Y-m-d H:i:s'),
						);
						$this->mainDAO->updateItem($updateArray, 'player_garage', $car['id']);

						$insertPlayerLog = $this->mainDAO->insertItem(array(
							'player_id'=>$_SESSION['user']['id'],
							'player_ip'=>$_SERVER['REMOTE_ADDR'],
							'datetime'=>date('Y-m-d H:i:s'),
							'table_'=>'player_garage',
							'item_id'=>$car['id'],
							'description'=>'Went on a cruise'
						),'player_logs');

						$this->redirect('../../garage');

					}
					$this->redirect('../../garage');

					break;
				default:
					$this->redirect('../../garage');
					break;
			}
		}

		$playerData = $this->mainDAO->selectItemWhere('players', 'id', $_SESSION['user']['id']);
		$this->set('playerData', $playerData);

	}

}
