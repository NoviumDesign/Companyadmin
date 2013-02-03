<?php

class Emilk_Obj
{
	function __construct($values = false)
	{
		if(is_array($values)) {
			foreach($values as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	function __toString()
	{
		$variables = get_object_vars($this);

		$string = 'Emilk_Obj(';

		$i = 0;
		foreach($variables as $key => $value) {
			
			if($i++ > 0) {
				$string .= ' ';
			}

			$string .= $key . '->' . $value;
		}

		$string .= ')';

		return $string;
	}
}