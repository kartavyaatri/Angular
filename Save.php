<?php

   $name = htmlspecialchars(trim($_POST['username']));
   $op1 = htmlspecialchars(trim($_POST['op1']));
   $op2 = htmlspecialchars(trim($_POST['op2']));
   $operator = htmlspecialchars(trim($_POST['operator']));
   $result = htmlspecialchars(trim($_POST['result']));
  
   try
   {
       $conn = new PDO("mysql:host=localhost;dbname=test", "root", "");
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $conn->exec("INSERT INTO Calc VALUES ('$name', '$op1', '$op2', '$operator', '$result')");
       echo "Attempt Saved";
       
   } catch (Exception $ex) {
       echo "<br>" . $ex->getMessage();
   }
?>