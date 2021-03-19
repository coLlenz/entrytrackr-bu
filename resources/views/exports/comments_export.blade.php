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
           <td> {{ $list->created_at }} </td>
           <td> {{ $list->comment }} </td>
        </tr>
    @endforeach
    </tbody>
</table>