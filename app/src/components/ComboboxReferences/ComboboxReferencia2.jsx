import React, { useEffect } from "react";
import Select from "react-select";
import { useState } from "react";
import "./ComboboxReferences.css";
import { useFetchSendData } from "../../hooks/HookFetchSendData";

import { sendAndReceiveJson } from "../../hooks/HookFetchSendAndGetData";

export default function ComboboxReferences({ onChange, id}) {
  
  const [tar, settar] = useState([])
  const [loading, setloading] = useState(true)
  if (loading) {sendAndReceiveJson("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiReference/apiReference.php/listReferences",
  {
    "tableNameReference" : "persona",
    "nameSpaceReference" :  "persona_tipo"
}).then((responseData) => {
  
  settar(responseData)
  setloading(false)
});}

  const ref = tar.map((opcion) => ({
    value: opcion.referencia_id,
    label: opcion.referencia_valor,
  }));

  const [selectedOption, setSelectedOption] = useState(null);
  const [options, setOptions] = useState([]);

  const { data, fetchData } = useFetchSendData();

  const handleOptionChange = async (option) => {
    setSelectedOption(option);

    const apiUrl =
      "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiReference/apiReference.php/listReferences";
    const requestData = {
      tableNameReference: "persona",
      nameSpaceReference: "persona_estado",
    };

    try {
      const response = await fetchData(apiUrl, requestData);
      setOptions(response);

      // Llamar a la función onChange y pasar el valor seleccionado
      onChange(option);
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  };
  useEffect(() => {
    setOptions(data);
  }, [data]);

  if (!loading) {
    const defaultValue = ref.find(person => person.value === id);
    return (
      <div className="comboBoxGroup">
        <Select
          className="selectRef"
          placeholder="Seleccionar el Tipo Persona" 
          options={ref}
          defaultValue={defaultValue && { value: defaultValue.referencia_id, label: defaultValue.referencia_valor}}
          value={selectedOption}
          onChange={handleOptionChange}
        />
      </div>
    );
  }
}