<?php
// sessionstart
session_start();

// 外部ファイル読み込み
include('functions.php');

//フォームからきたデータをうけとる
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];
$pdo = connectToDb();

// SQLを実行し、フォームからきたユーザー情報がDB内にあるかどうかを調べる
$sql = 'SELECT * FROM user_table WHERE lid=:lid AND lpw=:lpw AND life_flg=0';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合
if ($status == false) {
    showSqlErrorMsg($stmt);
}

$val = $stmt->fetch();

// ユーザー情報があるかないか分岐
if($val['id'] != ''){
    //必要なsession_idやユーザー情報などをここで送る
    $_SESSION = array();
    //session_idを発行
    $_SESSION['session_id'] = session_id();
    //管理者権限があるかどうか
    $_SESSION['kanri_flg'] = $val['kanri_flg'];
    // ログインユーザーの名前とid
    $_SESSION['user_id'] = $val['id'];
    $_SESSION['user_name'] = $val['name'];
    
    //管理者かどうか
    if($_SESSION['kanri_flg'] == 1){
        header('Location: select.php');
    } else{
        header('Location: select.php');
    }
    
} else {
    $_SESSION['errorMsg'] = '※IDまたはパスワードが間違っています';
    header('Location: login.php');
} 


?>