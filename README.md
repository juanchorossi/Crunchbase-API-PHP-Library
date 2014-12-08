Crunchbase-API-PHP-Library
==========================

- Please refer to the following link for more information: https://developer.crunchbase.com/docs

**Usage**

	<?php
	require_once('crunchbase.php');

	$crunchbase 	= new CrunchBase($user_key = 'XXX', $format = 'array');
	$organizations 	= $crunchbase->organizations(array('query' 				=> 'wharton school',
														'organization_types'=> array('company', 'investor')));

	foreach ($organizations['data']['items'] as $organization)
	{
		echo "<p><a href=\"".$organizations['metadata']['www_path_prefix'].$organization['path']."\">".$organization['name']."</a></p>";
	}

