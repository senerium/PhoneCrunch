<?php
	function cleanLink($website)
	{
		$website = explode('/', $website);
		$website = count($website) > 1 ? explode('.', $website[2]) : explode('.', $website[0]);
		if(count($website) < 3)
		{
			foreach ($website as $term)
			{
				$domain = $domain . '.' . $term;
			}
		}
		else
		{
			foreach ($website as $term)
			{
				if(!($website[0] == $term))
				{
					$domain = $domain . '.' . $term;
				}
			}
		}
		$domain = substr($domain, 1);
		return $domain;
	}
?>