import React from "react";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import { Form, Table } from "react-bootstrap";
import { useFetch } from "../../hooks/HookFetchListData";
import "./Employee.css";

export default function ListEmployee(){   

    const {data, loading} = useFetch(
        'http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPersonEmployee'
    )
    
        setTimeout(() => {
            localStorage.removeItem("Error")
           }, 3000)
    
    return(
        <>
        <Header></Header>
        <Aside></Aside>

        <div className="content-wrapper contenteSites-body">
            <div className="bodyItems">
                <div className="buttonSection">
                    <Form.Control 
                        className="searchBar"
                        type="text"
                        placeholder="Buscar..."
                        // value={searchTerm}
                        // onChange={handleSearch}
                    />
                </div>
                
                <Table striped bordered hover className="table">
                    <thead>
                        <tr className="columnTittle">
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th> CI </th>
                            <th>Tipo Persona</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {loading ? (
                            <tr>
                                <td colSpan={"3"} >Cargando...</td>
                            </tr>
                        ): (
                            data.map((persona) => (
                                    <tr className="columnContent" key={persona.persona_id}>
                                        <td>{persona.persona_id}</td>
                                        <td>{persona.persona_nombre} {persona.persona_apellido}</td>
                                        <td>{persona.persona_telefono}</td>
                                        <td>{persona.persona_ci}</td>
                                        <td>{persona.personatipo}</td>
                                        <td>{persona.personaestado}</td>
                                    </tr>
                            ))
                        )}
                    </tbody>
                </Table>
            </div>
        </div>    
        <Footer></Footer>
        </>
    )
}