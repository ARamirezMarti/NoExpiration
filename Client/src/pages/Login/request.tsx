import axios from 'axios';


const LoginRequest = {
    
     login(email:string,password:string,toast:any){

        axios.get(`http://localhost:3000/api/login?email=${email}&password=${password}`)
            .then((response) => {
                if(response.data.status === 1){
                    localStorage.setItem('token',response.data.token);
                    window.location.href='/main'
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

    } 
}

export default LoginRequest