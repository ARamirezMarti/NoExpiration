import { IonButton, IonContent, IonHeader, IonInput, IonItem, IonPage, IonTitle, IonToolbar, useIonToast } from '@ionic/react';
import { useState } from 'react';
 import './style.css';
 import LoginRequest from './request';

const Login: React.FC = () => {
    const [email,setEmail] = useState<string>('');
    const [password,setPassword] = useState<string>('');
    const [toast] = useIonToast();

    const handleLogin = async () =>{
        await LoginRequest.login(email,password,toast)        
    }

    


  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonTitle class='ion-text-center'>Login</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent fullscreen>
       
 
 
   <div className="main_div">
        <IonItem class='spacer'>
        <IonInput type="email" placeholder='Your email' value={email} onIonChange={(e) =>setEmail(e.detail.value!)} ></IonInput>

        </IonItem>

        <IonItem class='spacer'>
          <IonInput type="password" placeholder='Your password' value={password} onIonChange={(e) => setPassword(e.detail.value!)} ></IonInput>
        </IonItem>
        
        <IonButton type="submit" onClick={handleLogin} expand="block">Log in</IonButton>
        <IonButton routerLink='/register'  type="button" expand="block" fill="clear"> Create an account   </IonButton>

   </div>



      </IonContent>
    </IonPage>
  );
};

export default Login;
