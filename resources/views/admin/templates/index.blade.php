@extends('admin.layouts.admin')
@section('content')
<div class="mb-2">
    <h1>Templates</h1>
    <div class="top-right-button-container">
        <button type="button" class="btn btn-primary btn-lg top-right-button  mr-1" data-toggle="dropdown" aria-haspopup="true"
    aria-expanded="false">ADD NEW</button> 
    <div class="dropdown-menu dropdown-menu-right mt-3">
        <a class="dropdown-item" href="{{route('addView')}}">Notification</a>
        <a class="dropdown-item" href="{{route('questionView')}}">Questionnaire</a>
    </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table ">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Date Created</th>
                    <th>Date Last Updated</th>
                    <th class="text-center" >Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($templates))
                    @foreach ($templates as $template )
                    <tr>
                        <td>{{$template->title}}</td>
                        <td>{{$template->template_type == 1 ? 'Notification' : 'Questionnaire' }}</td>
                        <td>{{ \Carbon\Carbon::parse($template->created_at)->timezone( userTz() )->format('d-m-Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($template->updated_at)->timezone( userTz() )->format('d-m-Y H:i') }}</td>
                        
                        <td class="text-center">
                        <button class="btn btn-primary dropdown-toggle mb-1" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Actions
                        </button>
                        @if($template->template_type == 1)
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route("editNotif",$template->id)}}">Edit</a>
                            <a class="dropdown-item" href="{{route("templateRemove",$template->id)}}">Delete</a>
                        </div>
                        @else
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route("questionEditView",$template->id)}}">Edit</a>
                            <a class="dropdown-item" href="{{route("templateRemove",$template->id)}}">Delete</a>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <p class="text-center">{{ (empty($templates) ? 'No records found.' : '') }}</p>
    </div>
</div>
@endsection