@extends('layouts.app')

@section('content')
    <div class="row my-3">
        <div class="col-xl-3">

            <form action='/chain' method="POST">
                @csrf
                <input class="form-control" name="name">
                <input class="form-control" name="rpc">
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
        <div class="col-xl-9">
            <h3>Chain</h3>
            <ul>
                @foreach ($chains as $chain)
                    <li>{{ $chain->name }} {{ $chain->rpc }} {{ $chain->primary }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
