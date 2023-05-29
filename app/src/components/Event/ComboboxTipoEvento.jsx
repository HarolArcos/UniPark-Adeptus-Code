// import Select from 'react-select'; 
// import { useState } from 'react';

// export default function ComboboxPlacas({ onPersonaIdChange ,id}) { // actualiza la firma para recibir el id y la función onPersonaIdChange

//   const options = [
//     { value: 15, label: "Ingreso"},
//     { value: 16, label: "Salida" }
//     ];
//     const [selectedTypeId, setSelectedTypeId] = useState(null);

//     const handleTypeEventChange = (vehSelectedOption) => {
//         setSelectedTypeId(vehSelectedOption.value);
//         console.log(vehSelectedOption);
//     };

//     const types = options.map((veh) => ({value: veh.value, label: veh.label }));
//     const defaultValue = options.find( veh => veh. )

//     return (
//       <div className="propietario">
//         <Select 
//             options={types}
//             value={types.find(option => option.value === selectedTypeId)}

//             onChange={handleTypeEventChange}
//         />
//       </div>
//     );
// }

import React, { useEffect , useState} from "react";
import Select from "react-select";
import { useFetchSendData } from "../../hooks/HookFetchSendData";

export default function ComboboxTipoEvento({onReferenciaIdChange,defaultValor,referenciaObjeto}){ 
    const {data, fetchData} = useFetchSendData();
    const [ref,setRef]=useState([]);
    useEffect(() => {
        fetchData("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiReference/apiReference.php/listReferences",referenciaObjeto);
    }, [fetchData, referenciaObjeto]);
    
    useEffect(()=>{
        setRef(data);
        if (data && Array.isArray(data)) { 
            setRef(data.map((dato) => ({ value: dato.referencia_id, label: dato.referencia_valor})));
        }
    },[data]);
    
    const handleReferenciaChange = (selectedOption) => {
        setSelectedReferenciaId(selectedOption.value);
        onReferenciaIdChange(selectedOption.value);
        console.log('algo aqui', selectedOption);
    };
    
    const [selectedReferenciaId, setSelectedReferenciaId] = useState(null); 

    return(
            <Select
                placeholder="Seleccione el tipo de evento"
                options={ref}
                defaultValue={defaultValor}
                value={ref && Array.isArray(ref)?ref.find(option => option.value === selectedReferenciaId):''}
                onChange={handleReferenciaChange}
            />
            
          
    )
    
}
