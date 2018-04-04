@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">List of Users</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                            <h3 class="text-center">Participants of {{config('app.name', 'Statistics')}} App!!</h3><br>

                            <div class="col-lg-12">
                        <table width="100%" class=" table table-responsive table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th>Surname</th>
                                <th>Other Name</th>
                                <th>Gender</th>
                                <th>Score(%)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->surname}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->sex}}</td>
                                <td>{{$user->scores?$user->scores->grade:0}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                            </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
