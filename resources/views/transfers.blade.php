@extends('layouts.app')

@section('content')
    <div class="row my-3">
        <div class="col-xl-3">
            <h3>Send Coin</h3>
            <form>
                <input class="form-control" placeholder="receiver" name="receiver">
                <input class="form-control" placeholder="amount" name="amount">
                <button type="button" class="btn btn-primary">Send</button>
            </form>
        </div>
        <div class="col-xl-9">
            {{ $wallet->name }}
            <ul>
                @foreach ($transfers as $transfer)
                    <li>{{ $transfer->id }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
