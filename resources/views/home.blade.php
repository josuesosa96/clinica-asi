@extends('layouts.app')
@section('js')
  <script type="text/javascript">

  function clearForm($form)
  {
    $form.find(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
  }

  $(document).ready(function()
  {
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
              'appointment_date': $('#appointment-date').val(),
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
            <div class="row" id="collapsable-form" style="margin-top: 20px;">
              <div class="col">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col">
                        <!--nombre-->
                        <div class="form-group">
                          <label for="name">Nombre Completo</label>
                          <input type="text" name="name" id="name" class="form-control">
                        </div>
                      </div>
                      <div class="col">
                        <!--edad-->
                        <div class="form-group">
                          <label for="age">Edad</label>
                          <input type="number" name="age" id="age" min="1" max="100" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <!--direcion-->
                    <div class="form-group">
                      <label for="address">Dirección</label>
                      <input type="text" name="address" id="address" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <!--numero telefono-->
                    <div class="form-group">
                      <label for="phone_number">Número de Teléfono</label>
                      <input type="text" name="phone_number" id="phone-number" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <!--fecha-->
                    <div class="form-group">
                      <label for="appointment_date">Fecha de cita</label>
                      <input type="date" name="appointment_date" id="appointment-date" class="form-control">
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
