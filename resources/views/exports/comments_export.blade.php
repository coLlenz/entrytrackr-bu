<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Comments</th>
       
    </tr>
    </thead>
    <tbody>
    @foreach($comment_list as $list)
        <tr>
           <td> {{ \Carbon\Carbon::parse($list->created_at)->timezone( userTz() )->format('d-m-Y H:i') }} </td>
           <td> {{ $list->comment }} </td>
        </tr>
    @endforeach
    </tbody>
</table>