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

    },
    deleteProd(token:Object,toast:any,id:number,getItems:Function){
        console.log(token)
        return new Promise ((resolve,reject)=>{

            axios.delete(`http://localhost:3000/api/product/delete?id=${id}`,token)
                .then((response) => {
                    console.log(response)
                    if(response.data.status===1){
                        getItems()
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