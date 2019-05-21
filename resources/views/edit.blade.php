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
    $('#phone-number').mask('0000-0000');
    $('#responsible-phone-number').mask('0000-0000');

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

    $('#search-file-number').click(function()
    {
      $.ajax(
        {
          type: 'POST',
          data: JSON.stringify(
            {
              '_token': "{{ csrf_token() }}",
              'number': $('#file-number').val(),
            }
          ),
          ContentType: 'application/json',
          url: '/get-file',
          success:function(json)
          {
            $('#names').val(json[0].names);
            $('#first-lastname').val(json[0].first_lastname);
            $('#second-lastname').val(json[0].second_lastname);
            $('#birthdate').val(json[0].birthdate);
            $('#age').val(json[0].age);
            $('#sex').val(json[0].sex);
            $('#dui').val(json[0].dui == null ? '' : json[0].dui);
            $('#nit').val(json[0].nit == null ? '' : json[0].nit);
            $('#phone-number').val(json[0].phone_number == null ? '' : json[0].phone_number);
            $('#responsible-name').val(json[0].responsible_name == null ? '' : json[0].responsible_name);
            $('#responsible-phone-number').val(json[0].responsible_phone_number == null ? '' : json[0].responsible_phone_number);
            $('#address').val(json[0].address == null ? '' : json[0].address);
            $('#general-doctor-id').val(json[0].general_doctor_id);
            $('#specialist-doctor-id').val(json[0].specialist_doctor_id == null ? '' : json[0].specialist_doctor_id);
            $('#allergies').val(json[0].allergies == null ? '' : json[0].allergies);
            $('#symptoms').val(json[0].symptoms == null ? '' : json[0].symptoms);
            $('#diagnosis').val(json[0].diagnosis == null ? '' : json[0].diagnosis);
            $('#treatment').val(json[0].treatment == null ? '' : json[0].treatment);
            $('#todo-tests').val(json[0].todo_tests == null ? '' : json[0].todo_tests);
            $('#done-tests').val(json[0].done_tests == null ? '' : json[0].done_tests);
            $('#results').val(json[0].results == null ? '' : json[0].results);
            $('#appointment-date').val(json[0].appointment_date == null ? '' : json[0].appointment_date);
            $('#file-id').val(json[0].id);
          }
        });
    });

    $('#update-file').click(function()
    {
      if ($('#file-id').val() == '')
      {
        var text = document.createTextNode('Es necesario buscar un expediente antes de editar.');
        var pElement = document.createElement('p');
        var id = document.createAttribute('class');
        id.value = 'file-message';

        pElement.appendChild(text);
        pElement.setAttributeNode(id);
        document.getElementById('success-message').appendChild(pElement);

        $('#success-message').show();
      }
      else
      {
        $.ajax(
          {
            type: 'POST',
            data: JSON.stringify(
              {
                '_token': "{{ csrf_token() }}",
                'id': $('#file-id').val(),
                'names': $('#names').val(),
                'first_lastname': $('#first-lastname').val(),
                'second_lastname': $('#second-lastname').val(),
                'birthdate': $('#birthdate').val(),
                'age': $('#age').val(),
                'sex': $('#sex').val(),
                'dui': $('#dui').val(),
                'nit': $('#nit').val(),
                'phone_number': $('#phone-number').val(),
                'responsible_name': $('#responsible-name').val(),
                'responsible_phone_number': $('#responsible-phone-number').val(),
                'address': $('#address').val(),
                'appointment_date': $('#appointment-date').val(),
                'general_doctor_id': $('#general-doctor-id').val(),
                'specialist_doctor_id': $('#specialist-doctor-id').val(),
                'allergies': $('#allergies').val(),
                'symptoms': $('#symptoms').val(),
                'diagnosis': $('#diagnosis').val(),
                'treatment': $('#treatment').val(),
                'todo_tests': $('#todo-tests').val(),
                'done_tests': $('#done-tests').val(),
                'results': $('#results').val(),
              }
            ),
            ContentType: 'application/json',
            url: '/update-file',
            success:function(json)
            {
              var text = document.createTextNode('Se actualizó el expediente #' + json + ' satisfactoriamente');
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
      }
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
          <div class="col">
            <div class="row">
              <div class="col-md-12">
                <h1>Paciente Existente</h1>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-12">
                <div class="input-group mb-3">
                  <input type="text" name="file-number" id="file-number" class="form-control" placeholder="Buscar expediente por número">
                  <div class="input-group-append">
                    <button class="btn btn-outline-info" id="search-file-number" type="submit" id="btn-search-file">Buscar</button>
                  </div>
                </div>
              </div>
            </div>

            <!--Formulario-->
            {!! Form::open(['id' => 'edit-file-form']) !!}
            <fieldset id="file-form-fieldset">
              <div class="row" id="edit-form" style="margin-top: 20px;">
                <div class="col">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col">
                          <!--nombre-->
                          <div class="form-group">
                            <label for="names">Nombres</label>
                            <input type="text" name="names" id="names" class="form-control" onkeydown="return /[a-z]/i.test(event.key)">
                            {{ Form::hidden('id', null, ['id' => 'file-id'])}}
                          </div>
                        </div>
                        <div class="col">
                          <!--apellidos-->
                          <div class="form-group">
                            <label for="first_lastname">Primer apellido</label>
                            <input type="text" name="first_lastname" id="first-lastname" class="form-control" onkeydown="return /[a-z]/i.test(event.key)">
                          </div>
                        </div>
                        <div class="col">
                          <!--apellidos-->
                          <div class="form-group">
                            <label for="second_lastname">Segundo apellido</label>
                            <input type="text" name="second_lastname" id="second-lastname" class="form-control" onkeydown="return /[a-z]/i.test(event.key)">
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
                        {{ Form::date('birthdate', null, ['class' => 'form-control', 'id' => 'birthdate']) }}
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
                        <input type="text" name="phone_number" id="phone-number" class="form-control" placeholder="0000-0000">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <!--nombre responsable-->
                      <div class="form-group">
                        <label for="responsible_name">En caso de emergencia contactar a</label>
                        <input type="text" name="responsible_name" id="responsible-name" class="form-control" onkeydown="return /[a-z]/i.test(event.key)">
                      </div>
                    </div>
                    <div class="col">
                      <!--numero responsable-->
                      <div class="form-group">
                        <label for="responsible_phone_number">Número en caso de emergencia</label>
                        <input type="text" name="responsible_phone_number" id="responsible-phone-number" class="form-control" placeholder="0000-0000">
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
                    <div class="col">
                      <!--fecha de cita-->
                      <div class="form-group">
                        <label for="appointment_date">Fecha de cita</label>
                        {{ Form::date('appointment_date', null, ['class' => 'form-control', 'id' => 'appointment-date']) }}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <!--doc gen-->
                      <div class="form-group">
                        {!! Form::label('general_doctor_id', "Doctor General", ['class' => 'control-label'])!!}
                        {!! Form::select('general_doctor_id', ['3' =>'Doctor1'], null,  ['class' => 'form-control custom-select', 'id' => 'general-doctor-id', 'placeholder' => 'Seleccione un doctor'])!!}
                      </div>
                    </div>
                    <div class="col">
                      <!--doc esp-->
                      <div class="form-group">
                        {!! Form::label('specialist_doctor_id', "Doctor Especialista", ['class' => 'control-label'])!!}
                        {!! Form::select('specialist_doctor_id', ['4' =>'DoctorEsp1'], null,  ['class' => 'form-control custom-select', 'id' => 'specialist-doctor-id', 'placeholder' => 'Seleccione un doctor especialista'])!!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <!--alergias-->
                      <div class="form-group">
                        <label for="allergies">Alergias</label>
                        <textarea class="form-control" name="allergies" id="allergies" rows="2"></textarea>
                      </div>
                    </div>
                    <div class="col">
                      <!--sintomas-->
                      <div class="form-group">
                        <label for="symptoms">Sintomas</label>
                        <textarea class="form-control" name="symptoms" id="symptoms" rows="2"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <!--diagnostico-->
                      <div class="form-group">
                        <label for="diagnosis">Diagnostico</label>
                        <textarea class="form-control" name="diagnosis" id="diagnosis" rows="2"></textarea>
                      </div>
                    </div>
                    <div class="col">
                      <!--tratamiento-->
                      <div class="form-group">
                        <label for="treatment">Tratamiento</label>
                        <textarea class="form-control" name="treatment" id="treatment" rows="2"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <!--examenes por hacer-->
                      <div class="form-group">
                        <label for="todo_tests">Exámenes por realizar</label>
                        <textarea class="form-control" name="todo_tests" id="todo-tests" rows="2"></textarea>
                      </div>
                    </div>
                    <div class="col">
                      <!--examenes realizados-->
                      <div class="form-group">
                        <label for="done_tests">Exámenes realizados</label>
                        <textarea class="form-control" name="done_tests" id="done-tests" rows="2"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <!--resultados-->
                      <div class="form-group">
                        <label for="results">Resultados de los exámenes</label>
                        <textarea class="form-control" name="results" id="results" rows="2"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col text-center">
                      <button type="button" id="update-file" class="btn btn-primary">Actualizar expediente</button>
                    </div>
                    <div class="col text-center">
                      {{ link_to('/home', $title = 'Regresar', $attributes = ['class' => 'btn btn-success', 'role' => 'button'])}}
                    </div>
                  </div>
                </div>
              </div>
            </fieldset>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
      <div class="col"></div>
    </div>
  </div>
@endsection
