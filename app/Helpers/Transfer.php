<?php // Code within app\Helpers\Chain.php

namespace App\Helpers;

class Transfer {

    public $privkey;
    public $account_num;
    public $sequence;
    public $fee;
    public $fee_denom = 'uatom';
    public $gas;
    public $memo = '';
    public $chain_id;
    public $hrp = 'DEFAULT_BECH32_HRP';
    public $sync_mode = "sync";
    public $msgs = array();


    // privkey: bytes,
    // account_num: int,
    // sequence: int,
    // fee: int,
    // gas: int,
    // chain_id: str = "cosmoshub-4",
    // hrp: str = DEFAULT_BECH32_HRP,
    // sync_mode: SyncMode = "sync",

    function __construct($name) {
        $this->name = $name;
    }    
    public function shout()
    {
        //dd('OK');
    }

    public function add_transfer($sender, $recipient, $amount, $denom = 'uatom') {

        $transfer = array(
            'type' => "cosmos-sdk/MsgSend",
            'value' => array(
                'from_address' => $sender,
                'to_address' => $recipient,
                'amount' => [array('denom'=> $denom, 'amount'=> $amount)]
            )
        );
        $this->msgs = array_push($transfer);
    }

    public function get_pushable() {}

    private function _sign() {}

    private function _get_signed_message() {}
}


// def get_pushable(self) -> str:
// pubkey = privkey_to_pubkey(self._privkey)
// base64_pubkey = base64.b64encode(pubkey).decode("utf-8")
// pushable_tx = {
//     "tx": {
//         "msg": self._msgs,
//         "fee": {
//             "gas": str(self._gas),
//             "amount": [{"denom": self._fee_denom, "amount": str(self._fee)}],
//         },
//         "memo": self._memo,
//         "signatures": [
//             {
//                 "signature": self._sign(),
//                 "pub_key": {"type": "tendermint/PubKeySecp256k1", "value": base64_pubkey},
//                 "account_number": str(self._account_num),
//                 "sequence": str(self._sequence),
//             }
//         ],
//     },
//     "mode": self._sync_mode,
// }
// return json.dumps(pushable_tx, separators=(",", ":"))

// def _sign(self) -> str:
// message_str = json.dumps(self._get_sign_message(), separators=(",", ":"), sort_keys=True)
// message_bytes = message_str.encode("utf-8")

// privkey = ecdsa.SigningKey.from_string(self._privkey, curve=ecdsa.SECP256k1)
// signature_compact = privkey.sign_deterministic(
//     message_bytes, hashfunc=hashlib.sha256, sigencode=ecdsa.util.sigencode_string_canonize
// )

// signature_base64_str = base64.b64encode(signature_compact).decode("utf-8")
// return signature_base64_str

// def _get_sign_message(self) -> dict[str, Any]:
// return {
//     "chain_id": self._chain_id,
//     "account_number": str(self._account_num),
//     "fee": {
//         "gas": str(self._gas),
//         "amount": [{"amount": str(self._fee), "denom": self._fee_denom}],
//     },
//     "memo": self._memo,
//     "sequence": str(self._sequence),
//     "msgs": self._msgs,
// }