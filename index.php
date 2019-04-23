<?php

echo '
<script type="text/javascript" src="script.js"></script>
<link rel="stylesheet" href="style.css" media="all" />';

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
	],
	'empty string' => '',
	'"empty" string' => 'empty',
];
$complex = '{"json": "{\"glossary\": {\"title\": \"example glossary\",\"GlossDiv\": {\"title\": \"S\",\"GlossList\": {\"GlossEntry\": {\"ID\": \"SGML\",\"SortAs\": \"SGML\",\"GlossTerm\": \"Standard Generalized Markup Language\",\"Acronym\": \"SGML\",\"Abbrev\": \"ISO 8879:1986\",\"GlossDef\": {\"para\": \"A meta-markup language, used to create markup languages such as DocBook.\",\"GlossSeeAlso\": [\"GML\", \"XML\"]},\"GlossSee\": \"markup\"}}}}}", "xml": "<note><to><firstname>Tove</firstname><lastname>Tove</lastname></to><from type=\"firstname\">Jani</from><heading>Reminder</heading><body type=\"text\" size=\"short\">Don\'t forget me this weekend!</body><extra>Yes</extra><extra></extra><extra>No</extra></note>"}';


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
<script type="text/javascript" src="script.js"></script>
<link rel="stylesheet" href="style.css" media="all" />
<table>
	<tr>
		<th>New</th>
		<th>var_export</th>
		<th>var_dump</th>
		<th>print_r</th>
	</tr>
	<tr>
		<td valign="top">';debug($array);echo '</td>
		<td valign="top"><pre>';var_dump($array);echo'</pre></td>
		<td valign="top"><pre>';var_export($array);echo'</pre></td>
		<td valign="top"><pre>';print_r($array);echo'</pre></td>
	</tr>
	<tr>
		<td valign="top">';debug($complex);echo '</td>
		<td valign="top"><pre>';var_dump($complex);echo'</pre></td>
		<td valign="top"><pre>';var_export($complex);echo'</pre></td>
		<td valign="top"><pre>';print_r($complex);echo'</pre></td>
	</tr>
	<tr>
		<td valign="top">';debug($complex);echo '</td>
		<td valign="top"><pre>';var_dump($complex);echo'</pre></td>
		<td valign="top"><pre>';var_export($complex);echo'</pre></td>
		<td valign="top"><pre>';print_r($complex);echo'</pre></td>
	</tr>
</table>';