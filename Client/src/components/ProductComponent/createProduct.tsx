import { IonModal, IonHeader,useIonToast,IonDatetimeButton, IonToolbar,IonButtons, IonButton, IonTitle, IonContent, IonItem, IonLabel, IonInput, IonDatetime, useIonViewWillEnter, IonSelectOption, IonSelect } from '@ionic/react';
import { useState,useRef } from 'react';
import axios from 'axios';
import getToken, { getInventory } from '../../Helpers/functions';

interface  CreateProductModal {
  getProducts:Function
}

const CreateProductModal: React.FC<CreateProductModal> = ({getProducts}) => {


  useIonViewWillEnter (()=>{
      getTypes()
      const d :Date = new Date(Date.now());
      setDefaultFechaHoy(d.toISOString())

      

  })


  const [types,setTypes] = useState<any>([])
  const [name,setName] = useState<any>('')
  const [type,setType] = useState<any>('')  
  const [defaultFechaHoy,setDefaultFechaHoy] = useState<any>('')  
  
  const [buyingDate,setBuying] = useState<any>('')  
  const [expirationDate,setExpiration] = useState<any>('')  
  const modal = useRef<HTMLIonModalElement>(null);
  const [toast] = useIonToast();

  



  const getTypes = () =>{

    axios.get('http://localhost:3000/api/types',getToken())
    .then(function (response) {
      if(response.data.status===1){
        setTypes(response.data.types);
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
  }

  const handleCreation = ()=>{
   
    let data = new FormData();
    data.append('inventory_id',getInventory())
    data.append('prod_type_id',type)
    data.append('name',name)
    data.append('buying_date',buyingDate.split('T')[0])
    data.append('expiration_date',expirationDate.split('T')[0])
    data.append('image', '')
    if (!buyingDate ) {
      data.append('buying_date',defaultFechaHoy.split('T')[0])

    }

    axios.post('http://localhost:3000/api/product/create',data,getToken())
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
                  modal.current?.dismiss()  
                  getProducts()
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



  }
 
  return (
    <IonModal ref={modal} trigger="open-create-product-modal" >
          <IonHeader>
            <IonToolbar>
              <IonButtons slot="start">
                <IonButton onClick={() => modal.current?.dismiss()}>Cancel</IonButton>
              </IonButtons>
              <IonTitle>Create product</IonTitle>
              <IonButtons slot="end">
              </IonButtons>
            </IonToolbar>
          </IonHeader>

          <IonContent >
                    <IonItem>
                      <IonLabel position="stacked">Type</IonLabel>
                      <IonSelect
                          placeholder="Select type"
                          onIonChange={(e) => setType(e.detail.value)}
                        >
                          {
                            types.map((item: any) => {
                              return (
                                <IonSelectOption key={item.id} value={item.id}>{item.type}</IonSelectOption>
                              )
                              
                            })

                          }                          
                      </IonSelect>
                    </IonItem>

                    <IonItem>
                      <IonLabel position="stacked">Name</IonLabel>
                      <IonInput onIonChange={(e) =>setName(e.detail.value!)} type="text" placeholder="Name" />
                    </IonItem>
                    
                    <IonItem>
                      <IonLabel position="stacked">TODO:IMAGEN (Opcional)</IonLabel>
                      <IonInput  type="text" placeholder="Name" />
                    </IonItem>
                    
                    <IonItem>
                      <IonLabel position="stacked"> Buying date</IonLabel>
                      <IonDatetimeButton  slot='end' datetime='buying'></IonDatetimeButton>
                    </IonItem>
                    <IonModal keepContentsMounted={true}>
                        <IonDatetime value={defaultFechaHoy} onIonChange={(e) =>setBuying(e.detail.value!)} id='buying'  presentation='date'></IonDatetime>
                    </IonModal>
                    
                    <IonItem>
                      <IonLabel position="stacked">Expiration  date</IonLabel>
                      <IonDatetimeButton slot='end'  datetime='expiration'></IonDatetimeButton>
                    </IonItem>
                    <IonModal keepContentsMounted={true}>
                        <IonDatetime onIonChange={(e) =>setExpiration(e.detail.value!)} id='expiration'  presentation='date'></IonDatetime>
                    </IonModal>
                    <div className='central_button' >

                      <IonButton style={{Margin:'0px auto'}}  onClick={handleCreation}>Create</IonButton>
                    </div>
                    

              
          </IonContent>
        </IonModal>
  
  );
};

export default CreateProductModal;
