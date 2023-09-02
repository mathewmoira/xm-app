@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container">
    <form action="{{ route('get-historical-data') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="companySymbol">Company Symbol</label>
            <select class="form-control" id="companySymbol" name="companySymbol" required>
                <!-- Populate options dynamically from JSON data source -->
                @foreach ($companySymbols as $symbol)
                    <option value="{{ $symbol }}">{{ $symbol }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="startDate">Start Date (YYYY-mm-dd)</label>
            <input type="text" class="form-control" id="startDate" name="startDate" required>
        </div>
        <div class="form-group">
            <label for="endDate">End Date (YYYY-mm-dd)</label>
            <input type="text" class="form-control" id="endDate" name="endDate" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>

    </form>
    <script>
        $(function() {
            $("#startDate, #endDate").datepicker({
                dateFormat: 'yy-mm-dd', // Set date format to YYYY-mm-dd
                maxDate: '0', // Disable future dates
            });
        });
    </script>

</div>

@endsection