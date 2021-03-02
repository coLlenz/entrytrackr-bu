<table>
    <thead>
    <tr>
        <th>Visitor Name</th>
        <th>Phone Number</th>
        <th>Date and Time of Entry</th>
        <th>Date and Time of Exit</th>
        <th>Visitor Type</th>
        <th>Assistance Required</th>
        <th>Access</th>
        <th>Visiting/Business</th>
    </tr>
    </thead>
    <tbody>
    @foreach($report_list as $list)
        <tr>
            <td>{{ $list->firstName }} {{ $list->lastName }}</td>
            <td>{{ $list->phoneNumber }}</td>
            <td>{{ $list->check_in_date }}</td>
            <td>{{ $list->check_out_date }}</td>
            <td>{{ $list->visitor_type }}</td>
            <td>{{ $list->assistance == 0 ? 'No' : 'Yes' }}</td>
            <td>{{ $list->status == 0 ? 'Allowed' : 'Denied' }}</td>
            <td>{{ $list->who ? $list->who : $list->name_of_company }}</td>
        </tr>
    @endforeach
    </tbody>
</table>