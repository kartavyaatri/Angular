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
    <script src="angular.min.js">
    </script>

    <style>
        .CalcButton{
            margin-top: 4px;
            width: 90px;
            height: 80px;
            font-size: 50px;
        }
        .Answer{
            background-color: lightgreen;
        }
        .Logout{
            float: right;
            margin-top: 8px;
            width: 90px;
            height: 80px;
            font-size: 20px;
        }
    </style>
    <?php
      if(!isset($_POST['username']))
      {
          echo "Unauthorized Entry.";
          return;
      }

      $usernm = htmlspecialchars(trim($_POST['username']));

      /*echo "<p style=\"float: right;\">Username: $usernm</p>";*/
      echo "<input type=\"button\" value=\"Logout\"  onclick=\"parent.location='home.html'\" class=\"Logout\">";
      $disptext = "0";

    ?>

        <body ng-app="app" ng-controller="ctrl" ng-init="operator='';resultText=<?php echo $disptext; ?>">

        <input type="text" ng-model="resultText" name="display" style="width: 463px; height: 50px; font-size: 50px; text-align: right" />
        <br>
        <input type="button" name="N1" value="1" class="CalcButton" ng-click="AddToDisplay(1)" />
        <input type="button" name="N2" value="2" class="CalcButton" ng-click="AddToDisplay(2)" />
        <input type="button" name="N3" value="3" class="CalcButton" ng-click="AddToDisplay(3)" />
        <input type="button" name="Bac" value="B" class="CalcButton" ng-click="BackSpace()" />
        <input type="button" name="Cle" value="C" class="CalcButton" ng-click="Clear()" />
        <br>
        <input type="button" name="N4" value="4" class="CalcButton" ng-click="AddToDisplay(4)" />
        <input type="button" name="N5" value="5" class="CalcButton" ng-click="AddToDisplay(5)" />
        <input type="button" name="N6" value="6" class="CalcButton" ng-click="AddToDisplay(6)" />
        <input type="button" name="Add" value="+" class="CalcButton" ng-click="LoadOperator('+')" />
        <input type="button" name="Sub" value="-" class="CalcButton" ng-click="LoadOperator('-')" />
        <br>
        <input type="button" name="N7" value="7" class="CalcButton" ng-click="AddToDisplay(7)" />
        <input type="button" name="N8" value="8" class="CalcButton" ng-click="AddToDisplay(8)" />
        <input type="button" name="N9" value="9" class="CalcButton" ng-click="AddToDisplay(9)" />
        <input type="button" name="Mul" value="*" class="CalcButton" ng-click="LoadOperator('*')" />
        <input type="button" name="Div" value="/" class="CalcButton" ng-click="LoadOperator('/')" />
        <br>
        <input type="button" name="Dot" value="." class="CalcButton" ng-click="AddToDisplay('.')" />
        <input type="button" name="N0" value="0" class="CalcButton" ng-click="AddToDisplay(0)" />
        <input type="button" name="Ans" value="=" class="CalcButton Answer" ng-click="Calc()" ng-disabled="EqualDisabled"/>
        <input type="button" name="Roo" value="&radic;" class="CalcButton" ng-click="ExecuteOperator('R')" />
        <input type="button" name="Mod" value="%" class="CalcButton" ng-click="LoadOperator('%')" />
        <br>
        <input type="button" name="Sin" value="sin" class="CalcButton" ng-click="ExecuteOperator('S')" />
        <input type="button" name="Cos" value="cos" class="CalcButton" ng-click="ExecuteOperator('C')" />
        <input type="button" name="Log" value="log" class="CalcButton" ng-click="ExecuteOperator('L')" />
        <input type="button" name="Fac" value="x!" class="CalcButton" ng-click="ExecuteOperator('F')" />
        <input type="button" name="Pie" value="&pi;" class="CalcButton" ng-click="ExecuteOperator('P')" />
        <p style="font-size: 60px" ng-bind="operator"></p>
        <p style="font-size: 30px" id="status"></p>

    </form>
    </body>
    <script>
    var app = angular.module('app',[]);
    app.controller('ctrl', function($scope){
         $scope.operatorLoaded = false;
         $scope.operator = "";
         $scope.operandTyped = false;
         $scope.op1 = 0;
         $scope.op2 = 0;
         $scope.AddToDisplay = function($val){
              if($val==='.' && $scope.resultText.indexOf(".")>-1)
                  return;

              $scope.resultText = $scope.resultText +""+ $val;
              if($scope.operatorLoaded)
                 $scope.operandTyped = true;
         };
         $scope.BackSpace = function(){
              $scope.resultText = $scope.resultText+"";                         //  IMPORTANT
              $scope.resultText = $scope.resultText.substring(0, $scope.resultText.length-1);
              if($scope.resultText.length===0 && $scope.operatorLoaded)
                  $scope.operandTyped = false;
         };
         $scope.Clear = function(){
              $scope.resultText = $scope.operator = "";
              $scope.op1 = $scope.op2 = 0;
              $scope.operandTyped = $scope.operatorLoaded = false;
         };
         $scope.Calc = function(){
             $scope.op2 = parseFloat($scope.resultText);
             $operation = "";
             switch($scope.operator)
             {
                 case "+": $scope.resultText = $scope.op1 + $scope.op2; $operation = "Add";
                           break;
                 case "-": $scope.resultText = $scope.op1 - $scope.op2; $operation = "Sub";
                           break;
                 case "*": $scope.resultText = $scope.op1 * $scope.op2; $operation = "Mul";
                           break;
                 case "/": $scope.resultText = $scope.op1 / $scope.op2; $operation = "Div";
                           break;
                 case "%": $scope.resultText = $scope.op1 % $scope.op2; $operation = "Mod";
                           break;
             }
             $scope.operatorLoaded = false;
             $scope.operandTyped = false;
             $scope.SaveAttempt($scope.op1, $scope.op2, $operation, $scope.resultText);
         };
         $scope.LoadOperator = function($op){
             if($scope.operatorLoaded===true)
             {
                 if($scope.operandTyped===false)
                 {
                     $scope.operator = $op;
                     return;
                 }
                 $scope.Calc();
             }

             $scope.op1 = parseFloat($scope.resultText);
             $scope.resultText = "";
             $scope.operator = $op;
             $scope.operatorLoaded = true;
         };
         $scope.ExecuteOperator = function($op){
             $subject = parseFloat($scope.resultText);
             $operation = "";
             switch($op)
             {
                 case 'R': $scope.resultText = Math.sqrt($subject).toString(); $operation = "Root";
                           break;
                 case 'S': $scope.resultText = Math.sin($subject).toString(); $operation = "Sin";
                           break;
                 case 'C': $scope.resultText = Math.cos($subject).toString(); $operation = "Cos";
                           break;
                 case 'L': $scope.resultText = Math.log($subject).toString(); $operation = "Log";
                           break;
                 case "F": $scope.resultText=$sub=$subject; if($sub<=0)return; while($sub!==1){ $scope.resultText *= ($sub-1); $sub--;} $operation = "Factorial";
                           break;
                 case "P": $scope.resultText = ($subject * 22/7); $operation = "Pi";
                           break;
             }
             $scope.SaveAttempt($subject, "", $operation, $scope.resultText);
         };
         $scope.SaveAttempt = function($val1, $val2, $val3, $val4)
         {
            $uname="<?php echo $usernm; ?>";
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if(xhttp.readyState === 4 && xhttp.status === 200)
                    document.getElementById("status").innerHTML = xhttp.responseText;
                else
                    document.getElementById("status").innerHTML = "Saving...";
            };
            xhttp.open('POST', "Save.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("username="+$uname+"&op1="+$val1+"&op2="+$val2+"&operator="+$val3+"&result="+$val4);
         };
    });

    </script>


</html>
