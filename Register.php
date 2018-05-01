<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
            <title></title>
    </head>
    
    <?php
        $username = $pass = "";
        $Errname = $Errpass = "none";
        $ErrnameMSG = $ErrpassMSG = "";
        
        if(isset($_GET['ID_IN_USE']))
        {
            $ErridMSG = "ID already in use";
            $Errid = "blocked";
            MakeForm(false);
        }
        
        function Register()
        {
            $servername = "localhost";
            $dbname = "test";
            $username = "root";
    
            $name = htmlspecialchars($_POST['name']);
            $pass = htmlspecialchars($_POST['pass']);    
    
            try
            {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO Users VALUES ('$name', '$pass')";
    
                $conn->exec($sql);
                echo "<p>Congrats $name, you are registered.</p>";
                echo "<input type=\"button\" onclick=\"parent.location='home.html'\" value=\"Log In\" style=\"width:100px;height:50px\" />";

            } catch (PDOException $ex) 
            {
                echo "<br>" . $ex->getMessage();
            }
        }
        
        function MakeForm($dataverified)
        {
            global $name, $pass, $Errname, $Errpass, $ErrnameMSG, $ErrpassMSG;
        
            $url = htmlspecialchars($_SERVER['PHP_SELF']);
            if($dataverified)
            {
                Register();
                return;
            }
            
        ?>

            <form id="Form" action="<?php echo $url; ?>" method="POST">

            <input type="text" name="name" placeholder="Username" style="width: 180px; height: 25px; font-size: 20px" value="<?php echo $name; ?>" />
            <span style="color: red; visibility: <?php echo $Errname; ?>" name="Errname"><?php echo $ErrnameMSG; ?></span>
            <br><br>

            <input type="password" name="pass" placeholder="Password" style="width: 180px; height: 25px; font-size: 20px" value="<?php echo $pass; ?>"/>
            <span style="color: red; visibility: <?php echo $Errpass; ?>" name="Errpass"><?php echo $ErrpassMSG; ?></span>
            <br><br>
            
            <input type="submit" name="submit" value="Create Account" style="width: 190px; height: 30px;" />
            <br><br>
            </form>
        <?php 
            if($dataverified)
            {
                echo "</body>";
            }
        }
             
        if(isset($_POST['submit']))
        {
          $name = htmlspecialchars(stripslashes(trim($_POST['name'])));
          $pass = htmlspecialchars(stripslashes(trim($_POST['pass'])));
          $Haserr = false;
          
          if(empty($name))
          { 
             $Haserr = true;
             $Errname = "blocked";
             $ErrnameMSG = "Required.";
          }elseif (preg_match("/^[a-zA-Z ]+$/", $name)==0)
          {
             $Haserr = true;
             $Errname = "blocked";
             $ErrnameMSG = "Only use alphabets and space.";
          }
                    
          if(empty($pass))
          {
             $Haserr = true;
             $Errpass = "blocked";
             $ErrpassMSG = "Required.";
          }elseif (strpos($pass, ' ')==true)
          {
             $Haserr = true;
             $Errpass = "blocked";
             $ErrpassMSG = "No spaces are allowed";
          }
          
          if($Haserr === false)
          {
          try{
             $conn = new PDO("mysql:host=localhost;dbname=test", "root", "");
             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $stmt = "SELECT username FROM users where username='$name'"; 
             $result = $conn->query($stmt);
             if ($result->rowCount() > 0)
              { 
                $Haserr = true;
                $Errname = "blocked";
                $ErrnameMSG = "Username already in use.";
                MakeForm(false);
              }
              else
                MakeForm(true);

                $conn = null;
              }
              catch(PDOException $ex)
              {
                  echo "Failed connecting to database - ".$ex->getMessage();
              }
          }
          else
              MakeForm (false);
        }
        else
            MakeForm(false);
        
        ?>

                                </body>
                                </html>
