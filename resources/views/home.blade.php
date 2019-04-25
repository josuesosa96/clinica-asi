@extends('layouts.app')
@section('js')
  <script type="text/javascript">
  $(document).ready(function()
  {
    $('#collapsable-form').on('shown.bs.collapse', function()
    {
      if ($('#collapsable-search:visible'))
      {
        $('#collapsable-search').collapse('hide');
      }
    });

    $('#collapsable-search').on('shown.bs.collapse', function()
    {
      if ($('#collapsable-form:visible'))
      {
        $('#collapsable-form').collapse('hide');
      }
    });
  });
</script>
@endsection

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div> --}}
  <div class="container">
    <div class="row justify-content-center">
      <div class="col"></div>
      <div class="col-8">
        <div class="row">
          <div class="col-md-12 text-center">
            <button type="button" data-toggle="collapse" data-target="#collapsable-form" class="btn btn-primary btn-lg">Nuevo Paciente</button>
            <button type="button" data-toggle="collapse" data-target="#collapsable-search" class="btn btn-secondary btn-lg">Paciente Existente</button>
          </div>
        </div>

        <!--Busqueda-->
        <div class="row collapse" id="collapsable-search" style="margin-top: 20px;">
          <div class="col-md-12">
            <div class="input-group mb-3">
              <input type="text" class="form-control">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Buscar</button>
              </div>
            </div>
          </div>
        </div>


        <!--Formulario-->
        {{-- {!! Form::open(['id' => 'file-form']) !!} --}}
        {!! Form::open(['id' => 'file-form', 'action' => 'HomeController@create']) !!}
        <fieldset id="file-form-fieldset">
          <div class="row collapse" id="collapsable-form" style="margin-top: 20px;">
            <div class="col">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col">
                      <!--nombre-->
                      <div class="form-group">
                        <label for="name">Nombre Completo</label>
                        <input type="text" name="name" class="form-control">
                      </div>
                    </div>
                    <div class="col">
                      <!--edad-->
                      <div class="form-group">
                        <label for="age">Edad</label>
                        <input type="number" name="age" min="1" max="100" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <!--direcion-->
                  <div class="form-group">
                    <label for="address">Dirección</label>
                    <input type="text" name="address" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <!--numero telefono-->
                  <div class="form-group">
                    <label for="phone_number">Número de Teléfono</label>
                    <input type="text" name="phone_number" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <!--fecha-->
                  <div class="form-group">
                    <label for="appointment_date">Fecha de cita</label>
                    <input type="date" name="appointment_date" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <!--doc gen-->
                  <div class="form-group">
                    {!! Form::label('general_doctor_id', "Doctor General", ['class' => 'control-label'])!!}
                    {!! Form::select('general_doctor_id', ['3' =>'Doctor1'], null,  ['class' => 'fomr-control custom-select', 'id' => 'general_doctor_id', 'placeholder' => 'Seleccione un doctor'])!!}
                  </div>
                </div>
                <div class="col-md-6">
                  <!--doc esp-->
                  <div class="form-group">
                    {!! Form::label('specialist_doctor_id', "Doctor Especialista", ['class' => 'control-label'])!!}
                    {!! Form::select('specialist_doctor_id', ['10' =>'DoctorEsp1'], null,  ['class' => 'fomr-control custom-select', 'id' => 'specialist_doctor_id', 'placeholder' => 'Seleccione un doctor especialista'])!!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <!--alergias-->
                  <div class="form-group">
                    <label for="allergies">Alergias</label>
                    <textarea class="form-control" name="allergies" rows="2"></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="symptoms">Sintomas</label>
                    <textarea class="form-control" name="symptoms" rows="2"></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col text-center">
                  <button type="submit" class="btn btn-primary">Guardar expediente</button>
                </div>
              </div>
            </div>
          </div>
        </fieldset>
        {!! Form::close() !!}


        {{-- <div class="row">
          <div class="col"></div>
          <div class="col-md-8">

            <div class="form-group text-center">
              <form class="" action={{route('addRole', ['user' => auth::user()])}} method="get">
                <button type="submit" class="btn btn-primary">Guardar expediente</button>
              </form>
            </div>

            <div class="form-group text-center">
              <form class="" action={{route('getRoles', ['user' => auth::user()])}} method="get">
                <button type="submit" class="btn btn-primary">Test</button>
              </form>
            </div>

          </div>
          <div class="col"></div>
        </div> --}}


      </div>
      <div class="col"></div>
    </div>
  </div>
@endsection
