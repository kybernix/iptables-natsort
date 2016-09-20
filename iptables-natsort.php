<?php
//
// sort iptables filter entity
//
// 2016-09-20 xenowire.net/kybernix - first commit
//
// [ NOTE ]
// - ACCEPT rules are treated as top priority.
//

// * config
// - absolute path to iptables file.
$fn = "/etc/sysconfig/iptables";


// * main

// load
$ls = file( $fn, FILE_IGNORE_NEW_LINES );

// init
$collecting = FALSE;

// 
foreach( $ls as &$l )
{
	if( strpos( $l, '#' ) === 0 )
	{
		// comment

		// passthru write
		echo( "{$l}\n" ); 

		continue;
	}

	if( strpos( $l, ':' ) === 0
	||  strpos( $l, '*' ) === 0
	||  strpos( $l, 'COMMIT' ) === 0
	)
	{
		if( $collecting )
		{
			// end collect
			
			// write out
			if( is_array( $collection ) 
			&&  count( $collection ) > 0
			)
			{
				// sort
				natsort( $collection );

				// search and write ACCEPT rules
				$accepts = preg_grep( '/-j\s+ACCEPT/i', $collection );  
				if( count( $accepts ) > 0 )
				{
					// write
					foreach( $collection as &$c )
					{
						echo( "{$c}\n" );	
					}

					// erase from collection
					$collection = array_diff( $collection, $accepts );

					//
					unset( $accepts );	
				}				

				// write 
				foreach( $collection as &$c )
				{
					echo( "{$c}\n" );	
				}
			}
		}

		// write current line
		echo( "{$l}\n" ); 

		// start collect
		// - init collection
		unset( $collection );
		// -
		$collecting = TRUE; 
	}
	else
	{
		if( $collecting )
		{
			// collect
			$collection[] = $l;
		}
		else
		{
			// someting 

			// passthru
			echo( "{$l}\n" ); 
		}
	} 
}

?>
