<?php 

	function dd($message, $is_exit='')
	{
		switch ($is_exit) {
			case 1:
				echo "<pre>";
				var_dump ($message);
				echo "</pre>";
				break;
			
			default:
				echo "<pre>";
				var_dump ($message);
				echo "</pre>";
				die();
				break;
		}
	}