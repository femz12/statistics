@extends('layouts.app')

@section('content')
<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3 class="text-center">Welcome to {{config('app.name', 'Statistics')}} App!!</h3><br>
                        <h4>Instructions</h4>
                   <ul>
                       <li>You have to read the questions carefully before answering, make sure you select the correct answer</li>
                       <li>You are to answer only 15 questions in 10minutes</li>
                       <li>You cannot must not refresh your browser or click the back button during the test</li>
                       <li>Note that time is part of the competition, immediately your're done with the test, click the <b>SUBMIT</b> button</li>
                   </ul>
                        <center><a class="btn btn-default btn-lg" href="{{asset('quiz/start')}}">Start Quiz</a></center>
                        <br>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
