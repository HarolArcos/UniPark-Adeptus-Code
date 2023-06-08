import React from "react";
import { Form, Button, ListGroup, Row, Col, Alert } from 'react-bootstrap';
import { useState, useEffect } from "react";
import ComboboxRoles from "./ComboboxRol";
import { useFetchSendData } from "../../hooks/HookFetchSendData";

export default function AddOptions(){

    //const [rols, setRols]= useState([]);
    const [showAlert, setShowAlert] = useState(false);

    const [selectedRolId, setSelectedRolId] = useState(null);
    const { fetchData } = useFetchSendData();
    
    const handleRolIdChange = (personaId) => {
        setSelectedRolId(personaId);
    };
    
    const [options, setOptions] = useState([]);
    const [selectedOptions, setSelectedOptions] = useState([]);

    useEffect(() => {
        // Cargar las opciones desde la API al montar el componente
        fetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiOption/apiOption.php/listOption')
        .then(response => response.json())
        .then(data => setOptions(data))
        .catch(error => console.log(error));
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
        console.log("Opcionees seleccionadas",selectedOptions);
        selectedOptions.forEach(optionId => {
        const data = {
            idRol: selectedRolId,
            idOption: optionId
        };
        console.log(data);
        fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRolHasOption/apiRolHasOption.php/insertRolHasOption', data);
        });
        setShowAlert(true);
    };


    return(
        <div>
            {showAlert && (
            <Alert variant="success" onClose={() => setShowAlert(false)} dismissible>
            Opciones asignadas con éxito
            </Alert>
        )}
        <Row>
            <Col>
                <Form.Group className="comboboxRol">
                <Form.Label>Roles</Form.Label>
                <ComboboxRoles 
                    id={"roles"}
                    onRolIdChange={handleRolIdChange}
                />
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