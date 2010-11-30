<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Christoph Herzog <christoph.herzog@theduke.at>
 * @copyright Crevo
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 */

if (!$entry): ?>
<h2>Entry not found</h2>

<?php else: 

$output = '<table>';

foreach ($entry as $key => $value)
{
	switch ($key)
	{
		case 'time':
			$value = date('Y-m-d H:i:s', $value->sec);
			break;
	}
	
	$output .= "<tr><td>$key</td><td>$value</td>";
}

$output .= '</table>';

?>
<h2>Show Log Entry</h2>

<?php 
echo $output;
endif; ?>