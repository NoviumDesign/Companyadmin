<?php

class Emilk_Queue
{
	private $array = array();

	function __construct($elem = false)
	{
		if($elem) {
			$this->add($elem);
		}
	}

	public function __toString()
	{
		$string = '[' . implode(', ', $this->array) . ']';

		return $string;
	}

	public function add($elem) {

		if(is_array($elem)) {
			// is array
			foreach($elem as $val) {
				$this->array[] = $val;
			}
		} else {
			$this->array[] = $elem;
		}

		return $this;
	}

	public function get($keep = false) {
		// removes first
		$first = array_shift($this->array);

		if($keep) {
			// prepend first again
			array_unshift($this->array, $first);
		}

		return $first;
	}

	public function isEmpty()
	{
		if(count($this->array) > 0) {
			return false;
		} else {
			return true;
		}
	}

}