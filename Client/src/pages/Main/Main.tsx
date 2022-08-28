import { IonButton, IonCheckbox, IonCol, IonContent, IonGrid, IonHeader, IonIcon,  IonItem,  IonLabel, IonList, IonPage, IonRow,  IonTitle, IonToolbar, useIonToast, useIonViewWillEnter } from '@ionic/react';
import {  useState } from 'react';
import { arrowBack } from "ionicons/icons";
import InventaryRequest from './request';
import CreateInventoryModal from '../../components/InventoryComponents/createInventory';
import getToken, { setInventory } from '../../Helpers/functions';
import SettingsModal from '../../components/SettingsComponent/settings';


const Main: React.FC = () => {
  let deleteInventorySelected:any = [];
  
  const [inventories,setListInventories] = useState<any>([])
  const [toast] = useIonToast();

  useIonViewWillEnter(async ()=>{
    updateList()
  })
    
  const addToDeleteArray = (itemId:number)=>{
    if (deleteInventorySelected.indexOf(itemId) > -1){
      deleteInventorySelected = deleteInventorySelected.filter((item:number) => item !== itemId)
    }else{
      deleteInventorySelected.push(itemId)
    }
  }
  const deleteinventories = () =>{
    deleteInventorySelected.forEach((id:number) => {
      InventaryRequest.deleteInventories(id.toString(),getToken(),toast)
      updateList()

    });
  }

 
  const updateList = async () =>{
    let data:any = await InventaryRequest.getAllInventoriesByUser(getToken(),toast)    
    setListInventories(data.inventories)
  }


 const chooseInventory=(id:any)=>{
  // TODO :: CAMBIAR SECRET
  localStorage.setItem('inventory',setInventory(id))
 }



  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonTitle class='ion-text-center'>Control panel</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent fullscreen>
    
    <IonButton id='go_back_button' ><IonIcon icon={arrowBack}></IonIcon></IonButton>
       
    <IonGrid  >
        <IonRow >
            <IonCol>
                <div id="open-settings-modal" style={{backgroundColor:'rgba(11, 213, 68, 0.35)'}}  className="menu_boxes" >Settings</div>
            </IonCol > 
            
        </IonRow>
        <IonRow>
            <IonCol>
                <div id="open-modal"  style={{backgroundColor:'rgba(9, 153, 215, 0.35)'}} className="menu_boxes">
                  Create inventoy
                </div>
            </IonCol>
            <IonCol >
                 <div onClick={deleteinventories}  style={{backgroundColor:'rgba(213, 213, 11, 0.35)'}}  className="menu_boxes" >Delete Inventory</div>
            </IonCol >
            
            
        </IonRow>
    </IonGrid>





    <IonContent  scroll-y="false">

      <IonItem class='ion-text-center'>
        <IonLabel >
            <p style={{fontSize:'1.5rem'}}> Your inventories </p>
        </IonLabel>
      </IonItem>
      
      <div className='inventory_list'>
        <IonList>          
          {

            inventories.map((item: any) => {
              return (

                <IonItem onClick={()=>{chooseInventory(item.id)}} routerLink={`/inventory/${item.name}`}  button={true} detail={true}  key={item.id} >
                    <IonLabel >
                      <h2>{item.name}</h2>
                      <h3>{item.description}</h3>
                      <p style={{color:'red'}}>TODO:Products: <b>23</b> </p>
                      <p style={{color:'red'}}>TODO: Closest expiration date: <b>2022-04-05</b></p>
                    </IonLabel>
                      <IonCheckbox  onIonChange={()=>{addToDeleteArray(item.id)}} slot="end" color="dark" />
                </IonItem>
              )
              
            })
          
          }
         
        </IonList>
      </div>
    </IonContent>

    <CreateInventoryModal updateList={updateList}/>
    <SettingsModal/>
    </IonContent>
    </IonPage>
  );
};

export default Main;

