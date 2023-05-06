
import Select from 'react-select';
import { DataUser } from '../context/UserContext';
import { useFetch } from '../../hooks/HookFetchListData';
import { useContext } from "react"



export default function ComboboxPerson(){
    const {userglobal} = useContext(DataUser)
    let { data, loading,  } = useFetch(
        "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPerson"
              )
      if(!loading) 
      {
        
        
        // let autosUser = data.filter((auto)=> auto.persona_id===userglobal.persona_id)
        

    
      

      return  <Select placeholder="Seleccione persona" options={data.map((person)=> ({value: person.persona_id , label:  person.persona_ci+"-"+ person.persona_nombre +" "+  person.persona_apellido}))}  ></Select>

    }



}