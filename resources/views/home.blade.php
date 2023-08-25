@extends('layout')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col m-5 w-50">
                <h1 class="lead">Select Car</h1>
                <div class="mb-3">
                    <select class="form-select form-select-lg mb-3" id="make">
                        <option selected disabled>Select Make</option>
                        @foreach ($makes as $make)
                        <option value="{{ $make->id_car_make }}">{{ $make->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-select form-select-lg mb-3" id="model">
                        <option selected disabled>Select Model</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-select form-select-lg mb-3" id="generation">
                        <option selected disabled>Select Generation</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-select form-select-lg mb-3" id="serie">
                        <option selected disabled>Select Series</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-select form-select-lg mb-3" id="trim">
                        <option selected disabled>Select Trim</option>
                    </select>
                </div>
                {{-- <div class="mb-3">
                    <select class="form-select form-select-lg mb-3" id="equipment">
                        <option selected disabled>Select Equipment</option>
                    </select>
                </div> --}}
            </div>
            <div  class="col m-5 w-50">
                <h2 class="lead" id="1">Chassis</h2>
                <ul class="list-group mb-3 specs" id="specs1">
                    <li class="list-group-item"></li>
                </ul>
                
                <h2 class="lead" id="11">Engine</h2>
                <ul class="list-group mb-3 specs" id="specs11">
                    <li class="list-group-item"></li>
                </ul>

            </div>
            <div  class="col m-5 w-50">
                <h2 class="lead" id="23">Gearbox and Handling</h2>
                <ul class="list-group mb-3 specs" id="specs23">
                    <li class="list-group-item"></li>
                </ul>
                
                <h2 class="lead" id="31">Operating Characteristics</h2>
                <ul class="list-group mb-3 specs" id="specs31">
                    <li class="list-group-item"></li>
                </ul>

                <h2 class="lead" id="40">Suspension and Brakes</h2>
                <ul class="list-group mb-3 specs" id="specs40">
                    <li class="list-group-item"></li>
                </ul>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#make').on('change', function () {
                var makeId = this.value;
                $('#model').html('');
                $.ajax({
                    url: '{{ route('getModels') }}?id_car_make='+makeId,
                    type: 'get',
                    success: function (res) {
                        $('#model').html('<option selected disabled value="">Select Model</option>');
                        $.each(res, function (key, value) {
                            $('#model').append('<option value="' + value
                                .id_car_model + '">' + value.name + '</option>');
                        });
                        $('#generation').html('<option selected disabled value="">Select Generation</option>');
                        $('#serie').html('<option selected disabled value="">Select Series</option>');
                        $('#trim').html('<option selected disabled value="">Select Trim</option>');
                        //$('#equipment').html('<option selected disabled value="">Select Equipment</option>');
                        $('.specs').html('<li class="list-group-item"></li>');
                    }
                });
            });
            $('#model').on('change', function () {
                var modelId = this.value;
                $('#generation').html('');
                $.ajax({
                    url: '{{ route('getGenerations') }}?id_car_model='+modelId,
                    type: 'get',
                    success: function (res) {
                        $('#generation').html('<option selected disabled value="">Select Generation</option>');
                        $.each(res, function (key, value) {
                            //only show year if not null in database
                            $('#generation').append('<option value="' + value.id_car_generation + '">' + value.name + (value.year_begin ? ' (' + value.year_begin + '-' + (value.year_end || 'Present') + ')' : '') + '</option>');
                        });
                        $('#serie').html('<option selected disabled value="">Select Series</option>');
                        $('#trim').html('<option selected disabled value="">Select Trim</option>');
                        //$('#equipment').html('<option selected disabled value="">Select Equipment</option>');
                        $('.specs').html('<li class="list-group-item"></li>');
                    }

                });
            });
            $('#generation').on('change', function () {
                var generationId = this.value;
                $('#serie').html('');
                $.ajax({
                    url: '{{ route('getSeries') }}?id_car_generation='+generationId,
                    type: 'get',
                    success: function (res) {
                        $('#serie').html('<option selected disabled value="">Select Series</option>');
                        $.each(res, function (key, value) {
                            $('#serie').append('<option value="' + value.id_car_serie + '">' + value.name + '</option>');
                        });
                        $('#trim').html('<option selected disabled value="">Select Trim</option>');
                        //$('#equipment').html('<option selected disabled value="">Select Equipment</option>');
                        $('.specs').html('<li class="list-group-item"></li>');
                    }
                });
            });
            $('#serie').on('change', function () {
                var serieId = this.value;
                $('#trim').html('');
                $.ajax({
                    url: '{{ route('getTrims') }}?id_car_serie='+serieId,
                    type: 'get',
                    success: function (res) {
                        $('#trim').html('<option selected disabled value="">Select Trim</option>');
                        $.each(res, function (key, value) {
                            $('#trim').append('<option value="' + value.id_car_trim + '">' + value.name + '</option>');
                        });
                        //$('#equipment').html('<option selected disabled value="">Select Equipment</option>');
                        $('.specs').html('<li class="list-group-item"></li>');
                    }
                });
            });
            
            // Specifications
            // When trim is changed, query  for new car specifications
            $('#trim').on('change', function () {
                var trimId = this.value;
                $('.specs').html('');
                $.ajax({
                    url: '{{ route('getSpecs') }}?id_car_trim='+trimId,
                    type: 'get',
                    success: function (res) {
                        //console.log(res);
                        $.each(res, function (key, value) {
                            if (value.isTitle) {
                                //$('#' + value.id).append('<h2 class="lead">' + value.name + '</h2>');
                            }
                            else {
                                $('#specs' + value.parent_id).append('<li class="list-group-item">' + value.name + ': ' + value.value + ' ' + value.unit + '</li>');
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
@endsection