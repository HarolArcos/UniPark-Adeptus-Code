import React from "react";
import { Button, Table } from "react-bootstrap";
import { CSVLink } from "react-csv";

import "../ContentAvaliableSites/ContentSites.css";

export default function ContentUnavalible(){

    const datos = [
        { sitio: 'SITD13', nombre: 'Carlos',    apellido:'Campos Gutierrez',      tiempo: '02/06/23' },
        { sitio: 'SITD16', nombre: 'Ivan',      apellido:'Orellana Sandoval',     tiempo: '15/06/23' },
        { sitio: 'SITD16', nombre: 'Juan',      apellido:'Ramirez Rojas',         tiempo: '26/03/23' },
        { sitio: 'SITD15', nombre: 'Luciana',   apellido:'Gutierrez Cortez',      tiempo: '02/03/23' },
        { sitio: 'SITD16', nombre: 'Roberto',   apellido:'Lazarte Rosas',         tiempo: '24/06/23' },
        { sitio: 'SITD16', nombre: 'Anna',      apellido:'Quisbert Gonzales',     tiempo: '13/03/23' },
        { sitio: 'SITD15', nombre: 'Carmen',    apellido:'Zeballos Mendez',       tiempo: '01/06/23' },
        { sitio: 'SITD16', nombre: 'Susana',    apellido:'Lozano Lautaro',        tiempo: '02/01/23' },
        { sitio: 'SITD16', nombre: 'Alejandra', apellido:'Campos Fernandez',      tiempo: '31/06/23' }
    ];

    return(
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
                    <th>Sitio</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Termina</th>
                    </tr>
                </thead>
                <tbody>
                    {/* <tr>
                    <td>1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    </tr> */}
                        {datos.map((dato) => (
                            <tr key={'sites'}>
                                <td>{dato.sitio}</td>
                                <td>{dato.nombre}</td>
                                <td>{dato.apellido}</td>
                                <td>{dato.tiempo}</td>
                            </tr>
                        ) )}
                </tbody>
            </Table>
        </div>
    )
}