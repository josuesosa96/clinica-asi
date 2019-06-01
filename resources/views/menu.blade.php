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
              @hasanyrole('secretary')
              {{ link_to('/secretary-home', $title = 'Crear expediente', $attributes = ['class' => 'btn btn-info btn-lg btn-block', 'role' => 'button'])}}
              {{ link_to('/secretary-edit-file', $title = 'Consultar expediente', $attributes = ['class' => 'btn btn-info btn-lg btn-block', 'role' => 'button'])}}
              @endhasanyrole

              @hasanyrole('super-admin')
              {{ link_to('/secretary-home', $title = 'Crear expediente', $attributes = ['class' => 'btn btn-info btn-lg btn-block', 'role' => 'button'])}}
              {{ link_to('/secretary-edit-file', $title = 'Consultar expediente (secretaria)', $attributes = ['class' => 'btn btn-info btn-lg btn-block', 'role' => 'button'])}}
              {{ link_to('/doctor-edit-file', $title = 'Consultar expediente (doctor)', $attributes = ['class' => 'btn btn-info btn-lg btn-block', 'role' => 'button'])}}
              @endhasanyrole

              @hasanyrole('doctor|specialist-doctor')
              {{ link_to('/doctor-edit-file', $title = 'Consultar expediente', $attributes = ['class' => 'btn btn-info btn-lg btn-block', 'role' => 'button'])}}
              @endhasanyrole

              @hasanyrole('super-admin|lab-manager')
              {{ link_to('/lab-edit-file', $title = 'Consultar exámenes de paciente', $attributes = ['class' => 'btn btn-info btn-lg btn-block', 'role' => 'button'])}}
              @endhasanyrole

              {{-- {{ link_to('#', $title = 'Crear cita para exámenes(no disponible)', $attributes = ['class' => 'btn btn-warning btn-lg btn-block', 'role' => 'button'])}} --}}
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection
