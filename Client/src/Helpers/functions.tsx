
var CryptoJS = require("crypto-js");

export  function setInventory(id:any){

    var ciphertext = CryptoJS.AES.encrypt(JSON.stringify(id), 'my-secret-key@123').toString();
    return ciphertext
}
export function getInventory(){
    var bytes = CryptoJS.AES.decrypt(localStorage.getItem('inventory'), 'my-secret-key@123');
    var decryptedData = JSON.parse(bytes.toString(CryptoJS.enc.Utf8))
    return decryptedData;
}

export default  function getToken(){
    return {        
        headers:{ Authorization:`Bearer ${localStorage.getItem('token')}`}
    }
}

