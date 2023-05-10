import Select from 'react-select'; 
import { useFetch } from '../../hooks/HookFetchListData';
import { useState } from 'react';

export default function ComboboxPerson({ id, onPersonaIdChange }) { // actualiza la firma para recibir el id y la función onPersonaIdChange

  const { data, loading } = useFetch(
    "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPerson"
  )
  const [selectedPersonaId, setSelectedPersonaId] = useState(null); // inicializa el estado para el id seleccionado

  const handleOnChange = (option) => { 
    setSelectedPersonaId(option ? option.value : null);     
    onPersonaIdChange(option ? option.value : null); 
  };

  if (!loading) {
    const defaultValue = data.find(person => person.persona_id === id);
    const options = data.map((person) => ({ value: person.persona_id, label: `${person.persona_ci}-${person.persona_nombre} ${person.persona_apellido}` }));

    return (
      <Select
        placeholder="Seleccione persona"
        options={options}
        defaultValue={defaultValue && { value: defaultValue.persona_id, label: `${defaultValue.persona_ci}-${defaultValue.persona_nombre} ${defaultValue.persona_apellido}` }}
        value={options.find(option => option.value === selectedPersonaId)} 
        onChange={handleOnChange} 
      />
    );
  }
}
