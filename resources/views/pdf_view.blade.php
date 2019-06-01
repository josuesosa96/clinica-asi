<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
 <title>{{ $title }}</title>
 <style media="screen">
   div{
     font-size: 15px;
   }
 </style>
</head>

<body>
  <center><h1>Paciente: {{ $file['first_name'] }} {{ $file['first_lastname'] }}</h1></center>
  <center><h1>Número: {{ $file['number'] }}</h1></center>
  <div style="width:40px;">
    <h4>Alergias</h4>
    <p>{{$file['allergies']}}</p>
  </div>
  <div style="width:40px;">
    <h4>Sintomas</h4>
    <p>{{$file['symptoms']}}</p>
  </div>
  <div style="width:40px;">
    <h4>Diagnostico</h4>
    <p>{{$file['diagnosis']}}</p>
  </div>
  <div style="width:40px;">
    <h4>Tratamiento</h4>
    <p>{{$file['treatment']}}</p>
  </div>
  <div style="width:600px;">
    <h4>Exámenes por hacer</h4>
    <p>{{$tests}}</p>
  </div>
  <div style="width:600px;">
    <h4>Exámenes hechos</h4>
    <p>{{$done_tests}}</p>
  </div>
  <div style="width:600px;">
    <h4>Resultados</h4>
    <p>{{$results}}</p>
  </div>
  <div style="width:600px;">
    <h4>Medicamentos recetados</h4>
  </div>

  <div>
    <br>
    <p>Firma &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Sello</p>
  </div>
</body>

</body>
</html>
