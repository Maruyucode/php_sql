<?php

//必ずsession_startは最初に記述
session_start();

//SESSIONを初期化（配列を空にする）
$_SESSION = array();

//Cookieに保存してあるsessionIDの保存期間を過去にして破棄
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

//サーバ側での、セッションIDの破棄
session_destroy(); // セッションの破棄

//処理後，ログイン画面へリダイレクト
header('Location: login.php'); // ログインページヘ移動
exit();

?>