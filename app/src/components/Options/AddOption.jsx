import React, { useState, useEffect } from "react";
import { Form, Button, ListGroup, Row, Col, Alert } from "react-bootstrap";
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import ComboboxRoles from "./ComboboxRol";

export default function AddOptions() {
    const { fetchData } = useFetchSendData();
    const [showAlert, setShowAlert] = useState(false);
    const [selectedRolId, setSelectedRolId] = useState(null);
    const [options, setOptions] = useState([]);
    const [selectedOptions, setSelectedOptions] = useState([]);

    const handleRolIdChange = (personaId) => {
        setSelectedRolId(personaId);
    };

    useEffect(() => {
        fetchOptions();
    }, []);

    const fetchOptions = async () => {
        try {
        const response = await fetch(
            "http://adeptuscode.tis.cs.umss.edu.bo//UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiOption/apiOption.php/listOption"
        );
        const data = await response.json();
        setOptions(data);
        } catch (error) {
        console.log(error);
        }
    };

    const handleOptionChange = (optionId) => {
        const selectedOption = options.find((option) => option.opcion_id === optionId);

        if (selectedOption.opcion_padre !== "0") {
        const parentOption = options.find(
            (option) => option.opcion_id === selectedOption.opcion_padre
        );

        const isParentSelected = selectedOptions.includes(parentOption.opcion_id);

        if (!isParentSelected) {
            setSelectedOptions([...selectedOptions, parentOption.opcion_id]);
        }
        }

        const isSelected = selectedOptions.includes(optionId);
        if (isSelected) {
        setSelectedOptions(selectedOptions.filter((id) => id !== optionId));
        } else {
        setSelectedOptions([...selectedOptions, optionId]);
        }
    };

    const handleSaveOptions = () => {
        console.log("Opciones seleccionadas", selectedOptions);
        console.log("Esto es el rol id:",selectedRolId);

        fetchData("http://adeptuscode.tis.cs.umss.edu.bo//UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRolHasOption/apiRolHasOption.php/resetRolHasOptionWhitRolId", {
            idRol: selectedRolId
        });

        selectedOptions.forEach((optionId) => {
        const data = {
            idRol: selectedRolId,
            idOption: optionId,
        };
        console.log("el fetch se hara con esta data",data);
        fetchData(
            "http://adeptuscode.tis.cs.umss.edu.bo//UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRolHasOption/apiRolHasOption.php/insertRolHasOption",
            data
        );
        });
        setShowAlert(true);
    };

    const getOrderedOptions = () => {
        const orderedOptions = [];

        const parentOptions = options.filter((option) => option.opcion_padre === "0");
        parentOptions.sort((a, b) => parseInt(a.opcion_orden) - parseInt(b.opcion_orden));

        parentOptions.forEach((parentOption) => {
        orderedOptions.push(parentOption);

        const childrenOptions = options.filter(
            (option) => option.opcion_padre === parentOption.opcion_orden
        );
        childrenOptions.sort((a, b) => parseInt(a.opcion_orden) - parseInt(b.opcion_orden));
        orderedOptions.push(...childrenOptions);
        });

        return orderedOptions;
    };

    return (
        <div>
        {showAlert && (
            <Alert variant="success" onClose={() => setShowAlert(false)} dismissible>
            Opciones asignadas con éxito
            </Alert>
        )}
        <Row>
            <Col>
            <Form.Group className="comboboxRol">
                <Form.Label>
                <h3>Roles</h3>
                </Form.Label>
                <ComboboxRoles 
                     id={"roles"}
                     onRolIdChange={handleRolIdChange}
                 />
            </Form.Group>
            <h3 className="titleOptions">Opciones</h3>
            <span className="aviso"> Por favor seleccione la opción padre respectiva de la opcion que desea seleccionar </span>
            <Form>
                <Form.Group>
                {getOrderedOptions().map((option) => (
                    option.opcion_padre === "0"? (
                        <div className="opcionPadre">
                            <Form.Check
                            key={option.opcion_id}
                            type="checkbox"
                            id={option.opcion_id}
                            label={option.opcion_nombre}
                            checked={selectedOptions.includes(option.opcion_id)}
                            onChange={() => handleOptionChange(option.opcion_id)}
                        />
                        </div>
                    ):(
                        <Form.Check
                            className="opcionHija"
                            key={option.opcion_id}
                            type="checkbox"
                            id={option.opcion_id}
                            label={option.opcion_nombre}
                            checked={selectedOptions.includes(option.opcion_id)}
                            onChange={() => handleOptionChange(option.opcion_id)}
                        />
                    )
                ))}
                <br/>
                <br/>
                </Form.Group>
            </Form>
            </Col>
            <Col>
            <h3>Opciones seleccionadas:</h3>
            <ListGroup>
                {selectedOptions.map((optionId) => (
                    <ListGroup.Item key={optionId.opcion_id}>
                        {options.find((option) => option.opcion_id === optionId)?.opcion_nombre}
                    </ListGroup.Item>
                ))}
            </ListGroup>
            <Button onClick={handleSaveOptions}>Guardar opciones</Button>
            </Col>
            <br/>
        </Row>
        </div>
  );
}
