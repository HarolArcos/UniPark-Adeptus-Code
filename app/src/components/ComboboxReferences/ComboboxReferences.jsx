import React, { useEffect } from "react";
import Select from "react-select";
//import { useEffect } from "react";
import { useState } from "react";
import "./ComboboxReferences.css";
import { useFetchSendData } from "../../hooks/HookFetchSendData";

export default function ComboboxReferences(){ 

    // const ref = [
    //     { value: 'Persona Tipo', label: 'Persona Tipo' }
    // ];

    // const type = [
    //     { value: 'Administrador', label: 'Administrador' },
    //     { value: 'Cliente', label: 'Cliente' },
    //     { value: 'Guardia', label: 'Guardia' }
    // ]

    // const [selectedOption, setSelectedOption] = useState(null);
    // const [options, setOptions] = useState([]);

    // const {data, fetchData} = useFetchSendData();

    // const handleOptionChange = async (option) => {
    //     setSelectedOption(option);
        
    //     const apiUrl = 'http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiReference/apiReference.php/listReferences';
    //     const requestData = {
    //         tableNameReference: 'persona',
    //         nameSpaceReference: 'persona_estado'
    //     };

    //     try {
    //     const response = await fetchData(apiUrl, requestData);
    //     setOptions(response);
    //     } catch (error) {
    //     console.error('Error fetching data:', error);
    //     }
    // };
    // useEffect(() => {
    //     setOptions(data);
    //     console.log(data);
    // }, [data]);
    // console.log(data, 'valores');

    // return(
    //     // <div className="combobox">
    //     //     <Select
    //     //         placeholder="Seleccione Referencia"
    //     //         options={ options }
    //     //     ></Select>
    //     // </div>
    //     <div className="comboBoxGroup">
    //         <Select
    //             className="selectRef"
    //             placeholder="Referencia"
    //             options={ref}
    //             value={selectedOption}
    //             onChange={handleOptionChange}
    //         />
    //         {ref.length > 0 && (
    //             <Select
    //             className="selectRef"
    //             options={type}
    //             />
    //         )} 
    //     </div>    
    //)

    const [options, setOptions] = useState([]);
    const [selectedOption, setSelectedOption] = useState(null);

    useEffect(() => {
        fetchOptions();
    }, []);

    const fetchOptions = async () => {
        try {
        const response = await fetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiReference/apiReference.php/listReferences', {
            method: 'POST',
            body: JSON.stringify({
            tableNameReference: 'persona',
            nameSpaceReference: 'tipo_persona',
            }),
            headers: {
            'Content-Type': 'application/json',
            },
        });

        const data = await response.json();
        const selectOptions = data.map((item) => ({
            value: item.referencia_id,
            label: item.referencia_valor,
        }));
        setOptions(selectOptions);
        } catch (error) {
        console.error('Error fetching options:', error);
        }
    };

    const handleSelectChange = (selectedOption) => {
        setSelectedOption(selectedOption);
    };

    return (
        <div>
        <Select
            options={options}
            value={selectedOption}
            onChange={handleSelectChange}
            placeholder="Tipo de persona"
        />
        </div>
    );

}