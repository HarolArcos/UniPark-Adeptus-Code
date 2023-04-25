import React from "react";
import { Table } from "react-bootstrap";
import "./ContentSites.css";

export default function ContentSitesAvalible(){

    const datos = [
        { id:'1', sitio: 'SITD13' },
        { id:'2', sitio: 'SITD16' },
        { id:'3', sitio: 'SITD16' },
        { id:'4', sitio: 'SITD15' },
        { id:'5', sitio: 'SITD16' },
        { id:'6', sitio: 'SITD16' },
        { id:'7', sitio: 'SITD15' },
        { id:'8', sitio: 'SITD16' },
        { id:'9', sitio: 'SITD16' }
    ];

    return(
        <div className="content-wrapper contenteSites-body" >
            <Table striped bordered hover className="table">
                <thead>
                    <tr>
                    <th>Sitio</th>
                    <th>Estado</th>
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
                            <tr key={dato.id}>
                                <td>{dato.sitio}</td>
                                <td>Libre</td>
                            </tr>
                        ) )}
                </tbody>
            </Table>
        </div>
    )
}