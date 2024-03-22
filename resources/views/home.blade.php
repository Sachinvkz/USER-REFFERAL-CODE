@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}<br><br>
                    Refferal Code : <span class="text-primary">{{$reff_code}}</span><br>

                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Level</th>
                        <th scope="col">Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($points as $pointval)
                        <tr>
                        <th>Level {{$loop->iteration}}</th>
                        <td>{{$pointval->current_point}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
