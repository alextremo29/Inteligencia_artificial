<?php  
	$metodo = $_POST["metodo"];
	switch ($metodo) {
		case 'calcular_w':
			calcular_w($_POST);
			break;
		case 'calcular_x':
			calcular_x($_POST);
			break;
		default:
			echo "nada";
			break;
	}
	function calcular_w($data)
	{
		$matriz = array(
			[-1,-1,-1],
			[-1,1,-1],
			[1,-1,-1],
			[1,1,1]
		);
		/*$w1 = round(10/rand(-1,100),2);
		$w2 = round(10/rand(-1,100),2);
		$e = round(10/rand(0,100),1);
		$theta = round(10/rand(0,100),1);*/

		$w1 = $data["w1"];
		$w2 = $data["w2"];
		$e = $data["e"];
		$theta = $data["theta"];
		

		if ($w1>1) {
			$w1= 1;
		} elseif ($w1 < -1) {
			$w1= -1;
		}
		if ($w2 > 1) {
			$w2 = 1;
		} elseif ($w2 < -1) {
			$w2 = -1;
		}
		if ($e > 1) {
			$e = 1;
		} elseif ($e<-1) {
			$e = -1;
		}
		if ($theta > 1) {
			$theta = 1;
		}elseif ($theta<-1) {
			$theta = -1;
		}
		$count = 0;
		$salir = 0;

		// echo "w1= ".$w1."<br> w2= ".$w2."<br> e= ".$e."<br> theta= ".$theta;

		while (($count != count($matriz)) && $salir <=1000) {
			foreach ($matriz as $value) {
				$iteracion = tanh(($w1*$value[0])+($w2*$value[1])-$theta);
				if ($iteracion >= $theta) {
					$check = 1;
				} else{
					$check = -1;
				}
				if ($check == $value[2]) {
					$count++;
				} else{
					$w1 =round(($w1 + 2 * $e * $value[2] * $value[0]), 2); 
					$w2 =round(($w2 + 2 * $e * $value[2] * $value[1]), 2); 
					$theta = $theta +2 * $e * $value[2] * (-1);
		            $salir++;
		            // echo("<p style='color:red'> El calculo fallo en la iteracion #". $salir . "</p>");
		            // echo("<p> Los nuevos valores de W y theta son: <br> W1=" . $w1 ." <br> W2=" . $w2." <br> theta=".$theta." </p>");
		            $count = 0;
		            break;
				}
				
			}
			
		}
		if ($salir>1000) {
			$respuesta = array(
				'code' => 0
			);
		} else{
			$respuesta = array(
				'code' => 1,
				"w1" => $w1,
				"w2" => $w2,
				"e" => $e,
				"theta" => $theta,
			);
		}
		echo json_encode($respuesta);
	}
	function calcular_x($data)
	{
		$x1 =$data["x1"]; 
		$x2 =$data["x2"]; 
		$x = tanh(($data["w1"]*$x1)+($data["w2"]*$x2)-$data["theta"]);
		if ($x >= $data["theta"]) {
			echo 1;
		} else{
			echo -1;
		}
	}
	
?>