
<?php

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

$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->Host = 'mail.pjud.cl';
$mail->Port = 587;

$mail->SMTPAuth = true;

$mail->Username = 'mmujica';

$mail->Password = 'Mmujica1406_';

$mail->setFrom('mmujica@pjud.cl', 'Sistema de Control de Plazos');

$mail->addReplyTo('mmujica@pjud.cl', 'JG TEST PHP REPLY');







$ahora=date('d/m/Y H:i:s');
$mail->addAddress('mmujica@pjud.cl', 'TEST CALENDARIO'.$ahora);
$mail->addAddress('mmujicaa2@gmail.com', 'TEST DESDE pjud a gmail');
$mail->addAddress('acta4_jgcopiapo@pjud.cl', 'TEST DESDE pjud a gmail pjud');





    $ical2=
'BEGIN:VCALENDAR' . "\r\n"  .
'PRODID:-//Microsoft Corporation//Outlook 15.0 MIMEDIR//EN' . "\r\n" .
'VERSION:2.0' . "\r\n"  .
'METHOD:REQUEST' . "\r\n"  .
'BEGIN:VEVENT' . "\r\n"  .
'DTSTART:20240115T110000Z' . "\r\n"  .
'DTEND:20240115T120000Z' . "\r\n"  .
'DTSTAMP:' .date("Ymd\THis"). "\r\n" .
'ATTENDEE;RSVP=TRUE;CN=Yourname;X-NUM-GUESTS=0:MAILTO:target-email-id' . "\r\n" .
'SUMMARY:Sistema de control de Plazos' . "\r\n"  .
'UID:'.date("Ymd\THis", strtotime($startTime)).rand()."@".$domain. "\r\n" .
'X-MICROSOFT-CDO-BUSYSTATUS:TENTATIVE'. "\r\n" .
'X-MICROSOFT-CDO-IMPORTANCE:1'. "\r\n" .
'X-MICROSOFT-CDO-INTENDEDSTATUS:FREE'. "\r\n" .
'X-MICROSOFT-DISALLOW-COUNTER:FALSE'. "\r\n" .
'X-MS-OLK-AUTOSTARTCHECK:FALSE'. "\r\n" .
'X-MS-OLK-CONFTYPE:0'. "\r\n" .
'X-MS-OLK-SENDER;CN="Marcelo Mujica Adrián":mailto:mmujica@pjud.cl'. "\r\n" .
'LOCATION:Juzgado de Garantia' . "\r\n"  .
'DESCRIPTION:Se ha generado un evento  para  controlar' . "\r\n"  .
'X-MICROSOFT-CDO-BUSYSTATUS:BUSY' . "\r\n"  .
'X-MICROSOFT-CDO-IMPORTANCE:1' . "\r\n"  .
'X-MICROSOFT-DISALLOW-COUNTER:FALSE' . "\r\n"  .
'X-MS-OLK-AUTOFILLLOCATION:FALSE' . "\r\n"  .
'X-MS-OLK-CONFTYPE:0' . "\r\n"  .
'DESCRIPTION:Reminder' . "\r\n"  .
'END:VEVENT' . "\r\n"  .
'END:VCALENDAR' . "\r\n" ;






//$mail->CharSet = 'UTF-8';                               // Enable verbose debug output
//$mail->isHTML(true);
//$mail->Subject = $data['subject'];
////$mail->MsgHTML($data['body']);
//$mail->addStringAttachment($ical2,'ical.ics','base64','text/calendar');





//$mail->CharSet = 'UTF-8';
$mail->isHTML(true);

$mail->msgHTML($ical2);

$mail->addStringAttachment($ical2,'ical.ics','base64','text/calendar; charset=utf-8; method=REQUEST');






//$mail->CharSet = 'UTF-8';
//$mail->isHTML(true);

//$mail->msgHTML($ical2);

//$mail->addStringAttachment($ical2,'ical.ics','base64','text/calendar; charset=utf-8; method=REQUEST');


//$mail->AddStringAttachment($ical2, "ical.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");





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