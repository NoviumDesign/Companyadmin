<?php

class Emilk_Db_Insert
{	
	private $tableName = null;
	private $columns  = '(';
	private $values = '(';

	function __construct($connection)
	{

	}

	public function tableName($name)
	{
		$this->tableName = $name;

		return $this;
	}

	public function values($array)
	{
		$_columns = array();
		$_values = array();

		foreach ($array as $key => $value) {
			array_push($_columns, $key);
			array_push($_values, $value);
		}

		$this->columns .= implode(', ', $_columns) . ')';
		$this->values .= implode(', ', $_values) . ')';

		echo $this->values .'<br>'. $this->columns;

		return $this;
	}

	public function write()
	{
		$query = mysql_query('INSERT INTO' . $this->tableName . ' ' . $this->columns . ' VALUES ' . $this->values);

		return $query;
	}
}