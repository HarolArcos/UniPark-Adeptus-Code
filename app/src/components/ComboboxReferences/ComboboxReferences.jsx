import React, { useEffect } from "react";
import Select from "react-select";
//import { useEffect } from "react";
import { useState } from "react";
import "./ComboboxReferences.css";
import { useFetchSendData } from "../../hooks/HookFetchSendData";

export default function ComboboxReferences(){ 
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
        console.log(data);
    }, [data]);
    console.log(data, 'valores');

    return(
        // <div className="combobox">
        //     <Select
        //         placeholder="Seleccione Referencia"
        //         options={ options }
        //     ></Select>
        // </div>
        <div>
            <Select
                options={options}
                value={selectedOption}
                onChange={handleOptionChange}
            />
            {options.length > 0 && (
                <Select
                options={options}
                />
            )} 
        </div>    
    )
}