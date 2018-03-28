<?php
@session_start();
require_once('fpdf/fpdf.php'); // Aquí se incluyen las funciones de FPDF
require_once('phpqrcode/qrlib.php');
require_once('recaptchaPhp/recaptchalib.php');
class DB {
	
	private $conexionBD = 0;
	
	public function conectar(){

  

		$this->conexionBD = new PDO("mysql:host=;port=;dbname=","jornastec","");  
		
		
	}
	
	/**
	 * 
	 * Execute a query
	 * @param String $query
	 * @return array asociativo con el resultado de la consulta.
	 *
	 */
	 public function executeQuery($query) {
		
		$this->conectar();
		$row = array();
		$boReturn = false;		
				
			$stmt = $this->conexionBD->prepare($query);
			//echo $query."<br>";				
			//print_r($this->conexionBD->errorInfo() );
			
			if ($stmt->execute()) {				
			
				//echo "<br>execute".$stmt->rowCount();
				if ($row = $stmt->fetchAll()) {
					//echo "<br>  fetchall -";				
					$boReturn = $row;
					
				} else {
					//echo "<br>No FecthAll";
					$boReturn = false;
				}
			} else {
				
					//echo "<br>No execute";
					$boReturn = false;
			}
			return $boReturn;		
		
	}
		
		/**
	*
	* Funcion para la creacion de consultas de seleccion sobre tablas
	* @param $table tabla.
	* @param $columns columnas a seleccionar.
	* @param $where condicion where.
	* @param $order campo de ordenamiento.
	* @return string sentencia SELECT creada.
	*
	*/
	public function crearSelect($table, $columns, $where='', $order='')
	{
		$tmp = "SELECT $columns FROM $table";
		if($where!=''){
			$tmp.=" WHERE $where";
		}
		if($order!=''){
			$tmp.=" ORDER BY $order";
		}
		//echo "<br> BD".$tmp;
		return $tmp;
    	}
		
}	 
	
	

class PDF extends FPDF
{
   private $ci = 0;
  public function setCI($cedula_identidad){	
	$this->ci = $cedula_identidad;

  }

  function Header()
  {        

   $a = new DB();
   $participante = $a->executeQuery($a->crearSelect("t_participante_jornatec_2018_miranda","*","cedula_identidad=$this->ci",""));
   
   if(!$participante){
	$_SESSION["mensaje-error"] = 'La cédula de identidad introducida no se encuentra registrada en nuestra base de datos.';
	header("Location: http://jornastec.org.ve/certificado/");
   }

   /*var_dump($participante);
   die();*/

  //var_dump($participante);
   
   //$nombres = ucwords(strtolower($participante[0]['nombres']));
   //$nombres = utf8_decode("Ññáé = ".ucwords(strtolower($participante[0]['nombres'])));
   $nombres =   strtoupper($participante[0]['nombres']);
   $apellidos = strtoupper($participante[0]['apellidos']);
   $nombreApellido = $nombres." ".$apellidos;
   $sede = $participante[0]['sede'];   
   $lugar = explode("-",$sede);	
   $anio = 2016;

   /*echo "<br>".$nombreApellido;
   echo "<br>".$this->ci;
   echo "<br>".$sede;
   echo "<br>".$lugar[0];
   echo "<br>".$lugar[1];
   die();*/
   $ano = date("Y"); 

    QRcode::png( "Colectivo TeleTriunfador - $nombreApellido - $this->ci - Participante JORNASTEC $ano ", "qrCode/$anio/$this->ci.png", 'L', 2, 2);
    
   //echo $participante[0]['nombres'];  

  $this->Image('images/asistentes_jornastec_2017.jpg', 0, 0, $this->w, $this->h);
  $this->SetFont('Arial','B',32);
  //$this->Ln(20);
  $this->SetXY(100,90);
  $this->Cell(5,5,$nombres,0,0,'C');

  $this->SetXY(100,105);
  $this->Cell(5,5,$apellidos,0,0,'C');

   
  $this->SetFont('Arial','B',12);
  //$this->Ln(100);  
  //$this->SetTextColor(0,51,255 );
  //$this->SetXY(22,235);
  //$this->Cell(5,5,"Lugar:",0,0,'L');
  //$this->SetXY(22,240);
  //$this->Cell(5,5,$lugar[0],0,0,'L');
 // $this->SetXY(22,245);
  //$this->Cell(5,5,trim($lugar[1]),0,0,'L');
  //$this->Ln(10);  
  //$this->Cell(-200,280,$lugar[1],0,1,'L');
  $this->Image("qrCode/$anio/$this->ci.png",187,220);

 }
}   



  $privatekey = "";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

 
if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    //die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
      //   "(reCAPTCHA said: " . $resp->error . ")");
	$_SESSION["error-captcha"] =  $resp->error ;
        $_SESSION["mensaje-error"] = 'Usted introdujo incorrectamente los caracteres, intente nuevamente por favor'; 
	header("Location: http://jornastec.org.ve/certificado/");
	
  } else {
    // Your code here to handle a successful verification
	$pdf=new PDF();
        if (($ci = filter_var($_POST['cedula_identidad'], FILTER_VALIDATE_INT)) == FALSE){
                
		$_SESSION["mensaje-error"] = 'Usted introdujo un formato incorrecto de la cédula de identidad.';
		header("Location: http://jornastec.org.ve/certificado/");
		//var_dump(filter_var($_POST['cedula_identidad'], FILTER_VALIDATE_INT));
		//die();
        }
	//$ci = 16204913;
	$_SESSION["mensaje-error"] = null;
	$pdf->setCI($ci);
	$pdf->AddPage('P', 'letter');  // Tamaño y orientación del archivo PDF
	$pdf->Output("certificado_asistente_jornastec_2017_$ci.pdf","I"); // Nombre del archivo PDF
	//header("Location: http://jornastec.org.ve/index.php");
  }





?>
