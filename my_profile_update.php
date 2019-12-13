<?php
include('functions.php');
session_start();
checkSessionId();
//checkEditUser();

//入力チェック(受信確認処理追加)
if (
  !isset($_POST['name']) || $_POST['name'] == '' ||
  !isset($_POST['lid']) || $_POST['lid'] == '' ||
  !isset($_POST['lpw']) || $_POST['lpw'] == '' ||
  !isset($_POST['life_flg']) || 
  !($_POST['life_flg'] == '0' || $_POST['life_flg'] == '1')
  ) {
    exit('ParamError');
  }

// (!$_POST['kanri_flg'] == '0' && !$_POST['kanri_flg'] == '1') これだと01以外の数字でも通る
  
//POSTデータ取得
$name = $_POST['name'];
$lid  = $_POST['lid'];
$lpw  = $_POST['lpw'];
//$kanri_flg  = (int)$_POST['kanri_flg'];
$life_flg  = (int)$_POST['life_flg'];
$target_user_id = (int)$_SESSION['target_user_id'];

//DB接続します(エラー処理追加)
$pdo = connectToDb();

//データ登録SQL作成
$sql = 'UPDATE user_table SET name=:a1, lid=:a2, lpw=:a3, life_flg=:a4 WHERE id=:a5';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);
$stmt->bindValue(':a2', $lid, PDO::PARAM_STR);
$stmt->bindValue(':a3', $lpw, PDO::PARAM_STR);
$stmt->bindValue(':a4', $life_flg, PDO::PARAM_INT);
$stmt->bindValue(':a5', $target_user_id, PDO::PARAM_INT);
$status = $stmt->execute();
//UPDATE user_table SET name='name2', lid='name2', lpw='qwerty' kanri_flg=1 life_flg=0 WHERE id=2

//4．データ登録処理後
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  header('Location: select.php');
  exit;
}
