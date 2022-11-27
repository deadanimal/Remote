<?php

namespace App\Http\Controllers;

use FurqanSiddiqui\BIP39\BIP39 as Mnemonic;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Chain;
use App\Models\Transfer;
use App\Models\Wallet;

// use Chain as BlockChain;
// use Transaction as BlockTransaction;
use Transfer as BlockchainTransfer;
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
        $mnemonic = Mnemonic::Generate(12);
        Wallet::where('user_id', $user->id)->update(['primary' => false]);
        $wallets = Wallet::where('user_id', $user->id)->get();
        Wallet::create([
            'name' => $user->name.' '.$wallets->count() + 1,
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
        if ($request->primary) {
            Wallet::where('user_id', $user->id)->update(['primary' => false]);
        }
        $wallet->name = $request->name;
        $wallet->primary = $request->primary;
        $wallet->save();
        return back();
    }

    public function wallet_delete(Request $request) {
        $user = $request->user();
        $id = (int)$request->route('id');
        $wallet = Wallet::where([
            ['id','=', $id],
            ['user_id','=', $user->id]
        ])->first();
        $wallet->delete();
        return back();
    }    

    public function chain_list(Request $request) {
        $user = $request->user();
        $chains = Chain::where('user_id', $user->id)->get();
        return view('chains',compact('chains'));
    }    

    public function chain_create(Request $request) {
        $user = $request->user();
        $wallet = Wallet::where([
            ['user_id','=',$user->id],
            ['primary','=',true],
        ])->first();
        Chain::where('user_id', $user->id)->update(['primary' => false]);
        Chain::create([
            'name' => $request->name,
            'rpc' => $request->rpc,
            'primary' => true,
            'user_id' => $user->id          
        ]);
        return back();
    }

    public function chain_detail(Request $request) {
        $user = $request->user();
        $id = (int)$request->route('id');
        $chain = Chain::where([
            ['id','=', $id],
            ['user_id','=', $user->id]            
        ])->first();
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

    public function chain_delete(Request $request) {
        $user = $request->user();
        $id = (int)$request->route('id');
        $chain = Chain::where([
            ['id','=', $id],
            ['user_id','=', $user->id]
        ])->first();
        $chain->delete();
        return back();
    }      

    public function transfer_list(Request $request) {
        $user = $request->user();    
        $transfers = collect();
        //$transfers = Transfer::where('user_id', $user->id)->get();
        $wallet = Wallet::where([
            ['user_id','=', $user->id],
            ['primary','=', true],
        ])->first();

        return view('transfers',compact('transfers','wallet'));
    }    

    public function transfer_create(Request $request) {
        $user = $request->user();
        $wallet = Wallet::where([
            ['user_id','=',$user->id],
            ['primary','=',true],
        ])->first();
        Transfer::create([
            'name' => $request->name,
            'rpc' => $request->rpc,
            'wallet_id' => $wallet->id,
            'user_id' => $user->id          
        ]);

        //$transfer = BlockchainTransfer::create([]);
        // $url = $transfer->rpc;
        // $signed_hash = $transfer->get_signed_hash();

        $url = $url.'/cosmos/tx/v1beta1/txs';

        $response = Http::post($url, [
            'tx_bytes' => $signed_hash,
            'mode' => 'BROADCAST_MODE_SYNC',
        ]);
        
        
        return back();
    }

    public function transfer_detail(Request $request) {
        $user = $request->user();
        $id = (int)$request->route('id');
        $transfer = transfer::findOrFail([
            ['id','=', $id],
            ['user_id','=', $user->id]            
        ])->first();
        return view('transfer.detail',compact('transfer'));
    }    


}
