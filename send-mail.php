 <?php 

function form_mail($sPara, $sAsunto, $sTexto, $sDe)
{ 
$bHayFicheros = 0; 
$sCabeceraTexto = ""; 
$sAdjuntos = "";

if ($sDe)$sCabeceras = "From:".$sDe."\n"; 
else $sCabeceras = ""; 
$sCabeceras .= "MIME-version: 1.0\n"; 
foreach ($_POST as $sNombre => $sValor) 
$sTexto = $sTexto."\n".$sNombre." = ".$sValor;

foreach ($_FILES as $vAdjunto)
{ 
if ($bHayFicheros == 0)
{ 
$bHayFicheros = 1; 
$sCabeceras .= "Content-type: multipart/mixed;"; 
$sCabeceras .= "boundary=\"--_Separador-de-mensajes_--\"\n";

$sCabeceraTexto = "----_Separador-de-mensajes_--\n"; 
$sCabeceraTexto .= "Content-type: text/plain;charset=iso-8859-1\n"; 
$sCabeceraTexto .= "Content-transfer-encoding: 7BIT\n";

$sTexto = $sCabeceraTexto.$sTexto; 
} 
if ($vAdjunto["size"] > 0)
{ 
$sAdjuntos .= "\n\n----_Separador-de-mensajes_--\n"; 
$sAdjuntos .= "Content-type: ".$vAdjunto["type"].";name=\"".$vAdjunto["name"]."\"\n";; 
$sAdjuntos .= "Content-Transfer-Encoding: BASE64\n"; 
$sAdjuntos .= "Content-disposition: attachment;filename=\"".$vAdjunto["name"]."\"\n\n";

$oFichero = fopen($vAdjunto["tmp_name"], 'r'); 
$sContenido = fread($oFichero, filesize($vAdjunto["tmp_name"])); 
$sAdjuntos .= chunk_split(base64_encode($sContenido)); 
fclose($oFichero); 
} 
}

if ($bHayFicheros) 
$sTexto .= $sAdjuntos."\n\n----_Separador-de-mensajes_----\n"; 
return(mail($sPara, $sAsunto, $sTexto, $sCabeceras)); 
}

//cambiar aqui el email 
if (form_mail("langelcubas9@gmail.com", $_POST["name"], 
"Los datos introducidos en el formulario son:\n\n", $_POST["email"])){ 
	echo "Su formulario ha sido enviado con exito"; 
	header('location: postulantes.htm?message="OK"');
}else{
    echo "Mensaje no enviado";
    header('location: postulantes.htm?message="KO"');
}






#$mail = "Datos del postulante";
//Titulo
#$titulo = "Postulante";
//cabecera
#$headers = "MIME-Version: 1.0\r\n"; 
#$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
//dirección del remitente 
#$headers .= "From: GTHGROUP <langelcubas9@gmail.com>\r\n";
//Enviamos el mensaje a tu_dirección_email 
#try{
#	$bool = mail("langelcubas9@gmail.com",$titulo,$mail,$headers);
#	if($bool){
#    	echo "Mensaje enviado";
#    	header('location: postulantes.htm?message="OK"');
#	}else{
#	    echo "Mensaje no enviado";
#	    header('location: postulantes.htm?message="KO"');
#	}
#}catch(Exception $e){
#	echo $e->getMessage();
#}


  ?>