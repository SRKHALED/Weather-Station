<?php
	class LR
	{
    	public static function pt($x,$y,$m,$c){
			$ep = 2000;
			$L = 0.000001;
			for($i=0; $i<$ep; $i++){
				$s1 = 0;
				$s2 = 0;
				for($j=0; $j<sizeof($x); $j++){
					$s1+=($x[$j])*($y[$j]-$m*$x[$j]-$c);
					$s2+=($y[$j]-$m*$x[$j]-$c);
				}
				$dm = -(2/sizeof($x))*$s1;
				$dc = -(2/sizeof($x))*$s2;	
				$m-=$L*$dm;
        		$c-=$L*$dc;
			}
			/*for($i=0; $i<sizeof($x); $i++){
				$t=intval($x[$i]*$m+$c);
			 	$pt[$i] = $t;
			}*/
			$pt[0] = $m;
			$pt[1] = $c+8.5;
			return $pt;
		}
    }
?>