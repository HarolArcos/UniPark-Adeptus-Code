import React from "react";
import { Table } from "react-bootstrap";
import "./ContentSites.css";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import { useEffect, useState } from "react";

export default function ContentSitesAvalible(){

    const [datos, setData] = useState([]);

    useEffect(() => {
        fetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiSubscription/apiSubscription.php/listDisponibles')
            .then(response => response.json())
            .then(data => setData(data))
            .catch(error => console.error(error));
    }, []);
    

    return(
        <>
            <Header></Header>
            <Aside></Aside>
            <div className="content-wrapper contenteSites-body" >
            <Table striped bordered hover className="table">
                <thead>
                    <tr>
                    <th>Sitio</th>
                    <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                        {datos.map((dato) => (
                            <tr key={dato.numeros}>
                                <td>{dato.numeros}</td>
                                <td>Libre</td>
                            </tr>
                        ) )}
                </tbody>
            </Table>
        </div>
        <Footer></Footer>
        </>
    )
}