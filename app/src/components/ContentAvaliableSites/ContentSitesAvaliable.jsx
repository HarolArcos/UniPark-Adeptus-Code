import React from "react";
import { Table } from "react-bootstrap";
import "./ContentSites.css";

export default function ContentSitesAvalible(){

    const datos = [
        { sitio: 'SITD13' },
        { sitio: 'SITD16' },
        { sitio: 'SITD16' },
        { sitio: 'SITD15' },
        { sitio: 'SITD16' },
        { sitio: 'SITD16' },
        { sitio: 'SITD15' },
        { sitio: 'SITD16' },
        { sitio: 'SITD16' }
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
                            <tr key={'sitesA'}>
                                <td>{dato.sitio}</td>
                                <td>Libre</td>
                            </tr>
                        ) )}
                </tbody>
            </Table>
        </div>
    )
}