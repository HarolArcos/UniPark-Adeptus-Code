import Select from 'react-select'; 
import { useFetch } from '../../hooks/HookFetchListData';
import { useState } from 'react';

export default function ComboboxRoles({ onRolIdChange ,id}) { // actualiza la firma para recibir el id y la función onPersonaIdChange

  const { data, loading } = useFetch(
    "http://adeptuscode.tis.cs.umss.edu.bo//UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRol/apiRol.php/listRol"
  )
    const [selectedRolId, setselectedRolId] = useState(null);

    const handleRolChange = (rolSelected) => {
        setselectedRolId(rolSelected.value);
        onRolIdChange(rolSelected.value);
        console.log(rolSelected);
    };

  if (!loading) {
    const defaultValue = data.find(rol => rol.rol_id === id);
    const optionsRol = data.map((rol) => ({value: rol.rol_id, label: rol.rol_nombre }));
    return (
      <div className="propietario">
        <Select 
            options={optionsRol}
            value={optionsRol.find(option => option.value === selectedRolId)}  
            defaultValue={defaultValue && { value: defaultValue.rol_id, label: defaultValue.rol_nombre }}
            onChange={handleRolChange}
        />
      </div>
    );
  }
}
