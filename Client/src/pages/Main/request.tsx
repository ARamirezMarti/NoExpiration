
import axios from "axios";

const InventaryRequest = {

    submitInventaryForm(data:FormData,toast:any,headers:Object,modalRef:any){
        axios.post('http://localhost:3000/api/inventory/create',data,headers)
          .then(function (response) {
            if (response.data.status === 1){                
                toast({
                    cssClass:'my-css',
                    header:'Attention',
                    message: response.data.msg,
                    duration:2000,
                    color:'success'
                    
                })
                setTimeout(()=>{
                    modalRef.current?.dismiss()  
                },1000)
           
            }else{
                toast({
                    cssClass:'my-css',
                    header:'Attention',
                    message:response.data.msg,
                    duration:2000,
                    color:'warning'    
                })
            }
          })
          .catch(function (error) {           
            toast({
                cssClass:'my-css',
                header:'Atencion',
                message:error.response.data.msg,
                duration:2000,
                color:'warning'

            })
          });
    },
    getAllInventoriesByUser(headers:Object,toast:any){
        return new Promise((resolve,reject)=>{

            axios.get('http://localhost:3000/api/inventory',headers)
            .then(function (response) {
              if (response.data.status === 1){    
                resolve(response.data)
              }else{
                toast({
                    cssClass:'my-css',
                    header:'Attention',
                    message:response.data.msg,
                    duration:2000,
                    color:'warning'    
                })
              }
            })
            .catch(function (error) {           

              toast({
                  cssClass:'my-css',
                  header:'Atencion',
                  message:error.response.data.msg,
                  duration:2000,
                  color:'warning'
  
              })
            });

        })
    },
    deleteInventories(data:FormData,headers:Object,toast:any){
        return new Promise((resolve,reject)=>{

            axios.delete('http://localhost:3000/api/inventory/delete',data,headers)
            .then(function (response) {
                console.log(response)
              if (response.data.status === 1){                
                 
                toast({
                    cssClass:'my-css',
                    header:'Attention',
                    message: response.data.msg,
                    duration:2000,
                    color:'success'
                    
                })
             
              }else{
                toast({
                    cssClass:'my-css',
                    header:'Attention',
                    message:response.data.msg,
                    duration:2000,
                    color:'warning'    
                })
              }
            })
            .catch(function (error) {           

              toast({
                  cssClass:'my-css',
                  header:'Atencion',
                  message:error.response.data.msg,
                  duration:2000,
                  color:'warning'
  
              })
            });

        })
    }

}

export default InventaryRequest;