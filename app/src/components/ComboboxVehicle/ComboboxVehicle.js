
import Select from 'react-select';

import { useFetch } from '../../hooks/HookFetchListData';

let url = "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiVehicle/apiVehicle.php/listVehicle"


export default function Vehiculos(){
    
    let { data, loading,  } = useFetch(
        url
              )
      if(!loading) 
      {
        
        const opciones = data.map((auto)=> ({value: auto.vehiculo_id , label: auto.vehiculo_placa +" - "+  auto.vehiculo_modelo}))
        
        

        let autosUser = data.filter((auto)=> auto.persona_id===userglobal.persona_id)

      return      <Select placeholder="Seleccione automovil" options={opciones}  ></Select>

    }



}