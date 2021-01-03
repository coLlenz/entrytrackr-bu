<html lang="en" dir="ltr">
<head>
    
</head>
    <body>
        <center>
            <h3>Evacuation List: {{ auth()->user()->name }}</h3>
            <h3>Created: {{ date('d-m-Y H:i:s') }}</h3>
        </center>
        <table cellspacing="1" cellpadding="1" align="center" border="1">
        <tr>
        <th>Sign In Date & Time</th>
        <th>Visitor Name</th>
        <th>Visitor Type</th>
        <th>Assistance Required</th>
        <th>Safe</th>
        <th>Date & Time Marked as Safe</th>
        </tr>
            @foreach($trakrs as $trakr)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trakr->created_at)->format('d-m-Y') }}</td>
                    <td>{{$trakr->firstName}} {{$trakr->lastName}}</td>
                    <td class="color-theme-1">{{$trakr->type}}</td>
                    <td class="color-theme-1">{{$trakr->assistance == 0 ? 'No' : 'Yes'}}</td>
                    <td>
                        <div class="custom-switch custom-switch-primary-inverse mb-2 custom-switch-small">
                            @if($trakr->safe == 'safe')
                                <input checked disabled  type="checkbox" class="custom-control-input" id="switch{{$trakr->id}}" onclick="checkbox({{$trakr->id}})" >
                            @else
                                <input type="checkbox" class="custom-control-input" id="switch{{$trakr->id}}" onclick="checkbox({{$trakr->id}})">
                            @endif
                            <label class="custom-control-label" for="switch{{$trakr->id}}">{{''}}</label>
                        </div>
                    </td>
                    <td class="text-center safe_date{{$trakr->id}}">{{$trakr->date_marked_safe ? $trakr->date_marked_safe : 'Pending'}}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>