<?php

require_once 'config.php';

class Database
{
	private static $instance = null;
	private PDOStatement $stmt;
	private $connection;

	private function __construct() {}

	// создаем объект ДБ только в случае если он еще не инстанциирован 
	public static function getInstance() {
		if(self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	// соединение с БД
	public function getConnection(array $dbConfig): mixed
	{
		if($this->connection instanceof PDO) {
			return $this;
		}

		$dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['db']};charset={$dbConfig['charset']}";

		try {
			$this->connection = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $dbConfig['options']);
			// echo 'connection success';
			return $this;
			
		} catch(PDOException $e) {
			echo $e->getMessage();
			echo 'Ошибка подключения к базе данных';
			return false;
		}
	}

	// метод для выполнения запросов к БД
	public function query($query, $params = []) {
		try {
			$this->stmt = $this->connection->prepare($query);
			$this->stmt->execute($params);
		} catch(PDOException $e) {
			echo $e->getMessage();
			echo 'Ошибка подключения к базе данных';
		}
		return $this;
	}

	// проверка на существование записи в БД
	public function rowExists($field, $table, $value) {
		$this->query("SELECT * FROM $table WHERE $field = ?", [$value]);
		return $this->stmt->fetch();
	}
}