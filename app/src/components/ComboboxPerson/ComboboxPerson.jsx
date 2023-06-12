import Select from 'react-select'; 
import { useFetch } from '../../hooks/HookFetchListData';
import { useState } from 'react';

export default function ComboboxPerson({ onPersonaIdChange ,id}) { // actualiza la firma para recibir el id y la función onPersonaIdChange
  console.log("Esto es id de vehiculo",id);
  
  const { data, loading } = useFetch(
    "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPersonClient"
  )
  const [selectedPersonaId, setSelectedPersonaId] = useState(null); 
    
  const handlePersonaChange = (selectedOption) => {
    setSelectedPersonaId(selectedOption.value);
    onPersonaIdChange(selectedOption.value);
    console.log(selectedOption);
  };

  if (!loading && data.desError){
    return(
      <p>{data.desError}</p>
      )
  }else {
    const defaultValue = data.find(person => person.persona_id === id);
    console.log("esto es defValue",defaultValue);
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
