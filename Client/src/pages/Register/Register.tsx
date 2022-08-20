import { IonButton, IonContent, IonHeader, IonInput,  IonItem, IonPage, IonTitle, IonToolbar, useIonToast } from '@ionic/react';
import { useState } from 'react';
import registerRequest from './request';


const Register: React.FC = () => {
    const [email,setEmail] = useState<string>('');
    const [name,setName] = useState<string>('');
    const [lastname,setLastname] = useState<string>('');
    const [password,setPassword] = useState<string>('');
    const [toast] = useIonToast();

    const handleSubmit = async () =>{
        let formdata = new FormData();
        formdata.append('email',email)
        formdata.append('name',name)
        formdata.append('lastname',lastname)
        formdata.append('password',password)

        await registerRequest.submitForm(formdata,toast);
        


    }

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonTitle class='ion-text-center'>Register</IonTitle>
        </IonToolbar>
      </IonHeader>


      <IonContent >
        <form  >
            <IonItem class='spacer ion-margin-bottom'>
                <IonInput type="email" placeholder='Your email'  value={email} onIonChange={(e) =>setEmail(e.detail.value!)} ></IonInput>
            </IonItem>
            <IonItem class='spacer'>
                <IonInput type="text" placeholder='Your name'  value={name} onIonChange={(e) =>setName(e.detail.value!)} ></IonInput>
            </IonItem>
            <IonItem class='spacer'>
                <IonInput type="text" placeholder='Your last name' value={lastname} onIonChange={(e) =>setLastname(e.detail.value!)}  ></IonInput>
            </IonItem>
            <IonItem class='spacer'>
                <IonInput type="password" placeholder='Your password' value={password} onIonChange={(e) =>setPassword(e.detail.value!)}  ></IonInput>
            </IonItem>

        </form>


        
        <IonButton onClick={handleSubmit} type="submit" expand="block">Register</IonButton>
        <IonButton routerLink='/login' type="submit" expand="block">Back to login</IonButton>



      </IonContent>
    </IonPage>
  );
};

export default Register;
