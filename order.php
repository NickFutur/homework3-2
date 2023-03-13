<?php
include "src/config.php";
include "src/bd.connection.php";
include "src/connection_bd.php";
include "src/burger.php";



$burger = new burger();

$email = $_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$comment = $_POST['comment'];

$addressFields = ['street', 'home', 'part', 'appt', 'floor'];

$address = '';
foreach ($_POST as $field => $value){
	if ($value && in_array($field, $addressFields)){
		$address .= $value . ', ';
	}
}

$user = $burger->getUserByEmail($email);
//var_dump($user);

if ($user){
	$userId = $user['ID'];
	$burger->incOrders($user['ID']);
} else {
	$userId = $burger->createUser($email, $name, $phone, $comment);
}

$burger->addOrder($userId, $address);
echo "Спасибо, ваш заказ будет доставлен по адресу: $address <br>
Номер вашего заказа: #ID <br>
Это ваш #Count_Order заказ";


