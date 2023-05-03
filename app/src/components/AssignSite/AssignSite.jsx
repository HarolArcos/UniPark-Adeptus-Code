import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import { useState } from "react";
import { Form, Button } from "react-bootstrap";
import "./AssignSite.css";


export default function AssignSite() {

    const datos = [
        { id:'01', sitio: 'SITD13', nombre: 'Carlos',    apellido:'Campos Gutierrez',      tiempo: '02/06/23' },
        { id:'02', sitio: 'SITD16', nombre: 'Ivan',      apellido:'Orellana Sandoval',     tiempo: '15/06/23' },
        { id:'03', sitio: 'SITD16', nombre: 'Juan',      apellido:'Ramirez Rojas',         tiempo: '26/03/23' },
        { id:'04', sitio: 'SITD15', nombre: 'Luciana',   apellido:'Gutierrez Cortez',      tiempo: '02/03/23' },
        { id:'05', sitio: 'SITD16', nombre: 'Roberto',   apellido:'Lazarte Rosas',         tiempo: '24/06/23' }
    ];

    return(
        <>
        <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper contentAssignSites-body">
            <Form className="selectForm">
                <Form.Label> Cliente </Form.Label>
                <Form.Select aria-label="Default select example" className="selectItem" >
                    <option>-Seleccione al cliente-</option>
                    {datos.map( (dato) => (
                        <option> {dato.nombre} {dato.apellido} </option>
                    ))}
                </Form.Select>
                <Form.Label> Sitio </Form.Label>
                <Form.Select aria-label="Default select example" className="selectItem">
                    <option>-Seleccione el sitio-</option>
                    {datos.map( (dato) => (
                        <option> {dato.sitio} </option>
                    ))}
                </Form.Select>
                <Form.Label> Tiempo </Form.Label>
                <Form.Select className="selectItem" >
                    <option> -Seleccione el tiempo- </option>
                    <option> 1 meses </option>
                    <option> 3 meses </option>
                    <option> 6 meses </option>
                    <option> 1 año </option>
                </Form.Select>
                <Button className="submitButton" variant="primary" type="submit">
                    Asignar
                </Button>
            </Form>
        </div>
        <Footer></Footer>
        </>
    )
}