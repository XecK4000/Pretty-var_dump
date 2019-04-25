<?php

function debug() {
	//Get context of call
	$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
	foreach($backtrace as $trace) {
		if($trace['file'] != __FILE__) {
			break;
		}
	}
	$context = ucfirst($trace['function']).' '.str_replace(__DIR__, '', $trace['file']).':'.$trace['line'];
	
	
	$args = func_get_args();
	if(count($args) == 0) {
		data_dump(NULL, $context);
	} else if(count($args) == 1) {
		data_dump($args[0], $context);
	} else {
		$a = [];
		foreach($args as $k => $v) {
			$a['Variable '.$k] = $v;
		}
		data_dump($a, $context);
	}
}

function debug_and_die() {
	$args = func_get_args();
	call_user_func_array('debug', func_get_args());
	die();
}


/**
 * Print the content of a variable
 * @param  mixed   $data    The data you want to print
 * @param  string  $title   The title you want to print before your data
 * @param  array   $options An array of available options :
 *                          * ignore_complex_types : ignore the advanced treatment for complex types as json or xml
 *                          * hide : default hide this level
 * @param  integer $depth   The current recursion depth, should be left empty
 */
function data_dump($data, $title, $options = [], $depth = 0) {
	$type = gettype($data);
	$attributes = [];

	//Complex types detection
	if(!$options['ignore_complex_types']) {
		if($type == 'string') {
			if($t = @simplexml_load_string($data)) {
				$data_origin = $data;
				$data = [$t->getName() => $t]; //We want the root name of the XML, so we put it in an array
				$type = 'xml';
				$options['parent'] = 'xml';
				$root = true;
			} else if($t = json_decode($data, true)) {
				$data_origin = $data;
				$data = $t;
				$type = 'json';
				$options['parent'] = 'json';
				$root = true;
			}
		}
		if($type == 'object' && get_class($data) == 'SimpleXMLElement') {
			if(count($data) == 0) {
				foreach($data->attributes() as $k => $v) {
					$attributes[$k] = $v;
				}
				$data = (string)$data;
				$type = 'string';
			} else {
				$type = 'xml';
			}
		} else if($type == 'array' && $options['parent'] == 'json') {
			$type = 'json';
		}
	}



	$extra_classes = [];
	if(isset($options['hide']) && $options['hide'] == $depth && in_array($type, ['array', 'object', 'json', 'xml'])) {
		$extra_classes[] = 'data_dump_hidden';
	}
	echo '<div class="data_dump_parent '.(count($extra_classes) ? implode(' ', $extra_classes).' ' : '').'data_dump_type_'.$type.' data_dump_depth_'.$depth.'">';



	//Title
	if(count($attributes)) {
		echo '<div class="data_dump_title">
			<span style="display: flex;flex-direction: column">
				<span>'.htmlentities($title).'</span>';
		foreach($attributes as $k => $v) {
			echo '<span style="margin-left: 20px;font-weight: normal;color: grey;">↪ '.htmlentities($k).' → '.htmlentities($v).'</span>';
		}
		echo '
			</span>
			<span>➔</span>';
	} else {
		echo '<div class="data_dump_title"><span>'.htmlentities($title).'</span><span>➔</span>';
	}

	switch($type) {
		case 'array':
			echo '<span>Array('.count($data).') {</span>';
			break;
		case 'object':
			echo '<span>'.get_class($data).' Object'.'('.count($data).') {</span>';
			break;
		case 'json':
			if($root) {
				echo '<span class="data_dump_complex_type" title="Click to copy the origin JSON">JSON('.count($data).')</span><span>&nbsp;{</span>';
			} else {
				echo '<span>json('.count($data).') {</span>';
			}
			break;
		case 'xml':
			if($root) {
				echo '<span class="data_dump_complex_type" title="Click to copy the origin XML">XML('.count($data).')</span><span>&nbsp;{</span>';
			} else {
				echo '<span>xml('.count($data).') {</span>';
			}
			break;
	}
	echo '</div>';




	//Content
	echo '<div class="data_dump_content">';
	switch($type) {
		case 'array':
		case 'object':
		case 'json':
		case 'xml':
			foreach($data as $k => $e) {
				data_dump($e, $k, $options, $depth+1);
			}
			break;
		default:
			$title = $type;
			if($type == 'NULL') {
				$e = 'null';
			} else if($type == 'boolean' && $data) {
				$e = 'true';
			} else if($type == 'boolean' && !$data) {
				$e = 'false';
			} else if($type == 'string') {
				$title .= '('.strlen($data).')';
				$e = htmlentities($data);
				if($e === '') {
					$e = '<i>empty</i>';
				}
			} else {
				$e = $data;
			}
			echo '<span title="'.$title.' - Click to copy">'.$e.'</span>';
			break;
	}
	echo '</div>';


	if(in_array($type, ['array', 'object', 'json', 'xml'])) {
		echo '<div class="data_dump_end">}</div>';
	}

	if($data_origin) {
		echo '<div class="data_dump_complex_origin">'.htmlentities($data_origin).'</div>';
	}

	echo '</div>';

	if($depth == 0) {
		echo '<script>data_dump_init();</script>';
	}
}