<?php

require_once WWW_ROOT. DS . 'dao'. DS . 'DAO.php';

class MainDAO extends DAO {

  public function map_range($value, $low1, $high1, $low2, $high2) {
    return $low2 + ($high2 - $low2) * ($value - $low1) / ($high1 - $low1);
  }

  public function countAllInTableWhere($table, $db, $id) {
    $sql = "SELECT COUNT(*) as count FROM `".$table."` WHERE `".$db."` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function countAllInTable($table) {
    $sql = "SELECT COUNT(*) as count FROM `".$table."`";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getAllFromTable($table) {
    $sql = "SELECT * FROM `".$table."` ORDER BY `id` ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function insertData($table,$file, $type, $id, $info) {

      $sql = "INSERT INTO `".$table."` (`project_id`, `file`, `type`, `data_info`) VALUES (:id, :file, :type, :info)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      $stmt->bindValue(':file', $file);
      $stmt->bindValue(':type', $type);
      $stmt->bindValue(':info', $info);
      if($stmt->execute()) {
        return true;
      }
      return false;
  }

  public function getAllFromTableWhere($table, $db, $id) {
    $sql = "SELECT * FROM `".$table."` WHERE `".$db."` = :id ORDER BY `id` ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectWherePagination($orderBy, $table, $field, $value, $page, $pageSize) {
    $sql = "SELECT * FROM `".$table."` WHERE `".$field."` = :value ORDER BY `id` ".$orderBy." LIMIT ".($page-1)*$pageSize.", ".$pageSize;
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':value', $value);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAllFromTableWhereOrderBy($table, $db, $id, $order) {
    $sql = "SELECT * FROM `".$table."` WHERE `".$db."` = :id ORDER BY `".$order."` ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAllFromTableWhereOrderByDESC($table, $db, $id, $order) {
    $sql = "SELECT * FROM `".$table."` WHERE `".$db."` = :id ORDER BY `".$order."` DESC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getRandomWhereLimit($table, $db, $id, $limit) {
    $sql = "SELECT * FROM `".$table."` WHERE `".$db."` != :id ORDER BY rand() ASC LIMIT ".$limit."";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getMogelijkse($table, $cat, $item,$limit) {
    $sql = "SELECT * FROM `".$table."` WHERE `id` != :id AND `categorie_id` = :cat_id ORDER BY `id` ASC LIMIT ".$limit."";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $item);
    $stmt->bindValue(':cat_id', $cat);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectItemWhereMD5($table, $db, $id) {
    $sql = "SELECT * FROM `".$table."` WHERE MD5(".$db.") = :id AND `player_id` = :player_id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':player_id', $_SESSION['user']['id']);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function isPlayerOnCruise() {
    $sql = "SELECT * FROM `player_garage` WHERE `player_id` = :id AND `onacruise` != 0";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $_SESSION['user']['id']);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function lastPartFoundOnCruise() {
    $sql = "SELECT * FROM `player_logs` WHERE `player_id` = :id AND `description` = 'Found a part on a cruise' ORDER BY `id` DESC LIMIT 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $_SESSION['user']['id']);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectItemWhere($table, $db, $id) {
    $sql = "SELECT * FROM `".$table."` WHERE `".$db."` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectRandom($table, $db) {
    $sql = "SELECT * FROM `".$table."` ORDER BY rand() LIMIT :limit";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':limit', $db);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectSingleRandom($table) {
    $sql = "SELECT * FROM `".$table."` ORDER BY rand()";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function deleteItemWhere($table, $db, $id) {
    $sql = "DELETE FROM `".$table."` WHERE `".$db."` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
  }

  public function selectItemById($id, $table) {
    $sql = "SELECT * FROM `".$table."` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectItemByVar($id, $table, $db) {
    $sql = "SELECT * FROM `".$table."` WHERE `".$db."` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectUserById($id) {
    $sql = "SELECT * FROM `gebruikers` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectUserByName($name) {
    $sql = "SELECT * FROM `gebruikers` WHERE `gebruiker` = :naam";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':naam', $name);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function deleteItem($id, $table) {
      $sql = "DELETE FROM `".$table."` WHERE `id` = :id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
    }

    public function addCredits($credits){
      $sql = "UPDATE `players` SET `credits` = `credits`+".$credits." WHERE `id` = :id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $_SESSION['user']['id']);
      $stmt->execute();
    }

  public function updateItem($data,$table,$id) {
      //$sql = "UPDATE `stijlen` SET `stijl` = :stijl, `slug` = :slug WHERE `id` = :id";

      $sql = "UPDATE `".$table."` SET ";

      $teller=0;
      foreach($data as $key=>$value){
        if($teller<count($data)-1){
          $sql .= '`'.$key.'` = :'.$key.',';
        }else{
          $sql .= '`'.$key.'` = :'.$key;
        }
        $teller++;
      }

      $sql .= " WHERE `id` = :id";

      $stmt = $this->pdo->prepare($sql);

      foreach($data as $key=>$value){
        $stmt->bindValue(':'.$key, $value);
      }

      $stmt->bindValue(':id', $id);

      $stmt->execute();

    }

  public function insertItem($data,$table) {
    $sql = "INSERT INTO `".$table."`";
    $sql .= ' (';

    $teller=0;
    foreach($data as $key=>$value){
      if($teller<count($data)-1){
        $sql .= '`'.$key.'`,';
      }else{
        $sql .= '`'.$key.'`';
      }
      $teller++;
    }
    $sql .= ') VALUES (';
    $teller=0;
    foreach($data as $key=>$value){
      if($teller<count($data)-1){
        $sql .= ':'.$key.',';
      }else{
        $sql .= ':'.$key;
      }
      $teller++;
    }
    $sql .= ')';

    $stmt = $this->pdo->prepare($sql);

    foreach($data as $key=>$value){
      $stmt->bindValue(':'.$key, $value);
    }

    if($stmt->execute()) {
      $insertedId = $this->pdo->lastInsertId();
      return $insertedId;
    }

    return false;
    //return $sql;
  }

}

?>
