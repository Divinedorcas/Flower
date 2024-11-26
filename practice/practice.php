<?php
// Welcome to my php project

//TYPES OF DATA
/**
 * int
 * double/float
 * string
 * 
 * null
 * double
 * const
 * array
 * booloen
 * 
 */

 //$my_int = 5;
  //echo $my_int;

 // $my_float = 5.5;

 //$my_string = 'Dorcas';

 //$my_ull = null;

 //numeric array
 //$my_array = [1, 'dorcas', 'john'];

 //associative array
 //$my_array_ass = ['age'=>1, 'name'=>'dorcas', 'friend'=>'john'];

 //const fav_celeb= 'uche montana';

 //$my_bool = true && false;


//var_dump() is a function that gives information about the variable

//$array = [ 'name', 'dorcas', 5, 6.7];
//var_dump($array);


//ASSIGNMENT
 $add = 5; 
 echo $add + 4;

 //$minus = 5; 
 //print($add - 2);

 //$to_check = 5; 
 //$to_check2 = 5; 
// print($to_check === $to_check2);

 //$to_less = 5; 
 //$to_less2 = 0; 
 //print($to_less != $to_less2);

//IF STATEMENT
// if a condition is 
if(isset($_GET["age"])){


$name= $_GET["$name"]??null;
$dob = $_GET["$dob"]?? null;
$age = null;

if($age==!null){
    $dob = new DateTime($dob);
    $age = $dob->diff(new DateTime());

}else {
    echo 'invalid date of birth';
}
echo("Your Name is ".htmlspecialchars($name)." and you are ". $age->format("%y")." Years old" );
//echo ( "your name is ".htmlspecialchars($name). "and your date of birth is". $age->format("%Y"));

}

?>
<form method="get">
    <input type="text" placeholder="enter name" name="name">
    <input type="datetime-local"  name="dob">
    <button>calculate</button>
</form>
<!--HOW TO START AND SERVE A PAGE: php -S localhost:8080 (ctrl click to open-->


    <h1>Hello from PHP</h1>

    <?php
    //PHP SYNTAX: 
   
    $MyV = "Prince";
 //DEBUGGING: The process of spotting an issues and finding ways to solve/remove them 
    // Return result: stores the data but does not display and no code runs after excpet inside an if statement
    //Yield result: does the same but does not necessary end the code
