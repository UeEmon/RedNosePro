<?php
class AppController extends Connect
{
  /* 座標を登録 */
  public function update_sortable($sql, $left, $top, $id){
    $stmt = $this->pdo()->prepare($sql);
    $stmt->bindParam(':LEFT',   $left, PDO::PARAM_INT);
    $stmt->bindParam(':TOP',    $top,  PDO::PARAM_INT);
    $stmt->bindParam(':NUMBER', $id,   PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
  }

  /* 新規登録 */
  public function insert_sortable($sql, $name, $gender){
    $stmt = $this->pdo()->prepare($sql);
    $stmt->bindParam(':ONAMAE', $name,   PDO::PARAM_STR);
    $stmt->bindParam(':GENDER', $gender, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
  }
}