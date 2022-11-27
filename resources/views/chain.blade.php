@extends('layouts.app')

@section('content')


<h3>Chain</h3>
<ul>
    @foreach($chains as $chain)
        <li>{{$chain->name}} {{$chain->rpc}}</li>
    @endforeach
</ul>



<form action='/chain' method="POST">
    @csrf
    <input class="form-control" name="name">
    <input class="form-control" name="rpc">
    <button type="submit" class="btn btn-primary">Create</button>
</form>


@endsection
