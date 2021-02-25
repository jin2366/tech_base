<!DOCUTYPE html>
<html lang="ja">
    <head>
        <meta charaset="UTF-8">
        <title>おすすめ映画</title>
    </head>
    <body>
        <h1>おすすめ映画</h1>
        <form action="" method="post">
            <input placeholder="name" type="text" name="name"><br>
            <input placeholder="comment" type="text" name="comment"><br>
            <input placeholder="password" type="password" name="pass">
            
            <input type="submit" name="sumbit" value="submit"><br>
            
            <input placeholder="edit number" type="text" name="editNum"><br>
            
            <input placeholder="delete number" type="text" name="deleteNum">
            <input placeholder="password" type="password" name="delpass">
            <input type="submit" value="delete">
        </form>
    </body>
</html>
<?php
    //データベース接続
    $dsn = 'mysql:dbname=******;host=localhost';
    $user = 'tb-******';
    $password = '******';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //データベースにテーブルを作成
    $sql = "CREATE TABLE IF NOT EXISTS mission4"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY,"
    ."name char(32),"
    ."comment TEXT,"
    ."pass varchar(15),"
    ."dt DATETIME"
    .");";
    $stmt = $pdo->query($sql);
    
    
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $pass = $_POST["pass"];
    $dt1 = date("Y/m/d H:i:s");
    //edit
    
    $edit = $_POST["editNum"];
    if(!empty($name) && !empty($comment) && !empty($edit)){
            
        //変更する投稿番号
    	//$name = $_POST["name"];
        //$comment = $_POST["comment"];
        $dt1 = date("Y/m/d H:i:s");//変更したい名前、変更したいコメントは自分で決めること
    	$sql = 'UPDATE mission4 SET name=:name, comment=:comment, dt=:dt  WHERE id=:id';
    	$stmt = $pdo->prepare($sql);
    	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
    	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    	$stmt->bindParam(':id', $edit, PDO::PARAM_INT);
    	$stmt -> bindParam(':dt', $dt, PDO::PARAM_STR);
    	$name = $name;
        $comment = $comment;
        $dt = $dt1;
    	$stmt->execute();
    }else{
        //insert
        if(!empty($name) && !empty($comment) && !empty($pass)){
            //$name = $_POST["name"];
            //$comment = $_POST["comment"];
            $dt1 = date("Y/m/d H:i:s");
            $sql = $pdo -> prepare("INSERT INTO mission4 (name, comment, dt, pass) VALUES (:name, :comment, :dt, :pass)");
            
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
            $sql -> bindParam(':dt', $dt, PDO::PARAM_STR);
            $name = $name;
            $comment = $comment;
            $dt = $dt1;
            $sql -> execute();
        }
    
    }
    
    /*$dt1 = date("Y/m/d H:i:s");
	$sql = $pdo -> prepare("INSERT INTO mission2 (dt) VALUES (:dt)");
	$sql -> bindParam(':dt', $dt, PDO::PARAM_STR);
	$dt = $dt1;
	$sql -> execute();*/
        
    //delete
 
    $delete = $_POST["deleteNum"];
    $delpass = $_POST["delpass"];
    
    if(!empty($delete) && !empty($delpass)){
    	$sql = 'DELETE FROM mission4 WHERE id=:id AND pass=:pass';
    	$stmt = $pdo->prepare($sql);
    	$stmt->bindParam(':id', $delete, PDO::PARAM_INT);
    	$stmt->bindParam(':pass', $delpass, PDO::PARAM_STR);
    	$stmt->execute();
    }
        
        //show
        $sql = 'SELECT * FROM mission4';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
        	//$rowの中にはテーブルのカラム名が入る
        	echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].',';
            //echo $row['pass'].',';
        	echo $row['dt'].'<br>';
            echo "<hr>";
        }
?>