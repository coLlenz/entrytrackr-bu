<html lang="en" dir="ltr">
<head>
    
</head>
    <body>
        <table cellspacing="1" cellpadding="1" align="center" border="1">
        <tr>
        <th>Name</th>
        <th>Telephone #</th>
        <th>Time of entry</th>
        <th>Time of exit</th>
        <th>Need Assistance</th>
        <th>Access</th>
        </tr>
            @foreach($data as $trakr)
                <tr>
                    <td>{{$trakr->firstName}} {{$trakr->lastName}}</td>
                    <td class="color-theme-1">{{$trakr->phoneNumber}}</td>
                    <td>{{ $trakr->check_in_date}}</td>
                    <td>{{ $trakr->check_out_date}}</td>
                    <td>{{ $trakr->assistance == 1 ? 'Yes' : 'No'  }}</td>
                    <td>{{ $trakr->status == 'accepted' ? 'Accepted' : 'Denied'  }}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>