import React from "react";
import Select from "react-select";
import { useState } from "react";
import "./ComboboxReferences.css";
//import { useFetchSendData } from "../../hooks/HookFetchSendData";

import { sendAndReceiveJson } from "../../hooks/HookFetchSendAndGetData";
import { useEffect } from "react";

export default function ComboboxReferences({ onChange, id}) {
  
  console.log("esto es el id que pasamos por parametro",id);
  const [tar, setTar] = useState([])
  const [loading, setLoading] = useState(true)

//   if (loading) {sendAndReceiveJson("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiReference/apiReference.php/listReferences",
//   {
//     tableNameReference : "persona",
//     nameSpaceReference :  "persona_tipo"
// }).then((responseData) => {
  
//   setTar(responseData)
//   setLoading(false)
//   console.log("esto es se ingresara en tar",responseData);
//   console.log("tar:", tar);
// });}
  
useEffect(() => {
  sendAndReceiveJson("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiReference/apiReference.php/listReferences", {
    tableNameReference: "persona",
    nameSpaceReference: "persona_tipo"
  }).then((responseData) => {
    setTar(responseData);
    setLoading(false);
  });
}, []);

  const [selectedOption, setSelectedOption] = useState(null);

  const handleOptionChange = (option) => {
    setSelectedOption(option);
    onChange(option);
    console.log("Esto es option.value",option.value);
  };


  if (!loading) {
    //const defaultValue = tar && tar.find((defVal) => defVal.referencia_id === id); // Agrega una verificación de tar
    
    const ref = tar.map((opcion) => ({
      value: opcion.referencia_id,
      label: opcion.referencia_valor,
    }));
    console.log("esto es ref", ref);
    const defaultValue = ref.find((def) => def.value === id )
    console.log("default value aqui", defaultValue);

    return (
      <div className="comboBoxGroup">
        <Select
          className="selectRef"
          placeholder="Seleccione el Tipo Persona" 
          options={ref}
          defaultValue={defaultValue && { value: defaultValue.value, label: defaultValue.label}}
          value={ref.find(option => option.value === selectedOption)}
          onChange={handleOptionChange}
        />
      </div>
    );
  }
}