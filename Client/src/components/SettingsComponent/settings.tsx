import { IonModal, IonHeader, IonIcon,IonToggle,IonToolbar,IonButtons, IonButton, IonTitle, IonContent, IonItem, IonLabel,} from '@ionic/react';
import { useRef } from 'react';
import { moon } from "ionicons/icons";



const SettingsModal: React.FC =  () => {

  const modal = useRef<HTMLIonModalElement>(null);
  
  const toggleDarkModeHandler = () => document.body.classList.toggle('light');


 
  return (
    <IonModal ref={modal} trigger="open-settings-modal" >
          <IonHeader>
            <IonToolbar>
              <IonButtons slot="start">
                <IonButton onClick={() => modal.current?.dismiss()}>Cancel</IonButton>
              </IonButtons>
              <IonTitle>TODO ::: Settings</IonTitle>
              <IonButtons slot="end">
              </IonButtons>
            </IonToolbar>
          </IonHeader>
          <IonContent className="ion-padding">
            <IonItem>
                <IonIcon slot="start" icon={moon} />
                <IonLabel>Dark Mode</IonLabel>
                <IonToggle
                slot="end"
                name="darkMode"
                onIonChange={toggleDarkModeHandler}
                />
            </IonItem>

           
          </IonContent>
        </IonModal>
  
  );
};

export default SettingsModal;
