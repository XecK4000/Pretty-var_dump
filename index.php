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
		'b' => 'dsqjmdskl',
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
		width: 100%;
	}
	table, td, th {
		border: 1px solid black;
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
		<td valign="top">';
debug($array);
echo'</td><td valign="top"><pre>';var_dump($array);echo'</pre></td>';
echo'</td><td valign="top"><pre>';var_export($array);echo'</pre></td>';
echo'<td valign="top"><pre>';print_r($array);echo'</pre></td>';
echo '</tr></table>';




?>