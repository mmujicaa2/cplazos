
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
$mail->setFrom('cplazos@pjud.cl', 'Sistema de Control de Plazos');
$mail->addReplyTo('cplazos@pjud.cl', 'no responder');

$mail->CharSet = 'UTF-8';
$mail->isHTML(true);
//$mail->msgHTML($ical2);




function save_mail($mail)
                            {
                                //You can change 'Sent Mail' to any other folder or tag
                                $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

                                //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
                                $imapStream = imap_open($path, $mail->Username, $mail->Password);

                                $result2 = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
                                imap_close($imapStream);

                                return $result2;
                            } //fin funcion





$fechahoy=date('d-m-Y');

$sqlcorreo=  $sqlunidad= "SELECT DISTINCT * FROM agenda WHERE fechafatal =STR_TO_DATE('$fechahoy','%d-%m-%Y') AND correocc<>'' ";

echo $sqlcorreo;

            $result = $conn->query($sqlcorreo);


                        if ($result->num_rows > 0) {
                          while($row = $result->fetch_assoc()) {

                            if ($row['correocc']<>""){
                                $mail->addAddress($row['correocc'], 'Notificaciones sistema de Control de Plazos');
                            } //finif

                            $fechaformato=date_format(date_create($row['fechafatal']),"d/m/Y");
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
                                    <h4 class='inline m-L'><b style='color:red'>Hoy vence un evento en el Sistema de Control de Plazos</b></h4>
                                    <br />
                                    <span class=''>Tipo de trámite: </span ><span class='bold'> $row[tipotramite]</span><br />
                                    <span class=''>RIT $row[rit]</span><br />
                                    <span class=''>Año $row[era]</span><br />
                                    <span class=''>Fecha Perentoria: </span><span class='bold'>$fechaformato</span><br />
                                    <span class=''>Detalle: </span ><span class='bold'>$row[observacion]</span><br /><br />
                                    <span class=''>Información: http://10.3.91.56/controlplazos/index.php</span><br />
                                </div>
                                </div>
                            </body>
                            ";


                            $mail->Body =$evento;
                            $mail->Subject = 'Hoy vence un evento en Sistema de control de Plazos ';
                            $mail->AltBody = 'mensaje';

                            //send the message, check for errors
                            if (!$mail->send()) {
                                echo 'Mailer Error: ' . $mail->ErrorInfo;
                            } //fin if
                            else
                            {
                                echo 'Correo CC enviado!';
                            } //fin else

                            $mail->clearAllRecipients();
                             }//fin while

                        }
                        else
                            {
                          echo "0 results";
                            } //finelse


                        $conn->close();


