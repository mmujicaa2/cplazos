<!--#include file="Conexion.asp"-->
<%
  Dim sql

  IP = request.ServerVariables("REMOTE_ADDR") 
  Host = request.ServerVariables("REMOTE_HOST") 
  User = request.ServerVariables("REMOTE_USER") 
  usuario=""
  usuario=session("usragenda")
  'response.write(usuario)
    if usuario="" then
      'response.write("Debe iniciar Sesion")
      response.redirect("accesotribunal.asp")
    end if

%>


<!DOCTYPE html>
<html>
<head>
	<title>Agendamiento Dirigido</title>

  <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">

<!-- Jquery --> 
<script src="js/jquery.min.js"></script>
<script src="js/eventos.js"></script>
 
<!-- Viewport --> 
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

<!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<!--Datepicker bootstrap-->
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/bootstrap-datepicker.es.min.js"></script>
<link href="css/bootstrap-datepicker.css" rel="stylesheet"/>


<!-- Fontawesome-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">



  <!--Estilos CSS-->
  <link rel="stylesheet" href="css/estilo.css">


</head>
<body>
<nav class="navbar navbar-nav  navbar-expand-lg bg-secondary  mb-2 mr-sm-2">
  <a style="color:#d9534f" class="navbar-text navbar-center text-light">Agendamiento dirigido (Usar en casos especiales)</a>
  

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
    </ul>
	<form class="form-inline my-2 my-lg-0 mb-2 mr-sm-2" action="bloqueo.asp" >
      <button class="btn btn-danger my-2 my-sm-0" type="submit"><i class="fa fa-lock"></i> Bloqueos</a></button>
      <input type="hidden" name="Tribunal" value=1>
      <input type="hidden" name="Materia" value=1>
    </form>

    <form class="form-inline my-2 my-lg-0 mb-2 mr-sm-2" action="desbloqueo.asp" >
      <button class="btn btn-primary my-2 my-sm-0" type="submit"><i class="fa fa-unlock"></i> Desbloqueos</a></button>
      <input type="hidden" name="Tribunal" value=1>
      <input type="hidden" name="Materia" value=1>
    </form>
	
    <form class="form-inline my-2 my-lg-0 mb-2 mr-sm-2" action="Calendario.Asp" method="get">
      <button class="btn btn-info my-2 my-sm-0" type="submit"><i class="fa fa-calendar "></i> Agenda</a></button>
      <input type="hidden" name="Tribunal" value=1>
      <input type="hidden" name="Materia" value=1>
    </form>
  </div>
</nav>




<form action="agregadirigido.asp" method="post">

<div class="container col col-lg-10  " >
      
      <div class="form-inline form-group ">
      <div class="form-group  input-group">
          <input class="form-inline form-control mb-2 mr-sm-2 " type="text" name="RIT" id="rit" placeholder="Rit" pattern="[0-9]{1,5}" required />
          <div class="form-group mb-2 mr-sm-2  ">
          
                  <input  id="datepicker2" onkeydown="return false" class="form-control form-group  " name="era" placeholder="Año" required>
                    <label for="datepicker2">
                      <span class="input-group-text" id="basic-addon2" for="datepicker" >
                        <i class="fa fa-calendar " style="font-size:24px"></i>
                      </span>
                    </label>
       </div>


      </div>
      
     <%
   Set rs5 = Server.CreateObject("ADODB.Recordset")
     sql = "Select * from TipoAudiencias where  Visible=1 order by nombre asc"
     rs5.Open Sql,Base
    'response.write sql
     'nom=""
%>  

        <select name="tipoaudiencia" class="form-control form-group mb-2 mr-sm-2 col-md-6" required pattern="[0-9]{1,3}">
                  <option selected value="" >Seleccione Tipo de Audiencia</option>                
           <%
                  While not rs5.EOF
                      ' Buscar Bloque Horario
                        if rs5("bloque") > 0 then
                           Set rs1 = Server.CreateObject("ADODB.Recordset")
                           consulta2 = "Select * from TipoBloque where Id=" & rs5("bloque")
                           rs1.Open Consulta2,Base
                           
                           if Not rs1.Eof then
                              vhora = rs1("hora")  
                           else
                              vhora = "-"  
                           end if
                           rs1.close

                         else
                           Set rs1 = Server.CreateObject("ADODB.Recordset")
                           consulta2 = "Select * from Audienciasporbloque where TipoAud='" & rs5("tipoaud") & "'" 
                           Rs1.Open Consulta2,Base
                           vhora = "" 
                           cuenta=0                                       
                           while not rs1.EOF
                                 cuenta = cuenta + 1
                                 if cuenta = 1 then
                                    vhora = vhora & rs1("hora")  
                                 else
                                    vhora = vhora & "-" & rs1("hora")  
                                 end if
                                 Rs1.Movenext
                           Wend 
                           rs1.close
                         end if
                  
                      '  if rs5("plazodesde") > 0 then
                         response.write("<option value=" & rs5("id") & ">" & mid(rs5("nombre"),1,35) &nbsp & "  (" & rs5("plazodesde")& "-" & rs5("plazohasta") & ")" & "  (" & rs5("internodesde")& "-" & rs5("internohasta") & ")"  & "</option>")                                  
                      '  else
                      '     response.write("<option value=" & rs5("id") & ">" & mid(rs5("nombre"),1,35) &nbsp & "</option>")                                                                      
                      '  end if
                        Rs5.Movenext
                        
                  Wend 
                  rs5.close 
            %>
           </select>

       <div class="form-group mb-2 mr-sm-2 ">
                  <input  id="datepicker" onkeydown="return false" class="form-control form-group " name="fecha" placeholder="Seleccione Fecha" required>
                    <label for="datepicker">
                      <span class="input-group-text" id="basic-addon2" for="datepicker" >
                        <i class="fa fa-calendar " style="font-size:24px"></i>
                      </span>
                    </label>
       </div>

      



</div>

      <div class="input-group form-group">
          <input class="form-inline form-control mb-2 mr-sm-2  col-lg-6" type="text" name="glosa" id="glosa" placeholder="Glosa" maxlength="50" pattern="*{5,50}" required />
      <button id="Enviar6" type="button bnt btn-lg" class="btn btn-outline-primary btn col-lg form-control form-group mb-2 mr-sm-2">Agendar</button>
	  </div>
 </form>
 

 </div> <!--Cierre container -->




<%

fechaingresada=request.querystring("fechaactual")
  

If fechaingresada = "" Then
    fechaactual=date()
else
    fechaactual=cdate(fechaingresada)
end if 
    
    semanaantes=fechaactual-7
    semanadespues=fechaactual+7

%>






 <div class="container ">
        <div class="col-md-12 text-center form-group form-inline my-3 ">
           <form  action="Agendamientodirigido.asp?" method="get">
            <button id="Enviar7" type="button bnt " class="btn  "><i class="fas fa-arrow-left"></i> Sem.Ant.</button>
            <input type="hidden" name="fechaactual" value="<% response.write(semanaantes)%>" />
          </form>

           <form  class="align-items-end" action="Agendamientodirigido.asp?" method="get">
            <button id="Enviar8" type="button bnt " class="btn  ">Sem.Sig <i class="fas fa-arrow-right"></i></button>
            <input type="hidden" name="fechaactual" value="<% response.write(semanadespues) %>"/>
           </form>

        </div>
    </div>




    
  
      

    

<!-- 
<embed type="text/html" src="https://docs.google.com/spreadsheets/d/1IQS3S8WnnZjyrQ-4WNSBtlf6ZRBsXmCSDrU8EZDhaVs/edit#gid=1959127465" width="1600" height="600">
-->

<%





diasemana=Weekday(fechaactual,2)
      Select Case diasemana
        Case 1
        lunesfecha=(datepart("d",fechaactual)&"/"&datepart("m",fechaactual)&"/"&datepart("yyyy",fechaactual))
        martesfecha=(datepart("d",fechaactual+1)&"/"&datepart("m",fechaactual+1)&"/"&datepart("yyyy",fechaactual+1))
        miercolesfecha=(datepart("d",fechaactual+2)&"/"&datepart("m",fechaactual+2)&"/"&datepart("yyyy",fechaactual+2))
        juevesfecha=(datepart("d",fechaactual+3)&"/"&datepart("m",fechaactual+3)&"/"&datepart("yyyy",fechaactual+3))
        viernesfecha=(datepart("d",fechaactual+4)&"/"&datepart("m",fechaactual+4)&"/"&datepart("yyyy",fechaactual+4))

        Case 2
        lunesfecha=(datepart("d",fechaactual-1)&"/"&datepart("m",fechaactual-1)&"/"&datepart("yyyy",fechaactual-1))
        martesfecha=(datepart("d",fechaactual)&"/"&datepart("m",fechaactual)&"/"&datepart("yyyy",fechaactual))
        miercolesfecha=(datepart("d",fechaactual+1)&"/"&datepart("m",fechaactual+1)&"/"&datepart("yyyy",fechaactual+1))
        juevesfecha=(datepart("d",fechaactual+2)&"/"&datepart("m",fechaactual+2)&"/"&datepart("yyyy",fechaactual+2))
        viernesfecha=(datepart("d",fechaactual+3)&"/"&datepart("m",fechaactual+3)&"/"&datepart("yyyy",fechaactual+3))

        Case 3
        lunesfecha=(datepart("d",fechaactual-2)&"/"&datepart("m",fechaactual-2)&"/"&datepart("yyyy",fechaactual-2))
        martesfecha=(datepart("d",fechaactual-1)&"/"&datepart("m",fechaactual-1)&"/"&datepart("yyyy",fechaactual-1))
        miercolesfecha=(datepart("d",fechaactual)&"/"&datepart("m",fechaactual)&"/"&datepart("yyyy",fechaactual))
        juevesfecha=(datepart("d",fechaactual+1)&"/"&datepart("m",fechaactual+1)&"/"&datepart("yyyy",fechaactual+1))
        viernesfecha=(datepart("d",fechaactual+2)&"/"&datepart("m",fechaactual+2)&"/"&datepart("yyyy",fechaactual+2))
        Case 4
          lunesfecha=(datepart("d",fechaactual-3)&"/"&datepart("m",fechaactual-3)&"/"&datepart("yyyy",fechaactual-3))
        martesfecha=(datepart("d",fechaactual-2)&"/"&datepart("m",fechaactual-2)&"/"&datepart("yyyy",fechaactual-1))
        miercolesfecha=(datepart("d",fechaactual-1)&"/"&datepart("m",fechaactual-1)&"/"&datepart("yyyy",fechaactual-1))
        juevesfecha=(datepart("d",fechaactual)&"/"&datepart("m",fechaactual)&"/"&datepart("yyyy",fechaactual))
        viernesfecha=(datepart("d",fechaactual+1)&"/"&datepart("m",fechaactual+1)&"/"&datepart("yyyy",fechaactual+1))
        Case 5
          lunesfecha=(datepart("d",fechaactual-4)&"/"&datepart("m",fechaactual-4)&"/"&datepart("yyyy",fechaactual-4))
        martesfecha=(datepart("d",fechaactual-3)&"/"&datepart("m",fechaactual-3)&"/"&datepart("yyyy",fechaactual-3))
        miercolesfecha=(datepart("d",fechaactual-2)&"/"&datepart("m",fechaactual-2)&"/"&datepart("yyyy",fechaactual-2))
        juevesfecha=(datepart("d",fechaactual-1)&"/"&datepart("m",fechaactual-1)&"/"&datepart("yyyy",fechaactual-1))
        viernesfecha=(datepart("d",fechaactual)&"/"&datepart("m",fechaactual)&"/"&datepart("yyyy",fechaactual))
        Case 6
          lunesfecha=(datepart("d",fechaactual-5)&"/"&datepart("m",fechaactual-5)&"/"&datepart("yyyy",fechaactual-5))
        martesfecha=(datepart("d",fechaactual-4)&"/"&datepart("m",fechaactual-4)&"/"&datepart("yyyy",fechaactual-4))
        miercolesfecha=(datepart("d",fechaactual-3)&"/"&datepart("m",fechaactual-3)&"/"&datepart("yyyy",fechaactual-3))
        juevesfecha=(datepart("d",fechaactual-2)&"/"&datepart("m",fechaactual-2)&"/"&datepart("yyyy",fechaactual-2))
        viernesfecha=(datepart("d",fechaactual-1)&"/"&datepart("m",fechaactual-1)&"/"&datepart("yyyy",fechaactual-1))
        Case 7
          lunesfecha=(datepart("d",fechaactual-6)&"/"&datepart("m",fechaactual-6)&"/"&datepart("yyyy",fechaactual-6))
        martesfecha=(datepart("d",fechaactual-5)&"/"&datepart("m",fechaactual-5)&"/"&datepart("yyyy",fechaactual-5))
        miercolesfecha=(datepart("d",fechaactual-4)&"/"&datepart("m",fechaactual-4)&"/"&datepart("yyyy",fechaactual-4))
        juevesfecha=(datepart("d",fechaactual-3)&"/"&datepart("m",fechaactual-3)&"/"&datepart("yyyy",fechaactual-3))
        viernesfecha=(datepart("d",fechaactual-2)&"/"&datepart("m",fechaactual-2)&"/"&datepart("yyyy",fechaactual-2))

      End Select
  'Separa las fechas como insumo para algoritmo de busqueda de topes por dia'
   splitlunes=split(lunesfecha,"/")
   splitmartes=split(martesfecha,"/")
   splitmiercoles=split(miercolesfecha,"/")
   splitjueves=split(juevesfecha,"/")
   splitviernes=split(viernesfecha,"/")

    'response.write("Miercoles dia "&splitmiercoles(0))
    'response.write("Miercoles mes "&splitmiercoles(1))
    'response.write("Miercoles año "&splitmiercoles(2))

%>

<div class="container-fluid " >

<div class="row  align-items-end ">
    <div class="col text-left  p-0 " ><strong><div class="h6">Tipo Audiencia</strong></div>
  <%
          bgcolor0=""
          bgcolor1="bg-light"
          color=1

     Set rsTipoAudiencias = Server.CreateObject("ADODB.Recordset")
      qtipoaudiencias = "Select * from TipoAudiencias where  Visible=1 order by nombre asc"
      rsTipoAudiencias.Open qtipoaudiencias,Base

      While not rsTipoAudiencias.EOF

        if color=1 then
                      bgcolor=bgcolor1
                      color=0
                    else
                      bgcolor=bgcolor0
                      color=1
                    end if 


        response.write("<div class='col "&bgcolor&"'"&">"&mid(rsTipoAudiencias("nombre"),1,31)&"</div>")
        'Aca va todo el chorizo para obtener la suma de las audiencias de cada tipo para ese dia especifico, restarlo con el valor maximo para ese dia e insertar el valor en la grilla (si es negat esta sobreag.)
        

      rsTipoAudiencias.Movenext
      Wend 
  

      rsTipoAudiencias.close 


      %>

  </div>
    <div class="col text-left p-0"><strong>Lunes <% response.write(lunesfecha) %></strong>

<%
      
      color=1

      Set rsTipoAudiencias = Server.CreateObject("ADODB.Recordset")
      qtipoaudiencias = "Select * from TipoAudiencias where  Visible=1 order by nombre asc"
      rsTipoAudiencias.Open qtipoaudiencias,Base

      While not rsTipoAudiencias.EOF
        Set rssumaudxdias = Server.CreateObject("ADODB.Recordset")
          qrysumaudxdias = "SELECT COUNT(DISTINCT `audiencias`.`audiencia`) as SUMAUD FROM     `multimateria`.`tipoaudiencias` INNER JOIN `multimateria`.`audienciasporbloque` ON  (`tipoaudiencias`.`TipoAud` = `audienciasporbloque`.`TipoAud`)INNER JOIN `multimateria`.`audienciasporbloquedias`  ON (`audienciasporbloquedias`.`Id_audporbloque` = `audienciasporbloque`.`Id`)    INNER JOIN `multimateria`.`audiencias`       ON (`audiencias`.`IdTipoAud` = `tipoaudiencias`.`TipoAud`) WHERE `audiencias`.`IdTipoAud` ="&rsTipoAudiencias("tipoaud")&" AND audiencias.dia="&splitlunes(0)&" AND audiencias.mes="&splitlunes(1)&" AND audiencias.ano="&splitlunes(2)&" AND  tipoaudiencias.visible=1"
          rssumaudxdias.Open qrysumaudxdias,Base



          Set rscantxdias= Server.CreateObject("ADODB.Recordset")
          qrycantxdias = "SELECT `audienciasporbloquedias`.`T_Lun`  , `tipoaudiencias`.`TipoAud`   , `audienciasporbloquedias`.`Id_audporbloque` FROM  `multimateria`.`audienciasporbloquedias` INNER JOIN `multimateria`.`audienciasporbloque`  ON (`audienciasporbloquedias`.`Id_audporbloque` = `audienciasporbloque`.`Id`) INNER JOIN `multimateria`.`tipoaudiencias`  ON (`audienciasporbloque`.`TipoAud` = `tipoaudiencias`.`TipoAud`) WHERE (`tipoaudiencias`.`TipoAud` ="&rsTipoAudiencias("tipoaud")&"  AND `tipoaudiencias`.`Visible` =1);"
          rscantxdias.Open qrycantxdias,Base



          While not rssumaudxdias.EOF
                    a=cint(rssumaudxdias("SUMAUD"))
                    b=cint(rscantxdias("T_Lun"))
                    c=b-a

                    if color=1 then
                      bgcolor=bgcolor1
                      color=0
                    else
                      bgcolor=bgcolor0
                      color=1
                    end if 

                    response.write("<div class=' col text-left "&bgcolor&"'"&">" &"Cup:"&b&" | Age:"&a&" | Libres: "&"<strong>"&c&"</strong>"&"</div>")
                    
                    'response.write(c)
                    rssumaudxdias.Movenext
                    rscantxdias.Movenext
          Wend 
                    rssumaudxdias.close 
                    rscantxdias.close

      rsTipoAudiencias.Movenext
      Wend 

      rsTipoAudiencias.close 


      %>

  </div>
    <div class="col text-left p-0"><strong>Martes <% response.write(martesfecha) %></strong>


<%
      
      color=1
          
      Set rsTipoAudiencias = Server.CreateObject("ADODB.Recordset")
      qtipoaudiencias = "Select * from TipoAudiencias where  Visible=1 order by nombre asc"
      rsTipoAudiencias.Open qtipoaudiencias,Base

      While not rsTipoAudiencias.EOF
        
        qrysumaudxdias = "SELECT COUNT(DISTINCT `audiencias`.`audiencia`) as SUMAUD FROM     `multimateria`.`tipoaudiencias` INNER JOIN `multimateria`.`audienciasporbloque` ON  (`tipoaudiencias`.`TipoAud` = `audienciasporbloque`.`TipoAud`)INNER JOIN `multimateria`.`audienciasporbloquedias`  ON (`audienciasporbloquedias`.`Id_audporbloque` = `audienciasporbloque`.`Id`)    INNER JOIN `multimateria`.`audiencias`       ON (`audiencias`.`IdTipoAud` = `tipoaudiencias`.`TipoAud`) WHERE `audiencias`.`IdTipoAud` ="&rsTipoAudiencias("tipoaud")&" AND audiencias.dia="&splitmartes(0)&" AND audiencias.mes="&splitmartes(1)&" AND audiencias.ano="&splitmartes(2)&" AND  tipoaudiencias.visible=1"
          rssumaudxdias.Open qrysumaudxdias,Base

         Set rscantxdias= Server.CreateObject("ADODB.Recordset")
          qrycantxdias = "SELECT `audienciasporbloquedias`.`T_Mar`  , `tipoaudiencias`.`TipoAud`   , `audienciasporbloquedias`.`Id_audporbloque` FROM  `multimateria`.`audienciasporbloquedias` INNER JOIN `multimateria`.`audienciasporbloque`  ON (`audienciasporbloquedias`.`Id_audporbloque` = `audienciasporbloque`.`Id`) INNER JOIN `multimateria`.`tipoaudiencias`  ON (`audienciasporbloque`.`TipoAud` = `tipoaudiencias`.`TipoAud`) WHERE (`tipoaudiencias`.`TipoAud` ="&rsTipoAudiencias("tipoaud")&"  AND `tipoaudiencias`.`Visible` =1);"
          rscantxdias.Open qrycantxdias,Base

          
          While not rssumaudxdias.EOF
                    a=cint(rssumaudxdias("SUMAUD"))
                    b=cint(rscantxdias("T_Mar"))
                    c=b-a

                    if color=1 then
                      bgcolor=bgcolor1
                      color=0
                    else
                      bgcolor=bgcolor0
                      color=1
                    end if 

                      response.write("<div class='col text-left "&bgcolor&"'"&">" &"Cup:"&b&" | Age:"&a&" | Libres: "&"<strong>"&c&"</strong>"&"</div>")
                    'response.write(c)
                    rssumaudxdias.Movenext
                    rscantxdias.Movenext
          Wend 
                    rssumaudxdias.close 
                    rscantxdias.close

      rsTipoAudiencias.Movenext
      Wend 

      rsTipoAudiencias.close 


      %>



    </div>


    <div class="col text-left p-0"><strong>Miércoles <% response.write(miercolesfecha) %></strong>
<%
      color=1    
   
      Set rsTipoAudiencias = Server.CreateObject("ADODB.Recordset")
      qtipoaudiencias = "Select * from TipoAudiencias where  Visible=1 order by nombre asc"
      rsTipoAudiencias.Open qtipoaudiencias,Base

      While not rsTipoAudiencias.EOF
        'response.write("<div class='col'>"&mid(rsTipoAudiencias("nombre"),1,35))
        'response.write("</div>")
        'Aca va todo el chorizo para obtener la suma de las audiencias de cada tipo para ese dia especifico, restarlo con el valor maximo para ese dia e insertar el valor en la grilla (si es negat esta sobreag.)


        Set rssumaudxdias = Server.CreateObject("ADODB.Recordset")
          qrysumaudxdias = "SELECT COUNT(DISTINCT `audiencias`.`audiencia`) as SUMAUD FROM     `multimateria`.`tipoaudiencias` INNER JOIN `multimateria`.`audienciasporbloque` ON  (`tipoaudiencias`.`TipoAud` = `audienciasporbloque`.`TipoAud`)INNER JOIN `multimateria`.`audienciasporbloquedias`  ON (`audienciasporbloquedias`.`Id_audporbloque` = `audienciasporbloque`.`Id`)    INNER JOIN `multimateria`.`audiencias`       ON (`audiencias`.`IdTipoAud` = `tipoaudiencias`.`TipoAud`) WHERE `audiencias`.`IdTipoAud` ="&rsTipoAudiencias("tipoaud")&" AND audiencias.dia="&splitmiercoles(0)&" AND audiencias.mes="&splitmiercoles(1)&" AND audiencias.ano="&splitmiercoles(2)&" AND  tipoaudiencias.visible=1"
          rssumaudxdias.Open qrysumaudxdias,Base

         Set rscantxdias= Server.CreateObject("ADODB.Recordset")
          qrycantxdias = "SELECT `audienciasporbloquedias`.`T_Mie`  , `tipoaudiencias`.`TipoAud`   , `audienciasporbloquedias`.`Id_audporbloque` FROM  `multimateria`.`audienciasporbloquedias` INNER JOIN `multimateria`.`audienciasporbloque`  ON (`audienciasporbloquedias`.`Id_audporbloque` = `audienciasporbloque`.`Id`) INNER JOIN `multimateria`.`tipoaudiencias`  ON (`audienciasporbloque`.`TipoAud` = `tipoaudiencias`.`TipoAud`) WHERE (`tipoaudiencias`.`TipoAud` ="&rsTipoAudiencias("tipoaud")&"  AND `tipoaudiencias`.`Visible` =1);"
          rscantxdias.Open qrycantxdias,Base



          While not rssumaudxdias.EOF

                    

                    a=cint(rssumaudxdias("SUMAUD"))
                    b=cint(rscantxdias("T_Mie"))
                    c=b-a

                    if color=1 then
                      bgcolor=bgcolor1
                      color=0
                    else
                      bgcolor=bgcolor0
                      color=1
                    end if 

                    response.write("<div class='col text-left "&bgcolor&"'"&">" &"Cup:"&b&" | Age:"&a&" | Libres: "&"<strong>"&c&"</strong>"&"</div>")

                    
                    'response.write(c)
                    rssumaudxdias.Movenext
                    rscantxdias.Movenext
          Wend 
                    rssumaudxdias.close 
                    rscantxdias.close

      rsTipoAudiencias.Movenext
      Wend 

      rsTipoAudiencias.close 


      %>
    </div>
    <div class="col text-left p-0"><strong>Jueves <% response.write(juevesfecha) %></strong>
<%

   color=1
      Set rsTipoAudiencias = Server.CreateObject("ADODB.Recordset")
      qtipoaudiencias = "Select * from TipoAudiencias where  Visible=1 order by nombre asc"
      rsTipoAudiencias.Open qtipoaudiencias,Base

      While not rsTipoAudiencias.EOF

        Set rssumaudxdias = Server.CreateObject("ADODB.Recordset")
          qrysumaudxdias = "SELECT COUNT(DISTINCT `audiencias`.`audiencia`) as SUMAUD FROM     `multimateria`.`tipoaudiencias` INNER JOIN `multimateria`.`audienciasporbloque` ON  (`tipoaudiencias`.`TipoAud` = `audienciasporbloque`.`TipoAud`)INNER JOIN `multimateria`.`audienciasporbloquedias`  ON (`audienciasporbloquedias`.`Id_audporbloque` = `audienciasporbloque`.`Id`)    INNER JOIN `multimateria`.`audiencias`       ON (`audiencias`.`IdTipoAud` = `tipoaudiencias`.`TipoAud`) WHERE `audiencias`.`IdTipoAud` ="&rsTipoAudiencias("tipoaud")&" AND audiencias.dia="&splitjueves(0)&" AND audiencias.mes="&splitjueves(1)&" AND audiencias.ano="&splitjueves(2)&" AND  tipoaudiencias.visible=1"
          rssumaudxdias.Open qrysumaudxdias,Base

      Set rscantxdias= Server.CreateObject("ADODB.Recordset")
          qrycantxdias = "SELECT `audienciasporbloquedias`.`T_Jue`  , `tipoaudiencias`.`TipoAud`   , `audienciasporbloquedias`.`Id_audporbloque` FROM  `multimateria`.`audienciasporbloquedias` INNER JOIN `multimateria`.`audienciasporbloque`  ON (`audienciasporbloquedias`.`Id_audporbloque` = `audienciasporbloque`.`Id`) INNER JOIN `multimateria`.`tipoaudiencias`  ON (`audienciasporbloque`.`TipoAud` = `tipoaudiencias`.`TipoAud`) WHERE (`tipoaudiencias`.`TipoAud` ="&rsTipoAudiencias("tipoaud")&"  AND `tipoaudiencias`.`Visible` =1);"
          rscantxdias.Open qrycantxdias,Base



          While not rssumaudxdias.EOF
                    a=cint(rssumaudxdias("SUMAUD"))
                    b=cint(rscantxdias("T_Jue"))
                    c=b-a
                    
                    if color=1 then
                      bgcolor=bgcolor1
                      color=0
                    else
                      bgcolor=bgcolor0
                      color=1
                    end if 

                    response.write("<div class='col text-left "&bgcolor&"'"&">" &"Cup:"&b&" | Age:"&a&" | Libres: "&"<strong>"&c&"</strong>"&"</div>")

                    'response.write(c)
                    rssumaudxdias.Movenext
                    rscantxdias.Movenext
          Wend 
                    rssumaudxdias.close 
                    rscantxdias.close

      rsTipoAudiencias.Movenext
      Wend 

      rsTipoAudiencias.close 


      %>
    </div>


    <div class="col text-left p-0"><strong>Viernes <% response.write(viernesfecha) %></strong>
<%

      color=1   

      Set rsTipoAudiencias = Server.CreateObject("ADODB.Recordset")
      qtipoaudiencias = "Select * from TipoAudiencias where  Visible=1 order by nombre asc"
      rsTipoAudiencias.Open qtipoaudiencias,Base

      While not rsTipoAudiencias.EOF
        

        Set rssumaudxdias = Server.CreateObject("ADODB.Recordset")
           qrysumaudxdias = "SELECT COUNT(DISTINCT `audiencias`.`audiencia`) as SUMAUD FROM     `multimateria`.`tipoaudiencias` INNER JOIN `multimateria`.`audienciasporbloque` ON  (`tipoaudiencias`.`TipoAud` = `audienciasporbloque`.`TipoAud`)INNER JOIN `multimateria`.`audienciasporbloquedias`  ON (`audienciasporbloquedias`.`Id_audporbloque` = `audienciasporbloque`.`Id`)    INNER JOIN `multimateria`.`audiencias`       ON (`audiencias`.`IdTipoAud` = `tipoaudiencias`.`TipoAud`) WHERE `audiencias`.`IdTipoAud` ="&rsTipoAudiencias("tipoaud")&" AND audiencias.dia="&splitviernes(0)&" AND audiencias.mes="&splitviernes(1)&" AND audiencias.ano="&splitviernes(2)&" AND  tipoaudiencias.visible=1"
          rssumaudxdias.Open qrysumaudxdias,Base

         Set rscantxdias= Server.CreateObject("ADODB.Recordset")
          qrycantxdias = "SELECT `audienciasporbloquedias`.`T_Vie`  , `tipoaudiencias`.`TipoAud`   , `audienciasporbloquedias`.`Id_audporbloque` FROM  `multimateria`.`audienciasporbloquedias` INNER JOIN `multimateria`.`audienciasporbloque`  ON (`audienciasporbloquedias`.`Id_audporbloque` = `audienciasporbloque`.`Id`) INNER JOIN `multimateria`.`tipoaudiencias`  ON (`audienciasporbloque`.`TipoAud` = `tipoaudiencias`.`TipoAud`) WHERE (`tipoaudiencias`.`TipoAud` ="&rsTipoAudiencias("tipoaud")&"  AND `tipoaudiencias`.`Visible` =1);"
          rscantxdias.Open qrycantxdias,Base



          While not rssumaudxdias.EOF
                    a=cint(rssumaudxdias("SUMAUD"))
                    b=cint(rscantxdias("T_Vie"))
                    c=b-a

                     if color=1 then
                      bgcolor=bgcolor1
                      color=0
                    else
                      bgcolor=bgcolor0
                      color=1
                    end if 

                    response.write("<div class='col text-left "&bgcolor&"'"&">" &"Cup:"&b&" | Age:"&a&" | Libres: "&"<strong>"&c&"</strong>"&"</div>")
                    
                    'response.write(c)
                    rssumaudxdias.Movenext
                    rscantxdias.Movenext
          Wend 
                    rssumaudxdias.close 
                    rscantxdias.close

      rsTipoAudiencias.Movenext
      Wend 

      rsTipoAudiencias.close 

      %>
    </div>
</div> <!-- Cierra el row-->


</div>



<!--  <embed type="text/html" src="https://docs.google.com/spreadsheets/d/1IQS3S8WnnZjyrQ-4WNSBtlf6ZRBsXmCSDrU8EZDhaVs/edit#gid=1959127465" width="1600" height="600">
-->

<!-- FIN GRILLA-->






<div class="footer">
  <p class="rights fixed-bottom"><a href="mailto:mmujica@pjud.cl">Desarrollado por Marcelo Mujica</a></p>
</div>

</body>
</html>