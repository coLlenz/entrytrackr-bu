@extends('layouts.app')
@section('content')
<div id="example1" class="list-group col">
    <div class="list-group-item">Item 1</div>
    <div class="list-group-item">Item 2</div>
    <div class="list-group-item">Item 3</div>
    <div class="list-group-item">Item 4</div>
    <div class="list-group-item">Item 5</div>
    <div class="list-group-item">Item 6</div>
</div>
<script type="text/javascript" src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    new Sortable(example1, {
        animation: 300,
        ghostClass: 'blue-background-class'
    });
</script>
@endsection
