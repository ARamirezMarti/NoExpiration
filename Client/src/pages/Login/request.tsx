import axios from 'axios';


const LoginRequest = {
    
     login(email:string,password:string,toast:any){

        let formdata = new FormData();
        formdata.append("email",email);
        formdata.append("password",password);

        axios.post(`http://localhost:3000/api/login`,formdata)
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