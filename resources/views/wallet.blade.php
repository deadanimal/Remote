@extends('layouts.app')

@section('content')

{{$wallet}}
<h3>Wallet
    <form action='/wallet/{{$wallet->id}}' method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name">
        <input type="hidden" name="primary" value=1>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>    
</h3>
<ul>

</ul>

@endsection
