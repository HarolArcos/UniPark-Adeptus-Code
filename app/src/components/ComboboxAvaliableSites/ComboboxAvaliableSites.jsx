import Select from 'react-select'; 
import { useFetch } from '../../hooks/HookFetchListData';
import { useState } from 'react';

export default function ComboboxAvaliableSites({ onSiteIdChange ,nro}) { 

  const { data, loading } = useFetch(
    "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiSubscription/apiSubscription.php/listDisponibles"
  )
  const [selectedSiteId, setSelectedSiteId] = useState(null); 
    
  const handleSiteChange = (selectedOption) => {
    setSelectedSiteId(selectedOption.value);
    onSiteIdChange(selectedOption.value);
    
  };

  if (!loading) {
    // const defaultValue = data.find(site => site.numeros == nro);
    const options = data.map((site) => ({ value: site.numeros, label: site.numeros }));

    return (
      <Select
        placeholder="Seleccione un número de parqueo"
        options={options}
        // defaultValue={defaultValue && { value: defaultValue.numeros, label: `${defaultValue.numeros}` }}
        defaultValue={nro && { value:nro, label: nro }}
        value={options.find(option => option.value === selectedSiteId)}         
        onChange={handleSiteChange}
      />
    );
  }
}
