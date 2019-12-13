<?php
//共通で使うものを別ファイルにしておきましょう。

//DB接続関数（PDO）
function connectToDb()
{
  $dbn = 'mysql:dbname=gsacfl02_02;charset=utf8;port=3306;host=localhost';
  //mysql:dbname=gsacfl02_02;charset=utf8;port=3080;host=localhost
  $user = 'root';
  $pwd = '';
  try {
    return new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    exit('dbError:' . $e->getMessage());
  }
}

//SQL処理エラー
function showSqlErrorMsg($stmt)
{
  $error = $stmt->errorInfo();
  exit('sqlError:' . $error[2]);
}

function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// idのチェック
function checkSessionId()
{
  if (
    !isset($_SESSION['session_id']) ||
    $_SESSION['session_id'] != session_id()
  ) {
    header('Location: login.php'); // ログイン画面へ移動
  } else {
    session_regenerate_id(true); // セッションidの再生成
    $_SESSION['session_id'] = session_id(); // セッション変数に格納 }
  }
}

//// menuを決める
function menu()
{
  $menu = '<li class="nav-item"><a class="nav-link" href="logout.php">ログアウト</a></li>';
  return $menu;
}

function admin(){
  if($_SESSION['kanri_flg'] == 1){
    return true;
  } else {
    return false;
  }
}

// 管理者が入れるページのurl直うちを防ぐ処理
function checkAdmin(){
  if ($_SESSION['kanri_flg'] == 1) {
    return;
  } else {
    echo '閲覧権限がありません checkAdmin()';
    exit();
  }
}

//ユーザー情報ページで自分以外のユーザーからのアクセスをはじく
function checkEditUser(){
  if($_SESSION['user_id'] == $_GET['id']){
    return;
  } else if($_SESSION['user_id'] == $_SESSION['target_user_id']){
  
  } else if($_SESSION['user_id'] == 1) {
    // 1 は admin
    return;
  } else {
    echo '閲覧権限がありません checkEditUser()';
    exit();
  }
}

// var_dumpを見やすいかたちに表示する
function vd($target , $exit){
  if(gettype($target) == 'array'){
    // 配列が入ってきたら
    foreach ($target as $val) {
      echo var_dump($val);
      echo '<br>';
    }
  } else {
    // 配列でなければ
    var_dump($target);
  }
  if($exit){
    exit();
  }
}