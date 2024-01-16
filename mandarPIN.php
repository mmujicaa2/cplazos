<?php
header('Content-Type: text/html; charset=UTF-8');
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
session_start();

error_reporting(0);

$usuario = $_SESSION['correo'];

$conexion=mysqli_connect("localhost","root","","bd_vf");








 

    date_default_timezone_set('America/Santiago');
    $fecha = date('d-m-Y');
    $hora = date('H:i:s');


  
    $resultado4="SELECT * FROM funcionario where correo='$usuario' and pass='' ";
    $resultado4 = $conexion->query($resultado4);
    $num_rows4 = $resultado4->num_rows;

    if($num_rows4 > 0 ){
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        //Obtenemos la longitud de la cadena de caracteres
        $longitudCadena=strlen($cadena);
     
        //Definimos la variable que va a contener la contraseña
        $pass = "";
        $passCerrar = "";
        //Se define la longitud de la contraseña, puedes poner la longitud que necesites
        //Se debe tener en cuenta que cuanto más larga sea más segura será.
        $longitudPass=5;
     
        //Creamos la contraseña recorriendo la cadena tantas veces como hayamos indicado
        for($i=1 ; $i<=$longitudPass ; $i++){
            //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
            $pos=rand(0,$longitudCadena-1);
            $pos2=rand(0,$longitudCadena-1);
     
            //Vamos formando la contraseña con cada carácter aleatorio.
            $pass .= substr($cadena,$pos,1);
            $passCerrar .= substr($cadena,$pos2,1);
        }
    
    
        $sql="UPDATE funcionario set pass='$pass' where correo='$usuario' ";
        $resultado = $conexion->query($sql);
    
    
        $_SESSION['correo']=$usuario;

        

/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */

//Import PHPMailer classes into the global namespace
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;



//require '../vendor/autoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
//SMTP::DEBUG_OFF = off (for production use)
//SMTP::DEBUG_CLIENT = client messages
//SMTP::DEBUG_SERVER = client and server messages
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;

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
$p = "PIN sesion telematica: ";
$mail->setFrom('mmujica@pjud.cl', $p.' temporal');

//Set an alternative reply-to address
//This is a good place to put user-submitted addresses
$mail->addReplyTo('lucasxdd19@gmail.com', 'JG TEST PHP REPLY');

//Set who the message is to be sent to
$mail->addAddress($usuario, $usuario);

//Set the subject line
$mail->Subject = $p.' temporal ';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), _DIR_);

//Replace the plain text body with one created manually
$mail->Body = 'Esta es su PIN de entrada  '.$pass.' ,  que dura hasta el dia de hoy '.$fecha;

$mail->AltBody = 'mensaje';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
$mail->CharSet = 'UTF-8';
//send the message, check for errors
if (!$mail->send()) {
 //   echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
 //   echo 'Message sent!';
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





?>

<?php


include("login.php");
error_reporting(0);
session_start();
?>
   <div id="ventanaModal" class="modal" style=" z-index: 10;">
        <div class="contenido-modal" style="border-radius:30px;">
           
    
            <h3>Pin de entrada enviado a su correo </h3>
          
            <p style="margin-top:30px;" >  <a class="cerrarModal" id="btnCerrarModal" style="margin-top:50px; text-decoration: none;">Cerrar</a></p>
    
        </div>
      </div>
    
      <script>
    
    // Ventana modal
    var modal = document.getElementById("ventanaModal");
    
    // Botón que abre el modal
    var boton = document.getElementById("abrirModal");
    var botonCerrar = document.getElementById("btnCerrarModal").addEventListener("click",ed)

    function ed(){

        modal.style.display = "none";
    }
    
    // Hace referencia al elemento <span> que tiene la X que cierra la ventana
    var span = document.getElementsByClassName("cerrar")[0];
    
    modal.style.display = "block";
    
    // Si el usuario hace click fuera de la ventana, se cierra.
    window.addEventListener("click",function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    });
    
    </script>
<?php



    }

    else{

        ?>

        <?php
        
        
        include("login.php");
        error_reporting(0);
        session_start();
        ?>
            <div id="ventanaModal" class="modal" style=" z-index: 10;">
        <div class="contenido-modal" style="border-radius:30px;">
           
    
            <h3>Ya se envió su PIN de entrada, revisar correo </h3>
          
            <p style="margin-top:30px;" >  <a class="cerrarModal" id="btnCerrarModal" style="margin-top:50px; text-decoration: none;">Cerrar</a></p>
    
        </div>
      </div>
    
      <script>
    
    // Ventana modal
    var modal = document.getElementById("ventanaModal");
    
    // Botón que abre el modal
    var boton = document.getElementById("abrirModal");
    var botonCerrar = document.getElementById("btnCerrarModal").addEventListener("click",ed)

    function ed(){

        modal.style.display = "none";
    }
    
    // Hace referencia al elemento <span> que tiene la X que cierra la ventana
    var span = document.getElementsByClassName("cerrar")[0];
    
    modal.style.display = "block";
    
    // Si el usuario hace click fuera de la ventana, se cierra.
    window.addEventListener("click",function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    });
    
    </script>
        <?php

    }

          
            
            