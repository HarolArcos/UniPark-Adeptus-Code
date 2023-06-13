import React from "react";
import { Button, Table } from "react-bootstrap";
import { CSVLink } from "react-csv";
import { useEffect, useState } from "react";
import "../ContentAvaliableSites/ContentSites.css";
import Aside from "../Aside/Aside";
import Header from "../Header/Header";
import Footer from "../Footer/Footer";

export default function ContentUnavalible(){

    const [datos, setData] = useState([]);

    useEffect(() => {
        fetch('http://adeptuscode.tis.cs.umss.edu.bo//UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiSubscription/apiSubscription.php/listSubscription')
            .then(response => response.json())
            .then(data => setData(data))
            .catch(error => console.error(error));
    }, []);
    console.log(datos);
console.log(datos.desError);
    return(
        <>
            <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper contenteSites-body" >
            <div className="buttonsGroup">
                <Button variant="success" className="button">Añadir+</Button>
                {!datos.desError && <> <Button variant="success" className="button"> 
                    <CSVLink data={datos} filename="Usuarios Unipark" className="csv"> Excel </CSVLink>
                </Button>
                <Button variant="success" className="button"> PDF </Button> </>}
                
            </div>
            {datos.desError ? <label>No Existen Sitios Ocupados</label>:(
            <Table striped bordered hover className="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre Completo</th>
                        <th>Tarifa</th>
                        <th>Costo</th>
                        <th>Fecha Activación</th>
                        <th>Fecha Expiración</th>
                        <th>Sitio</th>
                    </tr>
                </thead>
                <tbody>
                    {datos.map((sub) => (
                        <tr key={sub.suscripcion_id}>
                            <td>{sub.persona_id}</td>
                            <td>{sub.cliente}</td>
                            <td>{sub.tarifa_nombre}</td>
                            <td>{sub.tarifa_valor}</td>
                            <td>{sub.suscripcion_activacion}</td>
                            <td>{sub.suscripcion_expiracion}</td>
                            <td>{sub.suscripcion_numero_parqueo}</td>
                        </tr>
                    ) )}   
                </tbody>
            </Table>)}
        </div>
        <Footer></Footer>
        </>
    )
}