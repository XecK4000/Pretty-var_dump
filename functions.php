<?php

function debug() {
	call_user_func_array('debug_dump', func_get_args());
}

function debug_and_die() {
	call_user_func_array('debug_dump', func_get_args());
	die();
}

function debug_dump() {
	$backtrace = debug_backtrace();
	echo '
	<div
		onmouseover="this.style.backgroundColor = \'#EEE\';event.stopPropagation();"
		onmouseout="this.style.backgroundColor = \'initial\';"
		onclick="
			var d = this.firstElementChild;
			if(d.firstElementChild.innerHTML == \'▼\') {
				d.firstElementChild.innerHTML = \'►\';
				while(d = d.nextElementSibling)
					d.style.display = \'none\';
			} else {
				d.firstElementChild.innerHTML = \'▼\';
				while(d = d.nextElementSibling)
					d.style.display = \'block\';
			}
			event.stopPropagation();"
		style="border: 1px solid black;cursor: pointer;transition: background-color 100ms; linear;">
			<div style="font-weight: bold;font-size: larger;"><span style="padding-right: 5px;">▼</span><span style="text-decoration: underline;">'.ucfirst($backtrace[1]['function']).' - '.substr($backtrace[1]['file'], strrpos($backtrace[1]['file'], '/')).':'.$backtrace[1]['line'].' - 236ms</span></div>';
	$elements = func_get_args();
	if(count($elements) > 1) {
		$i = 0;
		foreach($elements as $element) {
			$i++;
			debug_recursive('Paramètre '.$i, $element);
		}
	} else if(count($elements) == 1){
		$t = NULL;
		debug_recursive($t, $elements[0]);
	} else {
		echo '<div></div>';
	}
}

function debug_recursive(&$key, &$element) {
	$color = [
		'boolean' => 'lightskyblue',
		'integer' => 'violet',
		'double' => 'plum',
		'string' => 'pink',
		'array' => 'cornflowerblue',
		'object' => 'lightgreen',
		'resource' => 'greenyellow',
		'NULL' => 'orange',
		'unknown type' => 'maroon',
	];
	$type = gettype($element);
	switch($type) {
		case 'array':
		case 'object':
			if($key !== NULL) {
				echo '
				<div
					onmouseover="this.style.backgroundColor = \'#EEE\';event.stopPropagation();"
					onmouseout="this.style.backgroundColor = \'initial\';"
					onclick="
						if(this.firstElementChild.firstElementChild.innerHTML == \'▼\') {
							this.firstElementChild.firstElementChild.innerHTML = \'►\';
							this.firstElementChild.nextElementSibling.style.display = \'none\';
						} else {
							this.firstElementChild.firstElementChild.innerHTML = \'▼\';
							this.firstElementChild.nextElementSibling.style.display = \'block\';
						}
						event.stopPropagation();"
					style="cursor: pointer;transition: background-color 100ms; linear;">
						<div><span style="padding-right: 5px;">▼</span><span style="font-weight: bold;">'.$key.'</span><span style="color: grey;padding: 0px 10px;">➔</span>'.($type=='array'?'Array':get_class($element).' Object').'('.count($element).') {</div>';
			}
			echo '
						<div style="margin-left: 40px;">';
			foreach($element as $k => $e) {
				debug_recursive($k, $e);
			}
			echo '
						</div>}
				</div>';
			break;
		default:
			if($type == 'NULL') {
				$e = 'null';
			} else if($type == 'boolean' && $element) {
				$e = 'true';
			} else if($type == 'boolean' && !$element) {
				$e = 'false';
			} else if($type == 'string') {
				$e = htmlentities($element);
			} else {
				$e = $element;
			}
			$title = ucfirst($type);
			if($type == 'string') {
				$title .= '('.strlen($element).')';
			}
			echo '<div title="'.$title.'">'.($key !== NULL?'<span style="font-weight: bold;">'.$key.'</span><span style="color: grey;padding: 0px 10px;">➔</span>':'').'<span style="padding: 1px 4px;background-color: '.$color[$type].';">'.$e.'</span></div>';
			break;
	}
}

?>