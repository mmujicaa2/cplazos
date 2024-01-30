
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
//$id_unidad=$_POST['id_unidad'];
//$rit=$_POST['rit'];
//$era=$_POST['era'];
//$tipotramite=$_POST['tipotramite'];
//$fechafatal=$_POST['fechafatal'];
//$observacion=$_POST['observacion'];

$id_unidad=4;
$rit=1;
$era=2001;
$tipotramite="Tramite ABC";
$observacion="Glosa del trámite";
$fechafatal="2024-01-22";
$fechafatal2=str_replace("-","",$fechafatal);
$fechaformato=date_format(date_create($fechafatal),"d/m/Y");
$ahora=date('d/m/Y H:i:s');




require_once("icalendar-master/zapcallib.php");

$title = "Simple Event";
// date/time is in SQL datetime format
$event_start = "2024-01-20 12:00:00";
$event_end = "2024-01-20 13:00:00";

// create the ical object
$icalobj = new ZCiCal();

// create the event within the ical object
$eventobj = new ZCiCalNode("VEVENT", $icalobj->curnode);

// add title
$eventobj->addNode(new ZCiCalDataNode("SUMMARY:" . $title));

// add start date
$eventobj->addNode(new ZCiCalDataNode("DTSTART:" . ZCiCal::fromSqlDateTime($event_start)));

// add end date
$eventobj->addNode(new ZCiCalDataNode("DTEND:" . ZCiCal::fromSqlDateTime($event_end)));

// UID is a required item in VEVENT, create unique string for this event
// Adding your domain to the end is a good way of creating uniqueness
$uid = date('Y-m-d-H-i-s') . "@demo.icalendar.org";
$eventobj->addNode(new ZCiCalDataNode("UID:" . $uid));

// DTSTAMP is a required item in VEVENT
$eventobj->addNode(new ZCiCalDataNode("DTSTAMP:" . ZCiCal::fromSqlDateTime()));

// Add description
$eventobj->addNode(new ZCiCalDataNode("Description:" . ZCiCal::formatContent(
    "This is a simple event, using the Zap Calendar PHP library. " .
    "Visit http://icalendar.org to validate icalendar files.")));

// write iCalendar feed to stdout
$ical3=$icalobj->export();









$sqlcorreo= "SELECT correo FROM correounidad WHERE id_unidad=$id_unidad";

//echo $sqlcorreo;
            $result = $conn->query($sqlcorreo);
                        if ($result->num_rows > 0) {
                          while($row = $result->fetch_assoc()) {
                            if($row<>""){
                            $mail->addAddress($row['correo'], 'Notificaciones sistema de Control de Plazos'.$ahora);
                            //$mail->addAddress('mmujica@pjud.cl', 'Notificaciones sistema de Control de Plazos'.$ahora);
                            }
                          }
                        } else {
                          echo "0 results";
                        }
                        $conn->close();

//CAMBIAR CORREO
$correocc=$_POST['correocc'];
//$correocc='mmujicaa2@gmail.com';

if($correocc<>""){
    $mail->addAddress($correocc, 'Notificaciones sistema de Control de Plazos'.$ahora);
    //$mail->addAddress($correocc, 'Notificaciones sistema de Control de Plazos'.$ahora);
}


$fecha=date("Y-m-d")." ".date("h:m:s");

$eventoplano="RIT: $rit".", "."Año: ".$era.", "."Tipo trámite: ".$tipotramite.", "."Observación: ".$observacion.", "."Fecha perentoria: ".$fechaformato;




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
        <h4 class='inline m-L'><b>Se agendado un evento en el Sistema de Control de Plazos</b></h4>
        <br />
        <span class=''>Tipo de trámite $tipotramite</span><br />
        <span class=''>RIT $rit</span><br />
        <span class=''>Año $era</span><br />
        <span class=''>Fecha Perentoria: </span><span class='bold'>$fechaformato</span><br />
        <span class=''>Detalle: </span><span class=''>$observacion</span><br /><br />
        <span class='bold'>Abra y acepte el calendario adjunto.</span>

    </div>
    </div>
</body>
";




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
$mail->addStringAttachment($ical3,'evento.ics','7bit','text/calendar; charset=utf-8; method=REQUEST');





$mail->Subject = 'Se ha creado un evento sistema de control de Plazos ';

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
    echo 'Mailer Error: ' . $mail->ErrorInfo;
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