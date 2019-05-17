@extends('layouts.app')
@section('js')
  <script type="text/javascript">

  function clearForm($form)
  {
    $form.find(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
  }

  $(document).ready(function()
  {
    $('#dui').mask('00000000-0');
    $('#nit').mask('0000-000000-000-0');

    $('#close-success').on('click', function(e)
    {
      $(this).parent().hide();
      $('.file-message').remove();
    });

    $('#close-error').on('click', function(e)
    {
      $(this).parent().hide();
      $('.file-message').remove();
    });

    $('#birthdate').on('focusout', function()
    {
      var birthdate = moment($('#birthdate').val(), 'YYYY-MM-DD');
      var currentDate = moment();

      var age = (currentDate.diff(birthdate, 'years'));

      $('#age').val(age);
    });

    $('#save-file').click(function()
    {
      $.ajax(
        {
          type: 'POST',
          data: JSON.stringify(
            {
              '_token': "{{ csrf_token() }}",
              'name': $('#name').val(),
              'age': $('#age').val(),
              'address': $('#address').val(),
              'phone_number': $('#phone-number').val(),
              'general_doctor_id': $('#general-doctor-id').val(),
              'specialist_doctor_id': $('#specialist-doctor-id').val(),
              'allergies': $('#allergies').val(),
              'symptoms': $('#symptoms').val(),
            }
          ),
          ContentType: 'application/json',
          processData: true,
          url: '/create-file',
          success:function(json)
          {
            var text = document.createTextNode('El número de expediente es: #' + json);
            var pElement = document.createElement('p');
            var id = document.createAttribute('class');
            id.value = 'file-message';

            pElement.appendChild(text);
            pElement.setAttributeNode(id);
            document.getElementById('success-message').appendChild(pElement);

            $('#success-message').show();

            clearForm($('#file-form'));
          },
          error:function(request, status, error)
          {
            json = $.parseJSON(request.responseText);

            $.each(json.errors, function(key, value)
            {
              var text = document.createTextNode(value);
              var pElement = document.createElement('p');
              var id = document.createAttribute('class');
              id.value = 'file-message';

              pElement.appendChild(text);
              pElement.setAttributeNode(id);
              document.getElementById('error-message').appendChild(pElement);

              $('#error-message').show();
            });
          }
        }
      );
    });
  });
</script>
@endsection
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col"></div>
      <div class="col-8">

        <div class="alert alert-primary alert-dismissible fade show" id="success-message" style="display:none;" role="alert">
          El expediente se creo con exito!
          <button type="button" id="close-success" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="alert alert-danger alert-dismissible fade show" id="error-message" style="display:none;" role="alert">
          Hubo un error
          <button type="button" id="close-error" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="row">
          <h1>Nuevo Paciente</h1>
          <!--Formulario-->
          {!! Form::open(['id' => 'file-form']) !!}
          <fieldset id="file-form-fieldset">
            <div class="row" id="form" style="margin-top: 20px;">
              <div class="col">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col">
                        <!--nombre-->
                        <div class="form-group">
                          <label for="names">Nombres</label>
                          <input type="text" name="names" id="names" class="form-control">
                        </div>
                      </div>
                      <div class="col">
                        <!--apellidos-->
                        <div class="form-group">
                          <label for="first_lastname">Primer apellido</label>
                          <input type="text" name="first_lastname" id="first-lastname" class="form-control">
                        </div>
                      </div>
                      <div class="col">
                        <!--apellidos-->
                        <div class="form-group">
                          <label for="second_lastname">Segundo apellido</label>
                          <input type="text" name="second_lastname" id="second-lastname" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <!--Fecha nacimiento-->
                    <div class="form-group">
                      <label for="birthdate">Fecha de nacimiento</label>
                      {{ Form::date('birthdate', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'birthdate']) }}
                    </div>
                  </div>
                  <div class="col">
                    <!--edad-->
                    <div class="form-group">
                      <label for="age">Edad</label>
                      <input type="number" name="age" id="age" min="1" max="100" class="form-control">
                    </div>
                  </div>
                  <div class="col">
                    <!--sexo-->
                    <div class="form-group">
                      <label for="sex">Sexo</label>
                      {{ Form::select('sex', ['m' => 'mujer', 'h' => 'hombre'], null, ['placeholder' => 'sexo', 'class' => 'form-control', 'id' => 'sex']) }}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <!--DUI-->
                    <div class="form-group">
                      <label for="dui">DUI</label>
                      <input type="text" name="dui" id="dui" class="form-control" placeholder="00000000-0">
                    </div>
                  </div>
                  <div class="col">
                    <!--NIT-->
                    <div class="form-group">
                      <label for="nit">NIT</label>
                      <input type="text" name="nit" id="nit" class="form-control" placeholder="0000-000000-000-0">
                    </div>
                  </div>
                  <div class="col">
                    <!--numero telefono-->
                    <div class="form-group">
                      <label for="phone_number">Número de Teléfono</label>
                      <input type="text" name="phone_number" id="phone-number" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <!--nombre responsable-->
                    <div class="form-group">
                      <label for="responsible_name">Nombre del responsable</label>
                      <input type="text" name="responsible_name" id="responsible-name" class="form-control">
                    </div>
                  </div>
                  <div class="col">
                    <!--numero responsable-->
                    <div class="form-group">
                      <label for="responsible_number">Número del responsable</label>
                      <input type="text" name="responsible_number" id="responsible-number" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <!--direcion-->
                    <div class="form-group">
                      <label for="address">Dirección</label>
                      <input type="text" name="address" id="address" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <!--doc gen-->
                    <div class="form-group">
                      {!! Form::label('general_doctor_id', "Doctor General", ['class' => 'control-label'])!!}
                      {!! Form::select('general_doctor_id', ['3' =>'Doctor1'], null,  ['class' => 'form-control custom-select', 'id' => 'general-doctor-id', 'placeholder' => 'Seleccione un doctor'])!!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <!--doc esp-->
                    <div class="form-group">
                      {!! Form::label('specialist_doctor_id', "Doctor Especialista", ['class' => 'control-label'])!!}
                      {!! Form::select('specialist_doctor_id', ['10' =>'DoctorEsp1'], null,  ['class' => 'form-control custom-select', 'id' => 'specialist-doctor-id', 'placeholder' => 'Seleccione un doctor especialista'])!!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <!--alergias-->
                    <div class="form-group">
                      <label for="allergies">Alergias</label>
                      <textarea class="form-control" name="allergies" id="allergies" rows="2"></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="symptoms">Sintomas</label>
                      <textarea class="form-control" name="symptoms" id="symptoms" rows="2"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col text-center">
                    <button type="button" id="save-file" class="btn btn-primary">Guardar expediente</button>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col text-center">
                    {{ link_to('/edit-file', $title = 'Editar expediente', $attributes = ['class' => 'btn btn-success', 'role' => 'button'])}}
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
          {!! Form::close() !!}

        </div>
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
