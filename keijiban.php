<!DOCTYPE html>
<html lang = "ja">
<head>
    <meta charset = "UTF-8">
    <title>掲示板</title>
</head>
<body>
    
    <?php
        //投稿
        $name_form = $_POST["name"];
        $comment_form = $_POST["comment"];
        $passward_form = $_POST["passward"];
        
        $time = date("Y/m/d H:m:s");
        
        //削除
        $deletenumber = $_POST["deletenumber"];
        $delete_pass = $_POST["delete_pass"];
        
        //編集
        $editnumber = $_POST["editnumber"];
        $name_edit = $_POST["name_edit"];
        $comment_edit = $_POST["comment_edit"];
        $edit_pass = $_POST["edit_pass"];
    ?>
        
        <form action = "" method = "post">
        【投稿】<br>
        　　　名前:<input type = "text" name = "name" ><br>
        　コメント:<input type = "text" name = "comment"><br>
        パスワード:<input type = "text" name = "passward" ><br>
        <input type = "submit" name = "send"><br>
        <hr>
        
        【削除】<br>
        　削除番号:<input type = "number" name = "deletenumber" ><br>
        パスワード:<input type = "text" name = "delete_pass" ><br>
        <input type = "submit" name = "delete" value = "削除"><br>
        <hr>
        
        【編集】<br>
        　編集番号:<input type = "number" name = "editnumber" ><br>
        　　　名前:<input type = "text" name = "name_edit" ><br>
        　コメント:<input type = "text" name = "comment_edit"><br>
        パスワード:<input type = "text" name = "edit_pass" ><br>
        <input type = "submit" name = "edit" value = "編集">
        <br>
        <hr>
        投稿
        <hr>
        
    </form>
</body>
</html>






<?php
//データベースに接続
    $dsn = データベース名;
	$user = ユーザー名;
	$password = パスワード;
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	

//データベース内にテーブルを作成
	$sql="CREATE TABLE IF NOT EXISTS tbtest"
	."("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT"
	.");";
	$stmt = $pdo->query($sql);
	
	// INSERT でデータを挿入
	if(empty($name_form) && empty($comment_form)){
	    
	}elseif($passward_form == "pass"){
	$sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$name = $name_form;
	$comment = $comment_form;
	$sql -> execute();
	}
	
	// SELECT でデータを表示
	$sql = 'SELECT * FROM tbtest';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].'　/　';
		echo $row['name'].'　/　';
		echo $row['comment']."　/　";
		echo $time.'<br>';
	echo "<hr>";
	}
	
	//編集
	if( $edit_pass == "pass"){
	$id =  $editnumber; //変更する投稿番号
	$name = $name_edit;
	$comment = $comment_edit; //変更したい名前、変更したいコメントは自分で決めること
	$sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	}
	
	// 削除
	if($delete_pass == "pass"){
	$id = $deletenumber ;
	$sql = 'delete from tbtest where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	}
?>