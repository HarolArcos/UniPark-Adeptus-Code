
// import Select from 'react-select';

// import { useFetch } from '../../hooks/HookFetchListData';

// let url = "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiVehicle/apiVehicle.php/listVehicle"


// export default function Vehiculos(){
//     let { data, loading,  } = useFetch(
//         url
//               )
//       if(!loading) 
//       {
//         const opciones = data.map((auto)=> ({value: auto.vehiculo_id , label: auto.vehiculo_placa +" - "+  auto.vehiculo_modelo}))
//       return      <Select placeholder="Seleccione automovil" options={opciones}  ></Select>
//     }
// }

import Select from 'react-select'; 
import { useFetch } from '../../hooks/HookFetchListData';
import { useState } from 'react';

export default function ComboboxVehicle({ onPersonaIdChange ,id}) { // actualiza la firma para recibir el id y la función onPersonaIdChange

  const { data, loading } = useFetch(
    "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPersonClient"
  )
  const [selectedPersonaId, setSelectedPersonaId] = useState(null); 
    
  const handlePersonaChange = (selectedOption) => {
    setSelectedPersonaId(selectedOption.value);
    onPersonaIdChange(selectedOption.value);
    console.log(selectedOption);
  };

  if (!loading) {
    const defaultValue = data.find(person => person.persona_id === id);
    const options = data.map((person) => ({ value: person.persona_id, label: `${person.persona_ci}-${person.persona_nombre} ${person.persona_apellido}` }));

    return (
      <Select
        placeholder="Seleccione un usuario"
        options={options}
        defaultValue={defaultValue && { value: defaultValue.persona_id, label: `${defaultValue.persona_ci}-${defaultValue.persona_nombre} ${defaultValue.persona_apellido}` }}
        value={options.find(option => option.value === selectedPersonaId)}         
        onChange={handlePersonaChange}
      />
    );
  }
}
