import Select from 'react-select'; 
import { useFetch } from '../../hooks/HookFetchListData';
import { useState } from 'react';

export default function ComboboxTarifa({ onTarifaIdChange,id}) {

  const { data, loading } = useFetch(
    "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRate/apiRate.php/listRate"
  )
  const [selectedTarifa, setSelectedTarifa] = useState(
    id? data.find(tarifa => tarifa.tarifa_id === id):null
  ); 
    
  const handleTarifaChange = (selectedOption) => {
    
    setSelectedTarifa(selectedOption.value);
    onTarifaIdChange(selectedOption.value);
    //onTarifaIdChange(selectedOption);
    
  };

  if (!loading) {
    console.log(data);
    // let defaultValue = null;
      
const      defaultValue = data.find(tarifa => tarifa.tarifa_id === id);
    
    const options = data.map((tarifa) => ({ value: tarifa, label: `${tarifa.tarifa_nombre}` }));

    return (
      <Select
        placeholder="Seleccione una opción"
        options={options}
        defaultValue={defaultValue && { value: defaultValue, label: `${defaultValue.tarifa_nombre}` }}
        value={options.find(option => option.value === selectedTarifa)}         
        onChange={handleTarifaChange}
      />
    );
  }
}
