import React from "react";
import { Form, Button, ListGroup, Row, Col } from 'react-bootstrap';
import { useState, useEffect } from "react";
import ComboboxRoles from "./ComboboxRol";

export default function AddOptions(){

    //const [rols, setRols]= useState([]);

    const [options, setOptions] = useState([]);
    const [selectedOptions, setSelectedOptions] = useState([]);
    const [selectedRoleId, setSelectedRoleId] = useState(1); // Valor inicial del combobox de Roles

    useEffect(() => {
        // Cargar las opciones desde la API al montar el componente
        fetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiOption/apiOption.php/listOption')
        .then(response => response.json())
        .then(data => setOptions(data))
        .catch(error => console.log(error));

        // fetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRol/apiRol.php/listRol')
        // .then(response => response.json())
        // .then(data => setRols(data))
        // .catch(error => console.log(error));
    }, []);

    const handleOptionChange = (optionId) => {
        // Manejar el cambio de estado de las opciones seleccionadas
        const isSelected = selectedOptions.includes(optionId);
        if (isSelected) {
        setSelectedOptions(selectedOptions.filter(id => id !== optionId));
        } else {
        setSelectedOptions([...selectedOptions, optionId]);
        }
    };

    const handleSaveOptions = () => {
        // Asociar las opciones seleccionadas al rol mediante la API
        selectedOptions.forEach(optionId => {
        const data = {
            idRol: selectedRoleId,
            idOption: optionId
        };

        fetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRolHasOption/apiRolHasOption.php/insertRolHasOption', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.log(error));
        //useFetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRolHasOption/apiRolHasOption.php/insertRolHasOption', data);
        });
    };


    return(
        <div>
        <Row>
            <Col>
                <Form.Group className="comboboxRol">
                <Form.Label>Roles</Form.Label>
                {/* <Form.Control
                className="comboboxRol"
                as="select"
                value={selectedRoleId}
                onChange={(e) => setSelectedRoleId(e.target.value)}
                >
                <option value={1}>Cliente</option>
                <option value={2}>Admin</option>
                <option value={3}>Guardia</option>
                </Form.Control> */}
                <ComboboxRoles />
            </Form.Group>
            <h3 className="titleOptions">Opciones</h3>
            <Form>
                <Form.Group>
                {options.map(option => (
                    <Form.Check
                    key={option.opcion_id}
                    type="checkbox"
                    id={option.opcion_id}
                    label={option.opcion_nombre}
                    checked={selectedOptions.includes(option.opcion_id)}
                    onChange={() => handleOptionChange(option.opcion_id)}
                    />
                ))}
                </Form.Group>
            </Form>
            </Col>
            <Col>            
                <h3>Opciones seleccionadas:</h3>
                <ListGroup>
                    {selectedOptions.map(optionId => (
                    <ListGroup.Item key={optionId}>
                        {options.find(option => option.opcion_id === optionId)?.opcion_nombre}
                    </ListGroup.Item>
                    ))}
                </ListGroup>
                <Button onClick={handleSaveOptions}>Guardar opciones</Button>
            </Col>
        </Row>
        </div>
    )
}