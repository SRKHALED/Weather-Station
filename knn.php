<?php
	class KNN
	{
    	public static function pbr($x1,$x2,$x3,$y,$tp,$hm,$pre){
			$ud = array();
			for($i=0; $i<sizeof($x1); $i++)
			{
				$d=sqrt((($x1[$i]-$tp)*($x1[$i]-$tp))+(($x2[$i]-$hm)*($x2[$i]-$hm))+
					(($x3[$i]-$pre)*($x3[$i]-$pre)));
				array_push($ud, $d);
			}
			$i=0;
			asort($ud);
			foreach ($ud as $x => $x_value) {
				//echo "key = ".$x.",Value = ".$x_value."<br>";
				$sk[$i]=$x;
				$i++;
			}
			$k=7;
			$rain = 0;
			for($i=0; $i<$k; $i++){
				$t1=$sk[$i];
				if ($y[$t1]!=0){
					$rain++;
				}
			}
			$p_rain = ($rain)/($k);
			return intval($p_rain*100);
		}
    }
 ?>