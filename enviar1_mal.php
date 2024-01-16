
<?php

include "conexion.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/PHPMailer/src/Exception.php';
require 'C:/xampp/PHPMailer/src//PHPMailer.php';
require 'C:/xampp/PHPMailer/src//SMTP.php';
require 'C:/xampp/PHPMailer/src//POP3.php';

use PHPMailer\PHPMailer\POP3;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer();

$mail->isSMTP();

$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->Host = 'mail.pjud.cl';
$mail->Port = 587;

$mail->SMTPAuth = true;

$mail->Username = 'mmujica';

$mail->Password = 'Mmujica1406_';

$mail->setFrom('mmujica@pjud.cl', 'Sistema de Control de Plazos');

$mail->addReplyTo('mmujica@pjud.cl', 'JG TEST PHP REPLY');



//CAMBIAR UNIDAD !
 $id_unidad=4;

 $sqlunidad= "      SELECT correounidad.correo 
                    FROM cplazos.correounidad
                    INNER JOIN cplazos.agenda
                    ON (correounidad.id_unidad = agenda.id_unidad)
                    WHERE (agenda.id_unidad = $id_unidad)";
 //$sqlunidad="zzzzz";

//echo $sqlunidad;

            $result = $conn->query($sqlunidad);
                        if ($result->num_rows > 0) {
                          while($row = $result->fetch_assoc()) {


                            //$mail->addAddress($row['correo'], 'Notificaciones sistema de Control de Plazos');

                          }
                        } else {
                          echo "0 results";
                        }
                        $conn->close();



$ahora=date('d/m/Y H:i:s');
$mail->addAddress('mmujica@pjud.cl', 'TEST CALENDARIO'.$ahora);
$mail->addAddress('mmujicaa2@gmail.com', 'TEST DESDE pjud a gmail');
//$mail->addAddress('acta4_jgcopiapo@pjud.cl', 'TEST DESDE pjud a gmail pjud');




$finicio=strtotime(date("Y-m-d")."+5 days");;
$inicio=date('Y-m-d',$finicio);

$ffin=strtotime(date("Y-m-d")."+5 days");
$fin=date('Y-m-d',$ffin);

$fecha=date("Y-m-d")." ".date("h:m:s");

//echo "aaa";
// echo $inicio;
//echo "bbb";


 //echo date("d/m/Y");

/*$ical_content="
BEGIN:VCALENDAR
VERSION:1.0
BEGIN:VEVENT
CATEGORIES:MEETING
STATUS:TENTATIVE
DTSTART:".$startDateTime."
DTEND:".$endDateTime."
SUMMARY:TRÁMITE ".$cname."
DESCRIPTION:".$message."
CLASS:PRIVATE
END:VEVENT
END:VCALENDAR"; */


/*$ical_content =    ' BEGIN:VCALENDAR
PRODID:-//Microsoft Corporation//Outlook 11.0 MIMEDIR//EN
VERSION:2.0
METHOD:PUBLISH
BEGIN:VEVENT
ORGANIZER:MAILTO:noreply@pjud.cl
DTSTART:'.$inicio.'
DTEND:'.$inicio.'
LOCATION: Juzgado de Garantía de Copiapó
TRANSP:OPAQUE
SEQUENCE:0
UID:u2coh5g3bppo2d2o3t@google.com
ATTENDEE;
CUTYPE=INDIVIDUAL;
ROLE=REQ-PARTICIPANT;
PARTSTAT=ACCEPTED;
CN=mmujica@pjud.cl
CREATED:19000101T120000Z
DTSTAMP:'.$fecha.'
DESCRIPTION:'.$compromiso.'
STATUS:CONFIRMED
SUMMARY:Evento sistema de control de plazos '.date($fecha).'
PRIORITY:5
CLASS:PUBLIC
END:VEVENT
END:VCALENDAR';*/


//$mail->Ical = $text;
//$mail->Ical = $ical_content;


// Otro ejemplo de envio de ical


//$ical_content = "BEGIN:VCALENDAR VERSION:2.0 PRODID://Drupal iCal API//EN BEGIN:VEVENT UID:http://www.icalmaker.com/event/d8fefcc9-a576-4432-8b20-40e90889affd DTSTAMP:20170203T045941Z DTSTART:20170214T060000Z DTEND:20170214T100000Z SUMMARY:Party in Daawat LOCATION:Hotel Daawat, Ground Floor, Phase 5, Sector 59, Near Post Office, Mohali 160059. DESCRIPTION:Dinner END:VEVENT END:VCALENDAR";





$from_name  =  "cplazos" ;
$from_address  ="mmujica@pjud.cl" ;
$to_name  =  "mmujica@pjud.cl" ;
$to_address  =  "mmujica@pjud.cl" ;
$startTime  ="04/30/2024 14:24:00" ;
$endTime    ="04/30/2024 15:45:00" ;
$asunto  =  " cita con especialista " ;
$Descripcion  =  " Hola tu  te recodamos que tienes una reunion  ñññ con tal en x  <br><center><img src='../img/fondo3.png' width='350px' height='350px' ></center>" ;
$ubicacion  =  " en donde nose " ;


    //Create Email Headers
    $mime_boundary = "----Meeting Booking----".MD5(TIME());
    $headers = "From: ".$from_name." <".$from_address.">\n";
    $headers .= "Reply-To: ".$from_name." <".$from_address.">\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
    $headers .= "Content-class: urn:content-classes:calendarmessage\n";

    //Create Email Body (HTML)
    $message = "--$mime_boundary\r\n";
    $message .= "Content-Type: text/html; charset=UTF-8\n";
    $message .= "Content-Transfer-Encoding: 8bit\n\n";
    $message .= "<html>\n";
    $message .= "<body>\n";
    $message .= '<p> '.$from_name.'</p>';
    $message .= '<p>'.$description.'</p>';
    $message .= "</body>\n";
    $message .= "</html>\n";
    $message .= "--$mime_boundary\r\n";

    /*$ical2 =
    'BEGIN:VCALENDAR' . "\r\n" .
    'PRODID:-//Microsoft Corporation//Outlook 15.0 MIMEDIR//EN' . "\r\n" .
    'VERSION:2.0' . "\r\n" .
    'METHOD:REQUEST' . "\r\n" .
    'BEGIN:VTIMEZONE' . "\r\n" .
    'TZID:Eastern Time' . "\r\n" .
    'BEGIN:STANDARD' . "\r\n" .
    'DTSTART:20091101T020000' . "\r\n" .
    'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
    'TZOFFSETFROM:-0500' . "\r\n" .
    'TZOFFSETTO:-0500' . "\r\n" .
    'TZNAME:EST' . "\r\n" .
    'END:STANDARD' . "\r\n" .
    'BEGIN:DAYLIGHT' . "\r\n" .
    'DTSTART:19700405T000000' . "\r\n" .
    'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3' . "\r\n" .
    'TZOFFSETFROM:-0500' . "\r\n" .
    'TZOFFSETTO:-0500' . "\r\n" .
    'TZNAME:EDST' . "\r\n" .
    'END:DAYLIGHT' . "\r\n" .
    'END:VTIMEZONE' . "\r\n" .
    'BEGIN:VEVENT' . "\r\n" .
    'ORGANIZER;CN=":MAILTO:'."mmujica@pjud.cl". "\r\n" .
    'ATTENDEE;CN=";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'."mmujica@pjud.cl". "\r\n" .
    'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
    'UID:'.date("Ymd\TGis", strtotime($startTime)).rand()."@".$domain."\r\n" .
    'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
    'DTSTART;TZID="Eastern Time:'.date("Ymd\THis", strtotime($startTime)). "\r\n" .
    'DTEND;TZID="Eastern Time:'.date("Ymd\THis", strtotime($endTime)). "\r\n" .
    'TRANSP:OPAQUE'. "\r\n" .
    'SEQUENCE:1'. "\r\n" .
    'SUMMARY:' . $subject . "\r\n" .
    'LOCATION:' . $location . "\r\n" .
    'CLASS:PUBLIC'. "\r\n" .
    'PRIORITY:5'. "\r\n" .
    'BEGIN:VALARM' . "\r\n" .
    'TRIGGER:-PT15M' . "\r\n" .
    'ACTION:DISPLAY' . "\r\n" .
    'DESCRIPTION:Reminder' . "\r\n" .
    'END:VALARM' . "\r\n" .
    'END:VEVENT'. "\r\n" .
    'END:VCALENDAR'. "\r\n";

    $message .= 'Content-Type: text/calendar;name="ical.ics";method=REQUEST'."\r\n";
    $message .= "Content-Transfer-Encoding: 7bit\r\n";
    $message .= $ical2."\r\n";
*/
    $ical2=
'METHOD:REPLY' . "\r\n"  .
'BEGIN:VCALENDAR' . "\r\n"  .
'PRODID:-//Microsoft Corporation//Outlook 15.0 MIMEDIR//EN' . "\r\n" .
'VERSION:2.0' . "\r\n"  .
'BEGIN:VEVENT' . "\r\n"  .
'DTSTART:20240115T110000Z' . "\r\n"  .
'DTEND:20240115T120000Z' . "\r\n"  .
'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
'SUMMARY:Sistema de control de Plazos' . "\r\n"  .
'UID:'.date("Ymd\TGis", strtotime($startTime)).rand()."@".$domain."\r\n" .
'ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=CONFIRMED;RSVP=TRUE;CN=noresponder@pjud.cl;X-NUM-GUESTS=0:mailto:noresponder@pjud.cl' . "\r\n"  .
'LOCATION:Juzgado de Garantía' . "\r\n"  .
'DESCRIPTION:Se ha generado un evento  para  controlar' . "\r\n"  .
'END:VEVENT' . "\r\n"  .
'END:VCALENDAR' . "\r\n" ;

















//$mail->CharSet = 'UTF-8';
$mail->isHTML(true);

$mail->msgHTML($ical2); 

//$mail->addStringAttachment($ical_content,'ical.ics','base64','text/calendar'); 

$mail->AddStringAttachment($ical2, "ical.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");





//$mail->CharSet = 'UTF-8'; 

//$mail->Subject = $subject; $mail->isHTML(true); $mail->msgHTML($message); 
//$mail->addStringAttachment($ical_content,'ical.ics','base64','text/calendar'); 







//Set the subject line

// DESCOMENTAR!!!

//$mail->Subject = 'Evento sistema de control de Plazos ';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), _DIR_);

//Replace the plain text body with one created manually
$mail->Body = 'Cuerpo del mensaje'.$ahora;

$mail->AltBody = 'mensaje';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
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