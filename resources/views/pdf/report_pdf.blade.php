<html lang="en" dir="ltr">
<head>
    
</head>
    <body>
        <center>
            <h3>Visitor Entry & Exit Log:</h3>
            <h3>  {{ auth()->user()->name }} </h3>
            <h3>Created: {{ date('d-m-Y H:i:s') }}</h3>
        </center>
        <table cellspacing="1" cellpadding="1" align="center" border="1">
        <tr>
        <th>Visitor Name</th>
        <th>Telephone</th>
        <th>Date & Time of Entry</th>
        <th>Date & Time of Exit</th>
        <th>Visitor Type</th>
        <th>Assistance Required</th>
        <th>Access</th>
        <th>Visiting/Business</th>
        <th>Area(s) Accessed</th>
        </tr>
            @foreach($data as $trakr)
                <tr>
                    <td>{{$trakr->firstName}} {{$trakr->lastName}}</td>
                    <td class="color-theme-1">{{$trakr->phoneNumber}}</td>
                    <td>{{ \Carbon\Carbon::parse($trakr->check_in_date)->format('d-m-y H:i') }}</td>
                    <td>{{ $trakr->check_out_date ? \Carbon\Carbon::parse($trakr->check_out_date)->format('d-m-y H:i') : 'Pending'}}</td>
                    <td>{{ $trakr->visitor_type}}</td>
                    <td>{{ $trakr->assistance == 1 ? 'Yes' : 'No'  }}</td>
                    <td>{{ $trakr->status == 'accepted' ? 'Allowed' : 'Denied'  }}</td>
                    <td>
                        @if($trakr->trakr_type_id == 1)
                            {{ $trakr->who }}
                        @elseif($trakr->trakr_type_id == 2 )
                            {{ $trakr->name_of_company }}
                        @endif
                    </td>
                    <td> {{ $trakr->area_access }} </td>
                </tr>
            @endforeach
        </table>
    </body>
</html>