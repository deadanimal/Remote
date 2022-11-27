@extends('layouts.app')

@section('content')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <div class="row my-3">
        <div class="col-xl-3">
            <h3>Wallet
                <form>
                    <input class="form-control" type="string" id="pinCode" placeholder="PIN">
                    <textarea class="form-control" id="mnemonic" placeholder="Mnemonic"></textarea>
                </form>
                <button type="button" class="btn btn-primary" onclick="generateWalletClicked()">Create Wallet</button>
                <button type="button" class="btn btn-primary" onclick="importWalletClicked()">Import Wallet</button>
                {{-- <button type="button" class="btn btn-primary" onclick="show()">Show</button> --}}
                <button type="button" class="btn btn-primary" onclick="loadBalanceClicked()">Load Balance</button>

                <form>
                    <input class="form-control" type="string" id="recipientAddress" placeholder="recipientAddress">
                    <input class="form-control" type="number" id="recipientAmount" placeholder="recipientAmount">
                    <input class="form-control" type="string" id="transferMemo" placeholder="transferMemo">
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
                        <th>Address</th>
                        <th>Balance</th>
                        <th>-</th>

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
            loadTable();
        }

        function importWalletClicked() {
            var pinCode = document.getElementById("pinCode").value;
            var mnemonic = document.getElementById("mnemonic").value;
            window.importWallet(pinCode, mnemonic);
            loadTable();
        }        

        function sendTokenClicked() {
            var pinCode = document.getElementById("pinCode").value;
            var recipientAddress = document.getElementById("recipientAddress").value;
            var recipientAmount = document.getElementById("recipientAmount").value;
            var memo = document.getElementById("transferMemo").value;
            window.sendToken(pinCode, recipientAddress, recipientAmount, "1", memo);

            // setTimeout(()=> {
            //     loadTable();
            // }, 2000);
        }

        function defaultWalletClicked(index) {
            var pinCode = document.getElementById("pinCode").value;
            window.defaultWallet(pinCode, index);
            loadTable();
        }

        function loadBalanceClicked() {

            var pinCode = document.getElementById("pinCode").value;
            window.balanceOfWallet(pinCode);
            loadTable();
        }

        function loadTable() {
            var table = document.getElementById("table");
            while (table.rows.length > 1) {
                table.deleteRow(0);
            }
            var wallets = JSON.parse(localStorage.getItem('wallets'))
            var balances = JSON.parse(localStorage.getItem('wallet_balances'))
            for (var i = 0; i < wallets.length; i++) {
                var row = table.insertRow(-1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(-1);
                var cell3 = row.insertCell(-1);
                cell1.innerHTML = wallets[i];
                cell2.innerHTML = (parseInt(balances[i]) / Math.pow(10,6)).toFixed(3);
                cell3.innerHTML = '<button class="btn btn-primary" onclick="defaultWalletClicked(' + i + ')">Default</button>';
            }

        }

        loadBalanceClicked();
    </script>
@endsection
