import { IonModal, IonHeader, IonToolbar,useIonToast ,IonButtons, IonButton, IonTitle, IonContent, IonItem, IonLabel, IonInput, IonTextarea } from '@ionic/react';
import { useState,useRef } from 'react';
import getToken from '../../Helpers/functions';
import InventaryRequest from '../../pages/Main/request';

interface CreateInventoryModal { 
  updateList:Function
}

const CreateInventoryModal: React.FC<CreateInventoryModal> = ({updateList}) => {

  const modal = useRef<HTMLIonModalElement>(null);
  const [name,setName] = useState<any>('')
  const [description,setDescription] = useState<any>('')
  const [toast] = useIonToast();



  function createInventory() {
    let formdata = new FormData();
    formdata.append('name',name)
    formdata.append('description',description)
    InventaryRequest.submitInventaryForm(formdata,toast,getToken(),modal)
    updateList()

  }
  return (
    <IonModal ref={modal} trigger="open-modal" >
          <IonHeader>
            <IonToolbar>
              <IonButtons slot="start">
                <IonButton onClick={() => modal.current?.dismiss()}>Cancel</IonButton>
              </IonButtons>
              <IonTitle>Create inventory</IonTitle>
              <IonButtons slot="end">
                <IonButton strong={true} onClick={() => createInventory()}>
                  Confirm
                </IonButton>
              </IonButtons>
            </IonToolbar>
          </IonHeader>
          <IonContent className="ion-padding">
            <IonItem>
              <IonLabel position="stacked">Inventory name</IonLabel>
              <IonInput onIonChange={e => setName(e.detail.value)} type="text" placeholder="Name" />
            </IonItem>

            <IonItem>
              <IonLabel position="stacked">Inventory description</IonLabel>
              <IonTextarea rows={5} onIonChange={e => setDescription(e.detail.value)} placeholder="Description" />
            </IonItem>
          </IonContent>
        </IonModal>
  
  );
};

export default CreateInventoryModal;
