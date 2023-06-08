import Select from 'react-select'; 
import { useFetch } from '../../hooks/HookFetchListData';
import { useSend } from '../../hooks/HookList';
import { useState } from 'react';

export default function ComboboxAvaliableSites({ onSiteIdChange ,nro}) { 

  const { data, loading } = useFetch(
    "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiConfiguracion/apiConfiguracion.php/listConfigurationNumSitios"
  )
  const [selectedSiteId, setSelectedSiteId] = useState(null); 
    
  const handleSiteChange = (selectedOption) => {
    setSelectedSiteId(selectedOption.value);
    onSiteIdChange(selectedOption.value);
    
  };


  if (!loading && data) {
    if (data.desError) {
        return(
          <h7>No existen sitios Disponibles,mil disculpas</h7>
        );
    }else{

      console.log(data);
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
}
