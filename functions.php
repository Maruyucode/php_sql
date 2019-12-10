<?php
//共通で使うものを別ファイルにしておきましょう。

function userId(){
  return 2;
}


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

// テーブル名
$todo_table = 'php02_table';

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
