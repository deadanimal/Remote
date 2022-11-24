@extends('layouts.app')

@section('content')

<h3>Wallet</h3>
<ul>
    @foreach($wallets as $wallet)
        <li>{{$wallet->name}} {{$wallet->primary}}</li>
    @endforeach
</ul>

<h3>Chain</h3>
<ul>
    @foreach($chains as $chain)
        <li>{{$chain->name}} {{$chain->rpc}}</li>
    @endforeach
</ul>

<form action='/wallet' method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">Create</button>
</form>


<form action='/chain' method="POST">
    @csrf
    <input class="form-control" name="name">
    <input class="form-control" name="rpc">
    <button type="submit" class="btn btn-primary">Create</button>
</form>


<form>
    <input class="form-control" placeholder="receiver" name="receiver">
    <input class="form-control" placeholder="amount" name="amount">
    <button type="button" class="btn btn-primary">Send</button>
</form>
@endsection
