<?php

class burger
{

	public function getUserByEmail(string $email)
	{
		$db = \Base\connection_bd::getInstance();
		$query = "SELECT * FROM users WHERE Email = :email";
		return $db->fetchOne($query, __METHOD__,[':email' => $email]);
	}

	public function createUser($email,  $name, $phone, $comment):string
	{
		$db = \Base\connection_bd::getInstance();
		$query = "INSERT INTO users(`Email`, `Name`, `Phone`, `Comment`) VALUES (:email, :name, :phone, :comment)";
		$result = $db->exec($query, __METHOD__,[
			'email' => $email,
			'name' => $name,
			'phone' => $phone,
			'comment' => $comment,
		]);

		if(!$result){
			return false;
		}
		return $db->lastInsertId();
	}

	public function addOrder(int $userId, string $address)
	{

		$db = \Base\connection_bd::getInstance();
		$query = "INSERT INTO orders(user_id, Address, created_at_date) VALUES (:user_id, :address, :created_at_date);";
		$result = $db->exec(
			$query,
			__METHOD__,
			[
				'user_id' => $userId,
				'address' => $address,
				'created_at_date' => date('Y-m-d H:i:s'),

			]);

		if(!$result){
			return false;
		}
		return $db->lastInsertId();
	}

	public function incOrders (int $user_id)
	{
		$db = \Base\connection_bd::getInstance();
		$query = "UPDATE users SET Count_Order = Count_Order + 1 WHERE ID = $user_id";
		return $db->exec($query, __METHOD__);
	}
}
