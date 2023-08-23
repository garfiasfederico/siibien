@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">En Construcción</h1>    
@endsection

@section('content')
    <div class="row" style="width:100%;">     
        <table style="width: 100%">
            <tr>
                <td style="text-align:center;height:100%;">
                    <img  src="{{asset('/resources/images/construccion.jpg')}}"/>
                </td>
            </tr>            
        </table>   
            
    </div>
    <style>
        table tr:hover {
            background-color: rgb(242, 242, 242);
        }
    </style>
@endsection
