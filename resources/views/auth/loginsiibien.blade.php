@extends('layouts.login')

@section('content')
<img src="{{asset('images/col_gabinete.svg')}}" alt="" width="200" style="float:right">
<x-auth-session-status class="mb-4" :status="session('status')" />
<div style="width: 500px;background-color:white;border:solid 1px rgb(225, 225, 225);padding:15px">
<form method="POST" action="{{ route('login') }}" autocomplete="off" novalidate>
  @csrf

  <div class="text-center mb-4">
    <img src="{{asset('images/siibien_colores.png')}}" alt="" width=400">

    <!--<h1 class="h3 mb-3 font-weight-normal">Acceso a SISSED</h1>        -->
  </div>
  <!-- cuenta Address -->
  <div>
      <x-input-label for="cuenta" :value="__('Cuenta')" />
      <x-text-input id="cuenta" class="form-control" type="text" name="cuenta" :value="old('cuenta')" required autofocus />
      <x-input-error :messages="$errors->get('cuenta')" class="alert alert-warning" />
  </div>

  <!-- Password -->
  <div class="mt-4">
      <x-input-label for="password" :value="__('Contraseña')" />
      <x-text-input id="password" class="form-control"
                      type="password"
                      name="password"
                      required />
      <br/>
      <x-input-label for="mod" :value="__('Módulo')" />
        <select name="mod" id="mod" class="form-control">
            <option value="info">Informes</option>
            <option value="segui">Seguimiento</option>
        </select>
      <br>
      <input type="checkbox" id="showpass" onclick="showPass()"/> Mostrar Contraseña
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
  </div>

  <div class="flex items-center justify-end mt-4">
    <button class="btn btn-lg btn-primary btn-block" style="background-color:rgb(104,27,46)" type="submit">Ingresar</button>
  </div>
  @if (session('error'))
  <div class="alert alert-danger">
      {{ session('error') }}
  </div>
@endif
</form>
</div>
@endsection

@section('script')
<script>
  function showPass(){
    if($("#showpass").prop('checked')){
      $("#password").prop('type','text');
    }else{
      $("#password").prop('type','password');
    }
  }
  </script>
@endsection
