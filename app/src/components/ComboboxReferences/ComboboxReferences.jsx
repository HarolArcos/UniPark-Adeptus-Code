import React from "react";
import Select from "react-select";
import { useEffect } from "react";
import { useState } from "react";
import "./ComboboxReferences.css";

export default function ComboboxReferences(){ 
    const [options, setOptions] = useState([]);

    useEffect(() => {
        fetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPerson')
        .then(response => response.json())
        .then(data => {
            const newOptions = data.map(item => ({
            value: item.persona_id,
            label: item.persona_nombre
            }));
            setOptions(newOptions);
        })
        .then( options => console.log(options))
        .catch(error => console.error(error));
    }, []);

    return(
        <div className="combobox">
            <Select 
                placeholder="Seleccione Referencia"
                options={ options }
            ></Select>
        </div>    
    )
}