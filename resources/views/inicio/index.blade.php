@extends('layout.admin')
@section('titulo')
<title>Inicio</title>
@endsection

@section('styles')
@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder fs-1">{{$data->nombre_rol}}</h1>
@endsection


@section('content')



@endsection
@push('scripts')     
<script type="text/javascript">
$(document).ready(function() {
    $('#navInicio').addClass('active');
});
</script>
@endpush
