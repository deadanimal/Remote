@extends('layouts.app')

@section('content')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <div class="row my-3">
        <div class="col-xl-3">
            <h3>Wallet
                <form>
                    <input class="form-control" type="string" id="pinCode">
                </form>
                <button type="button" class="btn btn-primary" onclick="generateWalletClicked()">Create</button>
                <button type="button" class="btn btn-primary" onclick="show()">Show</button>

                <form>
                    <input class="form-control" type="string" id="recipient" placeholder="recipient">
                    <input class="form-control" type="string" id="recipientAmount" placeholder="recipientAmount">
                </form>
                <button type="button" class="btn btn-primary" onclick="sendTokenClicked()">Send</button>
            </h3>
        </div>
        <div class="col-xl-9">
            <ul>
                @foreach ($wallets as $wallet)
                    <li>{{ $wallet->name }} {{ $wallet->primary }} <a href="/wallet/{{ $wallet->id }}">View</a></li>
                @endforeach
            </ul>

            <table id="table" class="table">
                <thead>
                    <tr>
                        <th data-field="address">address</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script src="/js/app.js"></script>
    <script>
        function generateWalletClicked() {
            var pinCode = document.getElementById("pinCode").value;
            window.generateWallet(pinCode);
        }

        function sendTokenClicked() {
            window.sendToken();
        }        

        function show() {
            var wallets = JSON.parse(localStorage.getItem('wallets'))
            var table = document.getElementById("table");
            for (var i = 0; i < wallets.length; i++) {
                var row = table.insertRow(-1);
                var cell1 = row.insertCell(0);
                cell1.innerHTML = wallets[i];
            }

        }

        show();
    </script>
@endsection
