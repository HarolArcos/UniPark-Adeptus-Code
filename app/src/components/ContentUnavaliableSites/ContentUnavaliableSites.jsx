import React from "react";
import { Button, Table } from "react-bootstrap";
import { CSVLink } from "react-csv";
import { useEffect, useState } from "react";
import "../ContentAvaliableSites/ContentSites.css";
import Aside from "../Aside/Aside";
import Header from "../Header/Header";
import Footer from "../Footer/Footer";

export default function ContentUnavalible(){

    // const datos = [
    //     { id:'01', sitio: 'SITD13', nombre: 'Carlos',    apellido:'Campos Gutierrez',      tiempo: '02/06/23' },
    //     { id:'02', sitio: 'SITD16', nombre: 'Ivan',      apellido:'Orellana Sandoval',     tiempo: '15/06/23' },
    //     { id:'03', sitio: 'SITD16', nombre: 'Juan',      apellido:'Ramirez Rojas',         tiempo: '26/03/23' },
    //     { id:'04', sitio: 'SITD15', nombre: 'Luciana',   apellido:'Gutierrez Cortez',      tiempo: '02/03/23' },
    //     { id:'05', sitio: 'SITD16', nombre: 'Roberto',   apellido:'Lazarte Rosas',         tiempo: '24/06/23' },
    //     { id:'06', sitio: 'SITD16', nombre: 'Anna',      apellido:'Quisbert Gonzales',     tiempo: '13/03/23' },
    //     { id:'07', sitio: 'SITD15', nombre: 'Carmen',    apellido:'Zeballos Mendez',       tiempo: '01/06/23' },
    //     { id:'08', sitio: 'SITD16', nombre: 'Susana',    apellido:'Lozano Lautaro',        tiempo: '02/01/23' },
    //     { id:'09', sitio: 'SITD16', nombre: 'Alejandra', apellido:'Campos Fernandez',      tiempo: '31/06/23' }
    // ];

    const [datos, setData] = useState([]);

    useEffect(() => {
        fetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPerson')
            .then(response => response.json())
            .then(data => setData(data))
            .catch(error => console.error(error));
    }, []);
    

    return(
        <>
            <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper contenteSites-body" >
            <div className="buttonsGroup">
                <Button variant="success" className="button"> +</Button>
                <Button variant="success" className="button"> 
                    <CSVLink data={datos} filename="Usuarios Unipark" className="csv"> Excel </CSVLink>
                </Button>
                <Button variant="success" className="button"> PDF </Button>
            </div>
            <Table striped bordered hover className="table">
                <thead>
                    <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Telefono</th>
                    <th> CI </th>
                    </tr>
                </thead>
                <tbody>
                    {datos.map((persona) => (
                        <tr key={persona.persona_id}>
                            <td>{persona.persona_nombre}</td>
                            <td>{persona.persona_apellido}</td>
                            <td>{persona.persona_telefono}</td>
                            <td>{persona.persona_ci}</td>
                            <td></td>
                        </tr>
                    ) )}   
                </tbody>
            </Table>
        </div>
        <Footer></Footer>
        </>
    )
}