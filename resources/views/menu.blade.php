@extends('layouts.app')

@section('js')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col"></div>
        <div class="col-8">
            <h1>Menú</h1>

            <div class="row">
              {{ link_to('/home', $title = 'Crear expediente', $attributes = ['class' => 'btn btn-info btn-lg btn-block', 'role' => 'button'])}}
              {{ link_to('/edit-file', $title = 'Consultar expediente', $attributes = ['class' => 'btn btn-info btn-lg btn-block', 'role' => 'button'])}}
              {{ link_to('#', $title = 'Consultar exámenes de paciente (no disponible)', $attributes = ['class' => 'btn btn-warning btn-lg btn-block', 'role' => 'button'])}}
              {{ link_to('#', $title = 'Crear cita para exámenes(no disponible)', $attributes = ['class' => 'btn btn-warning btn-lg btn-block', 'role' => 'button'])}}
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection
