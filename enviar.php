
<?php

include "conexion.php";
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */

//Import PHPMailer classes into the global namespace
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/PHPMailer/src/Exception.php';
require 'C:/xampp/PHPMailer/src//PHPMailer.php';
require 'C:/xampp/PHPMailer/src//SMTP.php';
require 'C:/xampp/PHPMailer/src//POP3.php';

//Import PHPMailer classes into the global namespace
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\POP3;
use PHPMailer\PHPMailer\SMTP;

//require '../vendor/autoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
//SMTP::DEBUG_OFF = off (for production use)
//SMTP::DEBUG_CLIENT = client messages
//SMTP::DEBUG_SERVER = client and server messages
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

//Set the hostname of the mail server
$mail->Host = 'mail.pjud.cl';
//Use `$mail->Host = gethostbyname('smtp.gmail.com');`
//if your network does not support SMTP over IPv6,
//though this may cause issues with TLS

//Set the SMTP port number:
// - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
// - 587 for SMTP+STARTTLS
$mail->Port = 587;

//Set the encryption mechanism to use:
// - SMTPS (implicit TLS on port 465) or
// - STARTTLS (explicit TLS on port 587)
//$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = 'mmujica';

//Password to use for SMTP authentication
$mail->Password = 'Mmujica1406_';

//Set who the message is to be sent from
//Note that with gmail you can only use your account address (same as `Username`)
//or predefined aliases that you have configured within your account.
//Do not use user-submitted addresses in here
$mail->setFrom('mmujica@pjud.cl', 'JG Test PHP');

//Set an alternative reply-to address
//This is a good place to put user-submitted addresses
$mail->addReplyTo('mmujica@pjud.cl', 'JG TEST PHP REPLY');

//Set who the message is to be sent to
date(format)

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


$mail->addAddress('mmujica@pjud.cl', 'TEST DESDE pjud a gmail pjud');
//$mail->addAddress('mmujicaa2@gmail.com', 'TEST DESDE pjud a gmail');
//$mail->addAddress('jafuentesc@pjud.cl', 'TEST DESDE pjud a gmail pjud');

//calendario  y envio


/*require_once("icalendar-master/zapcallib.php");

$title = "Simple Event";
// date/time is in SQL datetime format
$event_start = "2024-02-01 12:00:00";
$event_end = "2024-02-01 13:00:00";

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
//echo $icalobj->export();*/






$finicio=date();

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























//$mail->CharSet = 'UTF-8';
$mail->isHTML(true);

$mail->msgHTML($ical_content); 

//$mail->addStringAttachment($ical_content,'ical.ics','base64','text/calendar'); 

$mail->AddStringAttachment($ical_content, "ical.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");





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
$mail->Body = 'Cuerpo del mensaje';

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