import React from "react";
import {Form, Button} from "react-bootstrap";
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import { useState } from "react";
import "./Options.css";

export default function FormAddRol(){

    
    const { fetchData } = useFetchSendData();

    //const [statusRol, setStatusRol] = useState(11);
    const [nameRol, setNameRol] = useState('');
    const [descriptionRol, setDescriptionRol] = useState('');

    const handleSubmit = async (event) => {
        event.preventDefault();
    
        const formData = {
            statusRol: 15,
            nameRol: nameRol,
            descriptionRol: descriptionRol
        };

        fetchData("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRol/apiRol.php/insertRol", formData);
    };

    return(
        <Form className="FormAddRol" onSubmit={handleSubmit}>

                <Form.Group controlId="nameRol">
                    <Form.Label className="label">Nombre del Rol</Form.Label>
                    <Form.Control
                    type="text"
                    value={nameRol}
                    onChange={(event) => setNameRol(event.target.value)}
                    />
                </Form.Group>

                <Form.Group controlId="descriptionRol">
                    <Form.Label className="label">Description Rol</Form.Label>
                    <Form.Control
                    as="textarea"
                    value={descriptionRol}
                    onChange={(event) => setDescriptionRol(event.target.value)}
                    />
                </Form.Group>

                <Button variant="primary" type="submit">
                    Añadir Rol
                </Button>
                </Form>
    )
}