<?php

require('functions.php');

class MyObject {
	function __construct() {
		$this->public_attribute = 5;
	}
	public $public_attribute;

}

$array = [
	1,2,3,4,5,
	'oui' => [
		'a' => [1,2,3],
		'b' => 'Un texte un peu plus long pour montrer l\'exemple. Avec des balises html <b> comme ça </b> aussi.',
		'cdsdf' => NULL,
		'false' => false,
		'dsqds' => [12.5, 398.23, 124.26]
	],
	'non' => [
		new MyObject(),
		fopen('index.php', 'r'),
	]
];

echo '
<style>
	table {
		border-collapse: collapse;
	}
	table, td, th {
		border: 1px solid darkgrey;
	}
	td, th {
		box-sizing: border-box;
		width: 25%;
	}
	pre {
		white-space: pre-wrap;
	}
</style>
<table>
	<tr>
		<th>New</th>
		<th>var_export</th>
		<th>var_dump</th>
		<th>print_r</th>
	</tr>
	<tr>
		<td valign="top">';debug($array, ['bonjour', 5, 3], 'test');echo '</td>
		<td valign="top"><pre>';var_dump($array);echo'</pre></td>
		<td valign="top"><pre>';var_export($array);echo'</pre></td>
		<td valign="top"><pre>';print_r($array);echo'</pre></td>
	</tr></table>';




?>