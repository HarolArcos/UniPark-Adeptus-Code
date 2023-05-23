import React, { useEffect } from "react";
import Select from "react-select";
//import { useEffect } from "react";
import { useState } from "react";
import "./ComboboxReferences.css";
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import { useFetch } from "../../hooks/HookFetchListData";

export default function ComboboxReferences(){ 

    

    const {data:tipo,loading,error} = useFetch("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRol/apiRol.php/listRol")
    
    const ref = tipo.map((opcion)=> ({value: opcion.rol_id , label: opcion.rol_nombre}))

    

    const [selectedOption, setSelectedOption] = useState(null);
    const [options, setOptions] = useState([]);

    const {data, fetchData} = useFetchSendData();

    const handleOptionChange = async (option) => {
        setSelectedOption(option);
        
        const apiUrl = 'http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiReference/apiReference.php/listReferences';
        const requestData = {
            tableNameReference: 'persona',
            nameSpaceReference: 'persona_estado'
        };

        try {
        const response = await fetchData(apiUrl, requestData);
        setOptions(response);
        } catch (error) {
        console.error('Error fetching data:', error);
        }
    };
    useEffect(() => {
        setOptions(data);
        
    }, [data]);
    
    if (!loading) {
        return(
            // <div className="combobox">
            //     <Select
            //         placeholder="Seleccione Referencia"
            //         options={ options }
            //     ></Select>
            // </div>
            <div className="comboBoxGroup">
                <Select
                    className="selectRef"
                    placeholder="Referencia"
                    options={ref}
                    value={selectedOption}
                    onChange={handleOptionChange}
                />
                
                
            </div>    
        )
    }
    
}