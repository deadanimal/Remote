<?php

namespace App\Http\Controllers;

use FurqanSiddiqui\BIP39\BIP39;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Chain;
use App\Models\Wallet;

class WalletController extends Controller
{

    public function wallet_list(Request $request) {
        $user = $request->user();
        $chains = Chain::where('user_id', $user->id)->get();
        $wallets = Wallet::where('user_id', $user->id)->get();        
        return view('wallets',compact('chains','wallets'));
    }

    public function wallet_create(Request $request) {
        $user = $request->user();
        $mnemonic = BIP39::Generate(12);
        $wallets = Wallet::where('user_id', $user->id)->get();
        foreach($wallets as $wallet) {
            $wallet->primary = false;
            $wallet->save();
        }
        Wallet::create([
            'name' => $user->name.' '.$wallets->count(),
            'mnemonic' => implode(" ", $mnemonic->words),
            'user_id' => $user->id          
        ]);
        return back();
    }

    public function wallet_detail(Request $request) {
        $user = $request->user();
        $id = (int)$request->route('id');
        $wallet = Wallet::where([
            ['id','=', $id],
            ['user_id','=', $user->id]
        ])->first();
        return view('wallet',compact('wallet'));
    }

    public function wallet_update(Request $request) {
        $user = $request->user();
        $id = (int)$request->route('id');
        $wallet = Wallet::where([
            ['id','=', $id],
            ['user_id','=', $user->id]
        ])->first();
        $wallet->name = $request->name;
        $wallet->primary = $request->primary;
        $wallet->save();
        return back();
    }

    public function chain_create(Request $request) {
        $user = $request->user();
        $wallet = Wallet::where([
            ['user_id','=',$user->id],
            ['primary','=',true],
        ])->first();
        Chain::create([
            'name' => $request->name,
            'rpc' => $request->rpc,
            'wallet_id' => $wallet->id,
            'user_id' => $user->id          
        ]);
        return back();
    }

    public function chain_detail(Request $request) {
        $user = $request->user();
        $id = (int)$request->route('id');
        $chain = Chain::findOrFail($id);
        return view('chain.detail',compact('chain'));
    }

    public function chain_update(Request $request) {
        $user = $request->user();
        $id = (int)$request->route('id');
        $chain = Chain::where([
            ['id','=', $id],
            ['user_id','=', $user->id]
        ])->first();
        $chain->name = $request->name;
        $chain->rpc = $request->rpc;
        $chain->save();
        return back();
    }    

    public function transfer(Request $request) {
        $url = 'localhost:1317'.'/cosmos/tx/v1beta1/txs';

        $response = Http::post($url, [
            //'tx_bytes' => 'txBytes',
            'tx_bytes' => $request->txBytes,
            'mode' => 'BROADCAST_MODE_SYNC',
        ]);

    }


}
