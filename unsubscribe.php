<?php
include('functions.php');
session_start();
checkSessionId();
checkEditUser();

//1. GETデータ取得
//$id = $_GET['id'];
$id = $_SESSION['target_user_id'];
$life_flg = 1 ;    // 退会
//vd($id, true);

//2. DB接続します(エラー処理追加)
$pdo = connectToDb();

//3．データ登録SQL作成
//$sql = 'DELETE FROM user_table WHERE id=:id';
$sql = 'UPDATE user_table SET life_flg=:a1 WHERE id=:a2';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $life_flg, PDO::PARAM_INT);
$stmt->bindValue(':a2', $id, PDO::PARAM_INT);
// vd($stmt->fetch(),true);
$status = $stmt->execute();

//4．データ登録処理後
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  //adminだったら 
  if($_SESSION['user_id'] == '1'){
    header('Location: user_select.php');
    exit();
  }
  header('Location: login.php');
  exit;
}
