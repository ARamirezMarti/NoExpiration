import axios from 'axios';


const inventoryRequest = {
    
     getProducts(token:Object,toast:any,inventory:number){
        
        return new Promise ((resolve,reject)=>{

            axios.get(`http://localhost:3000/api/product/all?inventory_id=${inventory}`,token)
                .then((response) => {
                    if(response.data.status===1){
                        resolve(response.data)
                    }
                
                }).catch((error)=>{
                    toast({
                        cssClass:'my-css',
                        header:'Attention',
                        message:error.response.data.msg,
                        duration:2000,
                        color:'danger'
                })
            })
        })

    } 
}

export default inventoryRequest