<?php
	session_start();
	if( isset($_POST['fName'])) {
   	    $fName = ($_POST['fName']);
   	}

	if( isset($_POST['lName'])) {
   	    $lName = ($_POST['lName']);
   	}

    if( isset($_POST['uname'])) {
   	    $uname = ($_POST['uname']);
   	}
	
	if( isset($_POST['email'])) {
   	    $email = ($_POST['email']);
   	}

   	if( isset($_POST['psw'])) {
	   	$psw = ($_POST['psw']);
   	}
	$dbhost = 'localhost';
	$dbuser = 'id6943004_group2';
	$dbpass = 'group2';
	$dbname = 'id6943004_advwebproject';
	$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}

    //1.获取上传文件信息
    $upfile=$_FILES["pic"];
    //定义允许的类型
    $typelist=array("image/jpeg","image/jpg","image/png","image/gif");
    $path="./Images/User/";//定义一个上传后的目录
    
    //5.上传后的文件名定义(随机获取一个文件名)
    $fileinfo=pathinfo($upfile["name"]);//解析上传文件名字
    do{ 
        $newfile=date("YmdHis").$uname.".".$fileinfo["extension"];
    }while(file_exists($path.$newfile));
    //6.执行文件上传
    //判断是否是一个上传的文件
    if(is_uploaded_file($upfile["tmp_name"])){
            //执行文件上传(移动上传文件)
            if(move_uploaded_file($upfile["tmp_name"],$path.$newfile)){
				$sql = "INSERT INTO Users (fName, lName, password, email, userName,imageName,imagePath) VALUES (\"$fName\", \"$lName\", \"$psw\", \"$email\", \"$uname\",'$newfile','$path$newfile')";
				$result = mysqli_query($conn, $sql);

				$sql = "SELECT userName, password,userID FROM Users WHERE userName = '" .$uname."'";
				$result2 = mysqli_query($conn, $sql);
	
				while($row = mysqli_fetch_assoc($result2)) {
		
					$_SESSION['user_id']=$row['userID'];
					$_SESSION['username']=$row['userName'];
					if (isset ($_SESSION['url'])){
						$url = $_SESSION['url'];
					} else{
					$url = "storefront.html";
					}
					header('Location: '.$url);
				}
                
            }else{
            echo("Error...<br><br>");
        }
    }
	else{
    echo("Not a file!<br><br>");
	}
	mysqli_close($conn);
?>