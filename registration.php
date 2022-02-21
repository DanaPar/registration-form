<?php

$name = $_POST["name"];
$last_name = $_POST["last_name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$confirmed_password = $_POST["confirmed_password"];
$is_valid = true;

$servername = "localhost";
$username = "root";
$db_password = "123456";
$db_name = "registration_form";


//checks if passwords match
if($password !== $confirmed_password)
{
    echo "Password doesnt match!<br>";
    $is_valid = false;
}

//checks if all fields filled
function fieldsFilled($data)
{
    if(empty($data))
    {
        echo "You left one of the fields empty!<br>";
        $is_valid = false;
    }
}   
fieldsFilled($name);
fieldsFilled($last_name);
fieldsFilled($email);
fieldsFilled($phone);
fieldsFilled($password);
fieldsFilled($confirmed_password);


//checks if phone number numeric and 8digits  long
if(is_numeric($phone))
{
    if(strlen($phone)< 8)
    {
        echo "Phone number too short";
        $is_valid = false;
    }
    elseif(strlen($phone)>8)
    {
        echo "Phone number too long";
        $is_valid = false;
    }
}
else
{
    echo "Only digits allowed as phone number";
    $is_valid = false;
}

//checks if email is valid
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    echo "Enter correct email";
    $is_valid = false;
}

//checks if data length no longer than 64 symbols
function symbol_limit($data)
{
    if (strlen($data) > 64)
    {
        echo "Field exceeds 64 symbol limit<br>"; 
        $is_valid = false;
    }
}

symbol_limit($name);
symbol_limit($last_name);
symbol_limit($email);
symbol_limit($password);
symbol_limit($confirmed_password);

if ($is_valid)
{
    try {
        $conn = new PDO("mysql:host=$servername; dbname=$db_name", $username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO user_registration (firstname, secondname, email, phone, password)
        VALUES ('$name', '$last_name', '$email', '$phone', '$password')";
        $conn->exec($sql);
        echo "New record created ";
      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
       
}
else { echo "Please try again!"; }




?>