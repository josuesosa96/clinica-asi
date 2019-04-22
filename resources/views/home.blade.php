@extends('layouts.app')

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
        <!--Busqueda-->
        <div class="row">
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
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" name="test" placeholder="test" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" name="test" placeholder="test2" class="form-control">
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col"></div>
          <div class="col-md-8">
            <div class="form-group text-center">
              <button type="submit" class="btn btn-primary">Guardar expediente</button>
            </div>
          </div>
          <div class="col"></div>
        </div>


      </div>
      <div class="col"></div>
    </div>
  </div>
@endsection
