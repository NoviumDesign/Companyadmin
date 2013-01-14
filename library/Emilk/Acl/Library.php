<?php
	
class Emilk_Acl_library
{
	public static $roles = array();
	public static $resources = array();

	function __construct()
	{

		$this->build();

	}

	public function addRoles($array)
	{
		self::$roles = $array;

		return $this;
	}

	public function addResources($array)
	{
		self::$resources = $array;

		return $this;
	}

	public function access($role, $controller, $view = null)
	{
		$userIndex = array_search($role, $this::$roles);

		if($view) {
			if(isset($this::$resources[$controller])) {
				if(is_array($this::$resources[$controller])) {
					if(isset($this::$resources[$controller][$view])) {
						$minEligibility = array_search($this::$resources[$controller][$view], $this::$roles);			
					} else {

						echo $this::$resources[$controller][$view];

						trigger_error('Resource not found');
						return false;
					}
				} else {
					$minEligibility = array_search($this::$resources[$controller], $this::$roles);
				}
			} else {
				trigger_error('Resource not found');
				return false;
			}
		} else {
			if(isset($this::$resources[$controller])) {
				$minEligibility = array_search($this::$resources[$controller], $this::$roles);
			} else {
				trigger_error('Resource not found');
				return false;
			}
		}

		return ($userIndex >= $minEligibility);
	}
}