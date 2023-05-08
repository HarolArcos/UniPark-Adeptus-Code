import React from "react";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import { Button, ButtonGroup, Form, Table } from "react-bootstrap";
import { CSVLink } from "react-csv";
import { useFetch } from "../../hooks/HookFetchListData";
import { useState } from "react";
import "./Persons.css";

export default function Persons(){   

    const [searchTerm, setSearchTerm] = useState('');
    const {data, loading} = useFetch(
        'http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPerson'
    )

    const handleSearch = (event) => {
        setSearchTerm(event.target.value);
    };

    // const filteredData = data.filter( (person) => {
    //     return person.name.toLowerCase().includes( searchTerm.toLowerCase());
    // });

    return(
        <>
        <Header></Header>
        <Aside></Aside>

        <div className="content-wrapper contenteSites-body">
            <div className="bodyItems">
                <div className="buttonSection">
                    <ButtonGroup className="buttonGroup">
                        <Button variant="primary" className="button" type="submit"> +</Button>
                        <Button variant="primary" className="button"> 
                            <CSVLink data={data} filename="Usuarios Unipark" className="csv"> Excel </CSVLink>
                        </Button>
                        <Button variant="primary" className="button"> PDF </Button>
                    </ButtonGroup>
                    <Form.Control 
                        className="searchBar"
                        type="text"
                        placeholder="Buscar..."
                        value={searchTerm}
                        onChange={handleSearch}
                    />
                </div>
                <Table striped bordered hover className="table">
                    <thead>
                        <tr className="columnTittle">
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Telefono</th>
                            <th> CI </th>
                        </tr>
                    </thead>
                    <tbody>
                        {loading ? (
                            <tr>
                                <td colSpan={"3"} >Cargando...</td>
                            </tr>
                        ): (
                            data.map((persona) => (
                                    <tr key={persona.persona_id}>
                                        <td>{persona.persona_nombre}</td>
                                        <td>{persona.persona_apellido}</td>
                                        <td>{persona.persona_telefono}</td>
                                        <td>{persona.persona_ci}</td>
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