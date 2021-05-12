@extends('admin.layouts.admin')
@section('content')
<div class="mb-2">
    <h1>User Accounts</h1>
    <div class="top-right-button-container">
        <button type="button" class="btn btn-primary btn-lg top-right-button  mr-1"
    onclick="window.location.href='{{route("admin-new-clients")}}'">ADD NEW</button>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Profile</th>
                    <th>Account Name</th>
                    <th>Contact Name</th>
                    <th>Email</th>
                    <th>Timezone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key=>$user)
                    <tr>
                        <td>{{$key+1}}</td>
                        @if ($user->profile_path)
                            <td><img src= "{{ $user->profile_path }}" alt="" style="height: 40px; width: 45px;"></td>
                        @else
                            <td><img src= "https://qrlogins.s3-ap-southeast-2.amazonaws.com/img/imgplaceholder.png" alt="" style="height: 40px; width: 45px;"></td>
                        @endif
                            <td>{{$user->name}}</td>
                            <td>{{$user->contactName}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->timezone}}</td>
                            <td>
                                <button class="btn btn-primary dropdown-toggle mb-1" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route("admin-edit-client",$user->id)}}">Edit</a>
                                    <a class="dropdown-item" href="{{route("removeClient",$user->id)}}">Delete</a>
                                    <a class="dropdown-item" href="{{route("uploadImageView",$user->id)}}">Upload Logo</a>
                                </div>
                            </td>
                    </tr>
                @endforeach
            </div>
            </tbody>
        </table>
        {{$users->onEachSide(1)->links()}}
    </div>
</div>
@endsection

