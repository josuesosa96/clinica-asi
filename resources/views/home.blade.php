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
              <input type="text" class="form-control" placeholder="Buscar paciente">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Buscar</button>
              </div>
            </div>
          </div>
        </div>
        <!--Formulario-->
        <div class="row collapse" id="collapsable-form" style="margin-top: 20px;">
          <div class="col">
            <div class="row">
              <div class="col-md-6">
                <!--nombre-->
                <div class="form-group">
                  <input type="text" name="name" placeholder="Nombre Completo" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <!--edad-->
                <div class="form-group">
                  <input type="number" name="age" placeholder="Edad" min="1" max="100" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <!--direcion-->
                <div class="form-group">
                  <input type="text" name="address" placeholder="Dirección" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <!--numero telefono-->
                <div class="form-group">
                  <input type="text" name="phone_number" placeholder="Número de teléfono" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <!--alergias-->
                <div class="form-group">
                  <textarea class="form-control" name="allergies" placeholder="Alergias" rows="2"></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <select class="custom-select">
                    <option selected>Doctor General</option>
                    <option value="1">Doctor General1</option>
                    <option value="2">Doctor General2</option>
                    <option value="3">Doctor General3</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
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
