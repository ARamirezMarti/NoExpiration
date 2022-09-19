import {  IonCol, IonContent,useIonToast ,IonGrid, IonHeader, IonIcon, IonPage, IonRow, IonTitle, IonToolbar, useIonViewWillEnter, IonBadge } from '@ionic/react';
import { useParams,useHistory} from 'react-router';
import getToken, { getInventory } from '../../Helpers/functions';
import { addSharp, arrowBack,trashBinOutline} from "ionicons/icons";
import CreateProductModal from '../../components/ProductComponent/createProduct';
import inventoryRequest from './request';
import { useState } from 'react';


const Inventory: React.FC = () => {

    const {name} : any = useParams(); 
    const [productList,setListProducts] = useState<any>([])

    const [toast] = useIonToast();

    const history = useHistory();
    
    

    useIonViewWillEnter(async ()=>{
        getItems()
    })

    const getItems = async () =>{
        let data:any = await inventoryRequest.getProducts(getToken(),toast,getInventory())
        setListProducts(data.products);
    }

    const deleteProduct = (id:any) =>{
        inventoryRequest.deleteProd(getToken(),toast,id,getItems);
    }

    const GoBack = ()=>{
        history.goBack();
    }


  return (
    <IonPage>
        <IonHeader>
        <IonToolbar>
          <IonTitle class='ion-text-center'> {name}</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent fullscreen>
     
      <IonGrid  >
        <IonRow >
            <IonCol>
                <div  onClick={GoBack} className="product_boxes" >
                    <IonIcon   icon={arrowBack}></IonIcon>
                </div>
            </IonCol > 
            
            <IonCol>
                <div id="open-create-product-modal" style={{backgroundColor:'rgba(9, 153, 215, 0.35)'}} className="product_boxes">
                    <IonIcon icon={addSharp}></IonIcon>
                </div>
            </IonCol>
            
        </IonRow>
        
    </IonGrid>


    <IonGrid>
            <IonRow class='ion-text-center'>
                <IonCol className='product_table_header'><h5> Product</h5></IonCol>
                <IonCol className='product_table_header'><h5> Expiration</h5></IonCol>
                <IonCol className='product_table_header'><h5> Days left</h5></IonCol>
                <IonCol className='product_table_header'><h5> Delete</h5></IonCol>
            </IonRow>
            {

            productList.map((item: any) => {
                return (
                    <IonRow key={item.id} class='ion-text-center'>

                        <IonCol>{item.name}</IonCol>
                        <IonCol> {item.expiration_date}</IonCol>
                        <IonCol> {item.days_left}
                            { item.days_left < 5 &&
                                <IonBadge  color='danger'>!</IonBadge>
                            }
                        </IonCol>
                        <IonCol> <IonIcon onClick={()=>{deleteProduct(item.id)} } icon={trashBinOutline}></IonIcon></IonCol>
                        
                    </IonRow>
                    
                    
                )
                
                })

            }  

    </IonGrid>
    <CreateProductModal getProducts={getItems} />
    </IonContent>

    
    
    
    </IonPage>
  );
};

export default Inventory;
