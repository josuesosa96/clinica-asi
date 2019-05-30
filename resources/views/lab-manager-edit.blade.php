@extends('layouts.app')
@section('js')
  <script type="text/javascript">

  function clearForm($form)
  {
    $form.find(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
  }

  $(document).ready(function()
  {
    $('#files-grid').DataTable({
      select: true,
      language: {
        'info': "Mostrando _START_ a _END_ de _TOTAL_ entradas",
        'lengthMenu': 'Mostrar _MENU_ entradas',
        'search': 'Buscar',
        "paginate": {
          "first": "Primero",
          "last": "Último",
          "next": "Siguiente",
          "previous": "Anterior"
        },
        select: {
          rows: {
            _: "%d filas seleccionadas"
          }
        }
      },
      data: {!! json_encode($files) !!},
      columns: [
        {data: 'id', "visible": false},
        {data: 'number'},
        {data: 'first_name'},
        {data: 'first_lastname'},
        {data: 'phone_number'}
      ]
    });

    var table = $('#files-grid').DataTable();

    table.on('select', function(e, dt, type, indexes)
    {
      if (type === 'row')
      {
        var data = table.rows(indexes).data().pluck('id');

        $.ajax(
          {
            type: 'POST',
            data: JSON.stringify(
              {
                '_token': "{{ csrf_token() }}",
                'id': data,
              }
            ),
            ContentType: 'application/json',
            url: '/get-file',
            success:function(json)
            {
              $('#first-name').val(json[0].first_name);
              $('#second-name').val(json[0].second_name);
              $('#first-lastname').val(json[0].first_lastname);
              $('#second-lastname').val(json[0].second_lastname);
              // $('#birthdate').val(json[0].birthdate);
              // $('#age').val(json[0].age);
              // $('#sex').val(json[0].sex);
              // $('#dui').val(json[0].dui);
              // $('#nit').val(json[0].nit);
              // $('#phone-number').val(json[0].phone_number);
              // $('#second-phone-number').val(json[0].second_phone_number);
              // $('#responsible-name').val(json[0].responsible_name);
              // $('#responsible-phone-number').val(json[0].responsible_phone_number);
              // $('#address').val(json[0].address);
              // $('#city').val(json[0].city);
              // $('#state').val(json[0].state);
              // $('#general-doctor-id').val(json[0].general_doctor_id);
              // $('#specialist-doctor-id').val(json[0].specialist_doctor_id);
              $('#allergies').val(json[0].allergies);
              $('#symptoms').val(json[0].symptoms);
              $('#diagnosis').val(json[0].diagnosis);
              $('#treatment').val(json[0].treatment);
              $('#done-tests').val(json[0].done_tests);
              $('#todo-tests').val(json[0].todo_tests);
              $('#results').val(json[0].results);
              $('#file-id').val(json[0].id);

              $('#grid').collapse('hide');
            }
          });
        $('#file-form-fieldset').collapse('show');
      }
    });

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
            console.log(json);
            $('#first-name').val(json[0].first_name);
            $('#second-name').val(json[0].second_name);
            $('#first-lastname').val(json[0].first_lastname);
            $('#second-lastname').val(json[0].second_lastname);
            $('#allergies').val(json[0].allergies);
            $('#symptoms').val(json[0].symptoms);
            $('#diagnosis').val(json[0].diagnosis);
            $('#treatment').val(json[0].treatment);
            $('#todo-tests').val(json[0].todo_tests);
            $('#done-tests').val(json[0].done_tests);
            $('#results').val(json[0].results);
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
                'done_tests': $('#done-tests').val(),
                'results': $('#results').val(),
              }
            ),
            ContentType: 'application/json',
            url: '/lab-update-file',
            success:function(json)
            {
              var text = document.createTextNode('Se guardaron los exámnes del paciente ' + json + ' satisfactoriamente');
              var pElement = document.createElement('p');
              var id = document.createAttribute('class');
              id.value = 'file-message';

              pElement.appendChild(text);
              pElement.setAttributeNode(id);
              document.getElementById('success-message').appendChild(pElement);

              $('#success-message').show();

              $('#grid').collapse('show');
              $('#file-form-fieldset').collapse('hide');

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

            <!--grid-->
            <div id="grid" class="collapse show">
              <table class="table" id="files-grid" data-page-length='5'>
                <thead>
                  <tr>
                    <th scope="col">id</th>
                    <th scope="col">Número</th>
                    <th scope="col">Primer nombre</th>
                    <th scope="col">Primer apellido</th>
                    <th scope="col">Teléfono</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>

            <!--Formulario-->
            {!! Form::open(['id' => 'edit-file-form']) !!}
            <fieldset id="file-form-fieldset" class="collapse">
              <div class="row" id="edit-form" style="margin-top: 20px;">
                <div class="col">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col">
                          <!--nombre1-->
                          <div class="form-group">
                            <label for="first_name">Primer nombre</label>
                            <input type="text" name="first_name" id="first-name" class="form-control" onkeydown="return /[a-z]/i.test(event.key)" disabled>
                            {{ Form::hidden('id', null, ['id' => 'file-id'])}}
                          </div>
                        </div>
                        <div class="col">
                          <!--nombre2-->
                          <div class="form-group">
                            <label for="second_name">Segundo nombre</label>
                            <input type="text" name="second_name" id="second-name" class="form-control" onkeydown="return /[a-z]/i.test(event.key)" disabled>
                          </div>
                        </div>
                        <div class="col">
                          <!--apellidos-->
                          <div class="form-group">
                            <label for="first_lastname">Primer apellido</label>
                            <input type="text" name="first_lastname" id="first-lastname" class="form-control" onkeydown="return /[a-z]/i.test(event.key)" disabled>
                          </div>
                        </div>
                        <div class="col">
                          <!--apellidos-->
                          <div class="form-group">
                            <label for="second_lastname">Segundo apellido</label>
                            <input type="text" name="second_lastname" id="second-lastname" class="form-control" onkeydown="return /[a-z]/i.test(event.key)" disabled>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <!--alergias-->
                      <div class="form-group">
                        <label for="allergies">Alergias</label>
                        <textarea class="form-control" name="allergies" id="allergies" rows="2" disabled></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <!--examenes por hacer-->
                      <div class="form-group">
                        <label for="todo_tests">Exámenes por realizar</label>
                        <textarea class="form-control" name="todo_tests" id="todo-tests" rows="2" disabled></textarea>
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
                      <button type="button" id="update-file" class="btn btn-primary">Guardar exámenes</button>
                    </div>
                    <div class="col text-center">
                      {{ link_to('/menu', $title = 'Regresar', $attributes = ['class' => 'btn btn-success', 'role' => 'button'])}}
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
