<?php
include('functions.php');
session_start();
checkSessionId();
checkAdmin();

//$id = $_GET['id'];
$id = $_SESSION['target_user_id'];


//2. DB接続します(エラー処理追加)
$pdo = connectToDb();

//3．データ登録SQL作成
$sql = 'DELETE FROM user_table WHERE id=:id';
//$sql = 'UPDATE user_table SET life_flg=:a1 WHERE id=:a2';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
// vd($stmt->fetch(),true);
$status = $stmt->execute();

//4．データ登録処理後
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  //select.phpへリダイレクト
  header('Location: use_select.php');
  exit;
}
