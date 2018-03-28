<?php

function conectar(){

$conex= pg_connect("hostaddr= port= dbname= user= password=");
pg_query("SET search_path TO '2012'");

if ($conex)
{	
	echo "Conectado<br>";
        return $conex;
	
	

				
}else{
				
	echo "No Conectado<br>";
        return $conex;
}


}

function crearSelect($table, $columns, $where='', $order='')
	{
		$tmp = "SELECT $columns FROM $table";
		if($where!=''){
			$tmp.=" WHERE $where";
		}
		if($order!=''){
			$tmp.=" ORDER BY $order";
		}
		
		return $tmp;
}

function ejecutarSentencia($sentencia)
{
	$conexionBD= conectar();
	$resultadoBD = pg_query($conexionBD, $sentencia);
	return $resultadoBD;
			
		
}


$r = ejecutarSentencia(crearSelect('t_participante','*'));
$datos	=	pg_fetch_array($r,0,PGSQL_ASSOC);
var_dump($datos);



?>
