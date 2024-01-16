<?php
 
class Ical {
    private $creation_date;
    private $start_date;
    private $end_date;
    private $subject;
    private $organizer_name;
    private $organizer_email;
    private $description;
 
    /**
     * Constructor - Sets ICalendar Preferences
     *
     * The constructor can be passed an array of config values
     */
    public function __construct($config = array())
    {
        $this->creation_date = $this->timestamp_to_cal(time());
        $this->start_date = $this->timestamp_to_cal(time());
        $this->end_date = $this->timestamp_to_cal(time()+3600);
        $this->subject = '';
        $this->organizer_name = '';
        $this->organizer_email = '';
        $this->description = '';
        if (count($config) > 0)
        {
            $this->initialize($config);
        }
    }
 
    //-._-._-._-._-._-._-._-._MAIN FUNCTIONS-._-._-._-._-._-._-._-._//
 
    // --------------------------------------------------------------------
 
    /**
     * Initialize preferences
     *
     * @access  public
     * @param   array
     * @return  void
     */
    public function initialize($config = array())
    {
        foreach ($config as $key => $val)
        {
            if (isset($this->$key))
            {
                $method = 'set_'.$key;
 
                if (method_exists($this, $method))
                {
                    $this->$method($val);
                }
                else
                {
                    $this->$key = $val;
                }
            }
        }
 
        return $this;
    }
 
    public function send_ical_event_email($email_from, $email_to, $subject, $html_message) {
 
        //Create unique identifier
        $cal_uid = date('Ymd').'T'.date('His')."-".rand()."@tudominio.com";
 
        //Create Mime Boundry
        //Sirve para separar los tipos de contenidos (iCalendar y el cuerpo del mensaje)
        $mime_boundary = "----lo_que_quieras----".md5(time());
 
        //Create Email Headers
        $headers = "From: Nombre <".$email_from.">\n";
        $headers .= "Reply-To: Nombre <".$email_from.">\n";
 
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
        $headers .= "Content-class: urn:content-classes:calendarmessage\n";
 
        //Create Email Body (HTML)
        $message = "--$mime_boundary\n";
        $message .= "Content-Type: text/html; charset=UTF-8\n";
        $message .= "Content-Transfer-Encoding: 8bit\n\n";
 
        $message .= $html_message;
        $message .= "\n";
        $message .= "--$mime_boundary\n";
 
        //Create ICAL Content (Google rfc 2445 for details and examples of usage)
        $ical = 'BEGIN:VCALENDAR
PRODID:-//Microsoft Corporation//Outlook 11.0 MIMEDIR//EN
VERSION:2.0
METHOD:REQUEST
BEGIN:VEVENT
ORGANIZER:MAILTO:'.$email_from.'
DTSTART:'.$this->start_date.'
DTEND:'.$this->end_date.'
TRANSP:OPAQUE
SEQUENCE:0
UID:'.$cal_uid.'
DTSTAMP:'.$this->creation_date.'
DESCRIPTION:'.$this->description.'
SUMMARY:'.$this->subject.'
PRIORITY:5
CLASS:PUBLIC
END:VEVENT
END:VCALENDAR';
 
        $message .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST;charset=utf-8\n';
        $message .= "Content-Transfer-Encoding: 8bit\n\n";
        $message .= $ical;            
 
        //SEND MAIL
        $mail_sent = @mail($email_to, $subject, $message, $headers );
 
        if($mail_sent)     {
            return true;
        } else {
            return false;
        }   
 
    }
 
    //-._-._-._-._-._-._-._-._HELPER FUNCTIONS-._-._-._-._-._-._-._-._//
    public function x_date_to_cal($date){
        if(is_numeric($date)){
            return $this->timestamp_to_cal($date);
        }else{
            return $this->date_to_cal($date);
        }
    }
 
    public function date_to_cal($date_str) {
        return $this->timestamp_to_cal(strtotime($date_str));
    }
 
    public function timestamp_to_cal($timestamp){
        return gmdate('Ymd\THis\Z', $timestamp);
    }
 
    // Escapes a string of characters
    public function escape_string($string) {
        $string = preg_replace('/([\,;])/','\\\$1', $string);
        return html_entity_decode($string, ENT_QUOTES, 'UTF-8');
    }
 
    //-._-._-._-._-._-._-._-._SETTERS-._-._-._-._-._-._-._-._//
    public function set_creation_date($date){
        $this->creation_date = $this->x_date_to_cal($date);
        return $this;
    }
 
    public function set_start_date($date){
        $this->start_date = $this->x_date_to_cal($date);
        return $this;
    }
 
    public function set_end_date($date){
        $this->end_date = $this->x_date_to_cal($date);
        return $this;
    }
 
    public function set_subject($subject){
        $this->subject = $this->escape_string($subject);
        return $this;
    }
 
    public function set_organizer_name($name){
        $this->organizer_name = $this->escape_string($name);
        return $this;
    }
 
    public function set_organizer_email($email){
        $this->organizer_email = $this->escape_string($email);
        return $this;
    }
 
    public function set_description($description){
        $description = strip_tags($description);
        $this->description = $this->escape_string($description);
        return $this;
    }



$icalendar = new class Ical(array(
                'start_date' => '12-10-2014 17:00', //También sirven timestamp, o fechas en cualquier otro formato válido en PHP
                'end_date' => '12-10-2014 19:00',
                'subject' => 'Asunto',
                'organizer_name' => 'Nombre del organizador del evento',
                'organizer_email' => 'organizador@dominio.com',
                'description' => 'Descripción del evento'
                ));
 
if($icalendar->send_ical_event_email('email_desde@dominio.com', 'email_destino@dominio.com', 'Asunto del email', 'Mensaje del email')) {
    echo 'Email envíado';
}else{
    echo 'Error al enviar email';

    
}