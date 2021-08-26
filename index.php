<?php

$currentValue = 0;

$input = [];

function getInputAsString($values){
    $o = "";
    foreach($values as $value){
      $o .= $value;
    }
    return $o;
}

function calculateInput($userInput){
  //formats user input
    $arr = [];
    $char = '';
    foreach ($userInput as $num){
        if(is_numeric($num) || $num == '.' ){
            $char .= $num;
        }else if(!is_numeric($num)){
            if(!empty($char)){
                $arr[] = $char;
                $char = '';
            }
            $arr[]= $num;
        }

    }
    if(!empty($char)){
        $arr[] = $char;
    }
    //var_dump($arr); exit; --- visual check of formated input
    //Calculate user input

    $current = 0;
    $action = null;
    for($i=0; $i<= count($arr)-1; $i++){
        if(is_numeric($arr[$i])){
            if($action){
                if($action == "+"){
                    $current = $current + $arr[$i];
                }
                if($action == "-"){
                    $current = $current - $arr[$i];
                }
                if($action == "x"){
                    $current = $current * $arr[$i];
                }
                if($action == "÷"){
                    $current = $current / $arr[$i];
                }
                if($action == "%"){
                   $current = $current / 100;
                   $current = $current * $arr[$i];
                }
                if($action == ")"){
                   for($j=0; $j<= $i; $j++){
                     if(arr[$j] == "("){
                       $current = calculateInput($input);
                     }


                   }
                }

                $action = null;
            }else{
                if($current == 0){
                  $current = $arr[$i];
                }
              }
        }else{
            $action = $arr[$i];
        }
      }
    return $current;
  }



if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST["input"])){
      $input = json_decode($_POST["input"]);
    }

    if(isset($_POST)){
      foreach($_POST as $key=>$value){
          if($key == 'equal'){
            $currentValue = calculateInput($input);
            $input = [];
            $input[] = $currentValue;
          }elseif($key == 'AC'){
            $input = [];
            $currentValue = 0;
          }elseif($key != "input"){
            $input[] = $value;
          }
          }
      }

}




?>






<!DOCTYPE html>
<html lang = "en" dir = "ltr">
<head>
	<title>Little Calculator</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <p>Hello Little Calculator</p>
  <div>
      <form method = "post">
      <input type="hidden"  name = "input" value='<?php echo json_encode($input);?>'/>
      <p style="padding: 2rem; margin: 0; height: 1rem;"><?php echo getInputAsString($input);?></p>
      <input type = "text" value="<?php echo $currentValue;?>"/>
      <table>
        <tr>
          <td><input type = "submit" name="closing" value = "(" /></td>
          <td><input type = "submit" name="opening" value = ")" /></td>
          <td><button type = "submit" name="percent" value = "%" /> % </button></td>
          <td><button type = "submit" name="AC" value = "AC" /> AC </button></td>
        </tr>
        <tr>
          <td><input type = "submit" name= "7" value = "7" /></td>
          <td><input type = "submit" name="8" value = "8" /></td>
          <td><input type = "submit" name="9" value = "9" /></td>
          <td><button type = "submit" name="divide" value = "÷" /> &#247; </button></td>
        </tr>
        <tr>
          <td><input type = "submit" name="4" value = "4" /></td>
          <td><input type = "submit" name="5" value = "5" /></td>
          <td><input type = "submit" name="6" value = "6" /></td>
          <td><button type = "submit" name="multiply" value = "x" /> x </button></td>
        </tr>
        <tr>
          <td><input type = "submit" name="1" value ="1" /></td>
          <td><input type = "submit" name="2" value ="2" /></td>
          <td><input type = "submit" name="3" value ="3" /></td>
          <td><button type = "submit" name="minus" value = "-" /> - </button></td>
        </tr>
        <tr>
          <td><input type = "submit" name="zero" value = "0" /></td>
          <td><input type = "submit" name="dot" value = "." /></td>
          <td><button type = "submit" name="equal" value = "=" /> = </button></td>
          <td><button type = "submit" name="add" value = "+" /> + </button></td>
        </tr>

      </table>
  </form>
</div>



</body>
</html>
