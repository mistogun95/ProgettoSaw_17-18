<?php
        ini_set('display_errors','On');
        error_reporting(E_ALL);
        session_start();
        include "db/mysql_credentials.php";
        $username = filter_var(htmlspecialchars(trim($_POST['username'])), FILTER_SANITIZE_STRING);
        $password = filter_var(htmlspecialchars(trim($_POST['password'])), FILTER_SANITIZE_STRING);
        $passwordSha1 = sha1($password);
        
        $conn = new mysqli($mysql_server, $mysql_user, $mysql_pass, $mysql_db);
        if ($conn->connect_error) {
            $message = "Conn ERORR!! <br/>";
        }
        else
        {
            $stmt = $conn->prepare("SELECT Name, Surname FROM Users WHERE Username=? AND Password=?");
            $stmt->bind_param("ss",$username, $passwordSha1);
            if(!$stmt->execute())
            {
                //echo "<script type='text/javascript'>alert('Execute Error');</script>";
                $stmt->close();
                $conn->close();
                header("Location: error.php");
            }
            echo "DOPO EXECUTE<br>";
            $stmt->bind_result($var_query_name,$var_query_surname);
            echo "DOPO BIND<br>";
            $stmt->fetch();
            echo "DOPO FETCH()<br>";
            echo"<br>--$var_query_name--<br>";
            echo"<br>--$var_query_surname--<br>";
            if(isset($var_query_name) && isset($var_query_surname) )
            {
                $_SESSION['name'] = $var_query_name;
                $_SESSION['surname'] = $var_query_surname;
                $_SESSION['username'] = $username;
                header("Location: Homepage.php");
            }
            else 
            {
                header("Location: error.php");
            }
            
            $stmt->close();
            $conn->close();
            
        }

?>
