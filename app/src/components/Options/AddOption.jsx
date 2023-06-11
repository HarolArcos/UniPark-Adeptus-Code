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
        .then(console.log(options))
        .catch(error => console.log(error));
    }, []);

    // const getParentOptionId = (optionId) => {
    //     const option = options.find((o) => o.opcion_id === optionId);
    //     console.log("getParent",option.opcion_padre);
    //     return option ? Number(option.opcion_padre) : null;
    // };

    const handleOptionChange = (optionId) => {
        // Obtener la opción seleccionada
        const selectedOption = options.find((option) => option.opcion_id === optionId);
      
        // Verificar si es una opción hija
        if (selectedOption.opcion_padre !== "0") {
          // Obtener la opción padre correspondiente
          const parentOption = options.find(
            (option) => option.opcion_id === selectedOption.opcion_padre
          );
      
          // Verificar si el padre ya está seleccionado
          const isParentSelected = selectedOptions.includes(parentOption.opcion_id);
      
          // Si el padre no está seleccionado, agregarlo a las opciones seleccionadas
          if (!isParentSelected) {
            setSelectedOptions([...selectedOptions, parentOption.opcion_id]);
          }
        }
      
        // Manejar el cambio de estado de la opción seleccionada
        const isSelected = selectedOptions.includes(optionId);
        if (isSelected) {
          setSelectedOptions(selectedOptions.filter((id) => id !== optionId));
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
                <Form.Label><h3>Roles</h3> </Form.Label>
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