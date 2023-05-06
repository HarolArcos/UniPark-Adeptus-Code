
import Select from 'react-select';
import { DataUser } from '../context/UserContext';
import { useFetch } from '../../hooks/HookFetchListData';
import { useContext } from "react"



export default function Vehiculos(){
    const {userglobal} = useContext(DataUser)
    let { data, loading,  } = useFetch(
        "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiVehicle/apiVehicle.php/listVehicle"
              )
      if(!loading) 
      {

        let autosUser = data.filter((auto)=> auto.persona_id===userglobal.persona_id)

      return      <Select placeholder="Seleccione automovil" options={autosUser.map((auto)=> ({value: auto.vehiculo_id , label: auto.vehiculo_placa +" "+  auto.vehiculo_modelo}))}  ></Select>

    }



}