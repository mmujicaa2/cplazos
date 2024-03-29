<?php
//error_reporting(0);


include "conexion.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/PHPMailer/src//Exception.php';
require 'C:/xampp/PHPMailer/src//PHPMailer.php';
require 'C:/xampp/PHPMailer/src//SMTP.php';
require 'C:/xampp/PHPMailer/src//POP3.php';

use PHPMailer\PHPMailer\POP3;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer();
$mail->isSMTP();
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->SMTPDebug = false;
$mail->Host = 'mail.pjud.cl';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'mmujica';
$mail->Password = 'Mmujica1406_';
$mail->setFrom('cplazos@pjud.cl', 'Sistema de Control de Plazos');
$mail->addReplyTo('cplazos@pjud.cl', 'no responder');

//Recupera Variables
$id_unidad=$_POST['id_unidad'];
$rit=$_POST['rit'];
$tipotramite=$_POST['tipotramite'];
$fechafatal=$_POST['fechafatal'];
$iniciales = $_POST['iniciales'];
$fechafatal2=str_replace("-","",$fechafatal);
$fechaformato=date_format(date_create($fechafatal),"d/m/Y");

$observacion=$_POST['observacion'];

//$id_unidad=4;
//$rit=1;
$era=2001;
//$tipotramite="Tramite ABC";
//$observacion="Glosa del trámite";
//$fechafatal="2024-01-22";
//$fechafatal2=str_replace("-","",$fechafatal);
//$fechaformato=date_format(date_create($fechafatal),"d/m/Y");

$ahora=date('d/m/Y H:i:s');



$sqlcorreo = "SELECT correo FROM correounidad WHERE id_unidad = ?";
$stmt = $pdo->prepare($sqlcorreo);

if ($stmt) {
    $stmt->execute([$id_unidad]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($row['correo'])) {
            $correo = $row['correo'];
            error_log('Correo obtenido: ' . $correo);
    
            // Verificar que la dirección de correo sea válida
            if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $mail->addAddress($correo, 'Notificaciones sistema de Control de Plazos');
            } else {
                error_log('Dirección de correo no válida: ' . $correo);
            }
        }
    }
} else {
    // Manejar el error en la preparación de la consulta
    error_log("Error en la preparación de la consulta SQL");
}

//CAMBIAR CORREO
$correocc=$_POST['correocc'];
//$correocc='mmujicaa2@gmail.com';

if($correocc<>""){
    $mail->addAddress($correocc, 'Notificaciones sistema de Control de Plazos'.$ahora);
    //$mail->addAddress($correocc, 'Notificaciones sistema de Control de Plazos'.$ahora);
}


$fecha=date("Y-m-d")." ".date("h:m:s");

$eventoplano="RIT: $rit".", "."Año: ".$era.",      "."Iniciales: ".$iniciales.",           "."Tipo trámite: ".$tipotramite.", "."Observación: ".$observacion.", "."Fecha perentoria: ".$fechaformato;




//$desc=nl2br($desc);
//echo $eventoplano;

$evento="
<head>
  <style>
    body {
        height: 100%; width: 100%; max-width: 100%;
        font-family: 'Tahoma', arial;
        overflow: hidden;
    }

    .wit {
        display: block; position:relative;
        width: 100%; max-width:80%;
        background-color: #FFF;
        left:10%;
    }

    .blue { color: #178195; }
    .bold { font-weight: bold; }
    .grey { color: #585858; }
    .padding32 { padding: 32px; }
  </style>
</head>

<body>
    <div class=wit>
    <div class=padding32>
        <h4 class='inline m-L'><b>Se editado un evento en el Sistema de Control de Plazos</b></h4>
        <br />
        <span class=''>Tipo de trámite: $tipoTramite</span><br />
        <span class=''>Iniciales: $iniciales</span><br />
        <span class=''>RIT y Año: $rit</span><br />
        <span class=''>Fecha Perentoria: </span><span class='bold'>$fechaformato</span><br />
        <span class=''>Detalle: </span><span class=''>$observacion</span><br /><br />
        <span class=''>Información: http://10.3.91.56/controlplazos/index.php</span><br />
        <span class='bold'>Abra y acepte el calendario adjunto.</span>
    </div>
    </div>
</body>";





    $ical2=
'BEGIN:VCALENDAR' . "\r\n"  .
'PRODID:-//Microsoft Corporation//Outlook 15.0 MIMEDIR//EN' . "\r\n" .
'VERSION:2.0' . "\r\n"  .
'METHOD:REQUEST' . "\r\n"  .
'BEGIN:VEVENT' . "\r\n"  .
'DTSTART;TZID=America/Santiago:'. $fechafatal2 .'T080000'. "\r\n" .
'DTEND;TZID=America/Santiago:'. $fechafatal2 .'T140000'. "\r\n" .
'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
'ATTENDEE;RSVP=TRUE;CN=Sistema de Control de Plazos;X-NUM-GUESTS=0:MAILTO:noresponder@pjud.cl'. "\r\n" .
'SUMMARY:Sistema de control de Plazos' . "\r\n"  .
'UID:'.date("Ymd\TGis", strtotime($startTime)).rand(). "\r\n" .
'X-MICROSOFT-CDO-BUSYSTATUS:TENTATIVE'. "\r\n" .
'X-MICROSOFT-CDO-IMPORTANCE:1'. "\r\n" .
'X-MICROSOFT-CDO-INTENDEDSTATUS:FREE'. "\r\n" .
'X-MICROSOFT-DISALLOW-COUNTER:FALSE'. "\r\n" .
'X-MS-OLK-AUTOSTARTCHECK:FALSE'. "\r\n" .
'X-MS-OLK-CONFTYPE:0'. "\r\n" .
'X-MS-OLK-SENDER;CN="Sistema de Control de Plazos":mailto:noresponder@pjud.cl'. "\r\n" .
'LOCATION:Juzgado de Garantia' . "\r\n"  .
'DESCRIPTION:Se ha generado un evento  para  controlar: '.$eventoplano. "\r\n"  .
'END:VEVENT' . "\r\n"  .
'END:VCALENDAR' . "\r\n" ;





$mail->CharSet = 'UTF-8';
$mail->isHTML(true);
$mail->msgHTML($ical2);
$mail->addStringAttachment($ical2,'evento.ics','7bit','text/calendar; charset=utf-8; method=REQUEST');





$mail->Subject = 'Se ha editado un evento sistema de control de Plazos ';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), _DIR_);

//Replace the plain text body with one created manually

$mail->Body =$evento;




//$mail->Body=nl2br($cuerpo);
$mail->AltBody = 'mensaje';



//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo 'Error de envio de correo: ' . $mail->ErrorInfo;
} else {
    echo 'Correo enviado!';
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}

//Section 2: IMAP
//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}







//header("location:login.php");