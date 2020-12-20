<html lang="en" dir="ltr">
<head>
    
</head>
    <body>
        <table cellspacing="1" cellpadding="1" align="center" border="1">
        <tr>
        <th>Created At</th>
        <th>Name</th>
        <th>Visitor Type</th>
        <th>Safe</th>
        <th>Date Marked Safe</th>
        </tr>
            @foreach($trakrs as $trakr)
                <tr>
                    <td>{{$trakr->created_at}}</td>
                    <td>{{$trakr->firstName}} {{$trakr->lastName}}</td>
                    <td class="color-theme-1">{{$trakr->type}}</td>
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
                    <td class="text-center safe_date{{$trakr->id}}">{{$trakr->date_marked_safe ? $trakr->date_marked_safe : 'No records yet'}}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>