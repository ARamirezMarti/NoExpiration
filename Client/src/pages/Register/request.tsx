
import axios from "axios";

const registerRequest = {

    submitForm(data:FormData,toast:any){

        axios.post('http://localhost:3000/api/register',data)
          .then(function (response) {
            if (response.data.status === 1){                
                console.log(response)
                toast({
                    cssClass:'my-css',
                    header:'Attention',
                    message: 'Account created succesfully.',
                    duration:2000,
                    color:'success'
                    
                })
                setTimeout(() => {
                    window.location.href='/Login'                    
                }, 2000);
 
            }else{
                console.log(response)

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
            console.log(error)

            toast({
                cssClass:'my-css',
                header:'Atencion',
                message:error.response.data.msg,
                duration:2000,
                color:'warning'

            })
          });
    }
}

export default registerRequest;