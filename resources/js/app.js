import { DirectSecp256k1HdWallet } from "@cosmjs/proto-signing";
import { assertIsBroadcastTxSuccess, SigningStargateClient, StargateClient } from "@cosmjs/stargate";
import * as bip39 from '@scure/bip39';
import { wordlist } from '@scure/bip39/wordlists/english';
import { stringToPath } from "@cosmjs/crypto";

var CryptoJS = require("crypto-js");
var textEncoding = require('text-encoding');  
var TextDecoder = textEncoding.TextDecoder;

var _wallets = [];

window.generateWallet = async function generateWallet(pinCode) {    

    const mnemonic = bip39.generateMnemonic(wordlist);    
    var defaultWalletCipher = CryptoJS.AES.encrypt(mnemonic, pinCode).toString();    
    
    var walletsEncrypted = localStorage.getItem('wallet_mnemonics');
    if (localStorage.getItem('wallet_mnemonics') != null) {
        var bytes  = CryptoJS.AES.decrypt(walletsEncrypted, pinCode);
        var walletsStringified = bytes.toString(CryptoJS.enc.Utf8); 
        var wallets = JSON.parse(walletsStringified);   
        if(wallets.length > 20) {
            console.log('KO');
            return;
        }               
    } else {
        var wallets = []
    }

    wallets.push(mnemonic);
    _wallets = [];
    for (let i = 0; i < wallets.length; i++) {
        var wallet = await DirectSecp256k1HdWallet.fromMnemonic(wallets[i]);    
        const [firstAccount] = await wallet.getAccounts();
        _wallets.push(firstAccount.address)    
        
    }      
    localStorage.setItem('wallets', JSON.stringify(_wallets));    
    wallets = JSON.stringify(wallets);
    var ciphertext = CryptoJS.AES.encrypt(wallets, pinCode).toString();

    localStorage.setItem('wallet_mnemonics', ciphertext);  
    localStorage.setItem('default_wallet_mnemonic', defaultWalletCipher);  

    var defaultWallet = await DirectSecp256k1HdWallet.fromMnemonic(mnemonic);    
    const [defaultAccount] = await defaultWallet.getAccounts();    
    localStorage.setItem('default_wallet', defaultAccount.address);    
}

window.importWallet = async function importWallet(pinCode, mnemonic) {
    var defaultWallet = await DirectSecp256k1HdWallet.fromMnemonic(mnemonic);        
    const [defaultAccount] = await defaultWallet.getAccounts();    
    localStorage.setItem('default_wallet', defaultAccount.address);        
    var defaultWalletCipher = CryptoJS.AES.encrypt(mnemonic, pinCode).toString();    
    
    var walletsEncrypted = localStorage.getItem('wallet_mnemonics');
    if (localStorage.getItem('wallet_mnemonics') != null) {
        var bytes  = CryptoJS.AES.decrypt(walletsEncrypted, pinCode);
        var walletsStringified = bytes.toString(CryptoJS.enc.Utf8); 
        var wallets = JSON.parse(walletsStringified);          
        if(wallets.length > 20) {
            console.log('KO');
            return;
        }          
    } else {
        var wallets = []
    }

    wallets.push(mnemonic);
    _wallets = [];
    for (let i = 0; i < wallets.length; i++) {
        var walletOne = await DirectSecp256k1HdWallet.fromMnemonic(wallets[i]);       
        const [firstAccount] = await walletOne.getAccounts();
        _wallets.push(firstAccount.address)
    }       
    wallets = JSON.stringify(wallets);
    localStorage.setItem('wallets', JSON.stringify(_wallets));    
    var ciphertext = CryptoJS.AES.encrypt(wallets, pinCode).toString();
    localStorage.setItem('wallet_mnemonics', ciphertext);   
    localStorage.setItem('default_wallet_mnemonic', defaultWalletCipher);     
}

window.defaultWallet = async function defaultWallet(pinCode, index) {
    var walletsEncrypted = localStorage.getItem('wallet_mnemonics');
    var bytes  = CryptoJS.AES.decrypt(walletsEncrypted, pinCode);
    var walletsStringified = bytes.toString(CryptoJS.enc.Utf8); 
    var wallets = JSON.parse(walletsStringified);      
    var mnemonic = wallets[index];    
    var ciphertext = CryptoJS.AES.encrypt(mnemonic, pinCode).toString();
    localStorage.setItem('default_wallet_mnemonic', ciphertext);      
    var defaultWallet = await DirectSecp256k1HdWallet.fromMnemonic(mnemonic);    
    const [defaultAccount] = await defaultWallet.getAccounts();    
    localStorage.setItem('default_wallet', defaultAccount.address);        
}

window.showMnemonic = async function showMnemonic(pinCode, index) {
    var walletsEncrypted = localStorage.getItem('wallet_mnemonics');
    var bytes  = CryptoJS.AES.decrypt(walletsEncrypted, pinCode);
    var walletsStringified = bytes.toString(CryptoJS.enc.Utf8); 
    var wallets = JSON.parse(walletsStringified);      
    var mnemonic = wallets[index];    
    return mnemonic;
}

window.balanceOfWallet = async function balanceOfWallet(pinCode, rpcEndpoint) {
    var ciphertext = localStorage.getItem('default_wallet_mnemonic');
    var bytes  = CryptoJS.AES.decrypt(ciphertext, pinCode);
    var originalText = bytes.toString(CryptoJS.enc.Utf8);    
    const wallet = await DirectSecp256k1HdWallet.fromMnemonic(originalText);    
    const client = await StargateClient.connect(rpcEndpoint)
    const [firstAccount] = await wallet.getAccounts();
    const [balances] = await client.getAllBalances(firstAccount.address);
    return balances;

}

window.sendToken = async function sendToken(pinCode, recipient, amount, fee) {
    var ciphertext = localStorage.getItem('default_wallet');
    var bytes  = CryptoJS.AES.decrypt(ciphertext, pinCode);
    var originalText = bytes.toString(CryptoJS.enc.Utf8);    
    const wallet = await DirectSecp256k1HdWallet.fromMnemonic(originalText);    
    const [firstAccount] = await wallet.getAccounts();
    console.log(firstAccount.address);    

    const client = await SigningStargateClient.connectWithSigner("rpc.atomicmoney.org", wallet);
    const before = await client.getBalance(firstAccount.address, "udollar");
    console.log(before);

    const result = await client.sendTokens(
        firstAccount.address,
        recipient,
        [{ denom: "udollar", amount: amount }],
        {
            amount: [{ denom: "udollar", amount: fee }],
            gas: "100000",
        },
    )   
    console.log(result) 
}

window.signMessage =  async function signMessage(pinCode, message) {
    var ciphertext = localStorage.getItem('default_wallet_mnemonic');
    var bytes  = CryptoJS.AES.decrypt(ciphertext, pinCode);
    var originalText = bytes.toString(CryptoJS.enc.Utf8);    
    const wallet = await DirectSecp256k1HdWallet.fromMnemonic(originalText);    
    const [firstAccount] = await wallet.getAccounts();  
}
