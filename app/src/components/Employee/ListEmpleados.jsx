import React from "react";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import { Form, Table } from "react-bootstrap";
//import { useFetch } from "../../hooks/HookFetchListData";
import { useState,useEffect } from "react";
import "./Employee.css";

export default function ListEmployee(){   

    const [busqueda, setBusqueda] = useState("");
    const [clientes, setClientes] = useState([]);
    const [tablaClientes, setTablaClientes] = useState([])

    // const {data, loading} = useFetch(
    //     'http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPersonEmployee'
    // )
    
    const getClients = async () => {
        await fetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPersonEmployee')
            .then(response => response.json())
            .then( response => {
                setClientes(response);
                setTablaClientes(response);
            })
            .catch( error => {
                console.log(error);
            })
    }

    useEffect(() => {
        getClients();
    }, []);
        setTimeout(() => {
            localStorage.removeItem("Error")
           }, 3000)
    
    /*--------------------- Barra Busqueda------------------------- */
    const handleChangeSerch = e => {
        setBusqueda(e.target.value);
        filtrar(e.target.value);
    }

    const filtrar = (termBusqueda) => {
        var resultadosBusqueda = tablaClientes.filter((elemento) => {
            if(
                    elemento.persona_id.toString().toLowerCase().includes(termBusqueda.toLowerCase())
                ||  elemento.persona_apellido.toString().toLowerCase().includes(termBusqueda.toLowerCase())
                ||  elemento.persona_nombre.toString().toLowerCase().includes(termBusqueda.toLowerCase())
                ||  elemento.persona_ci.toString().toLowerCase().includes(termBusqueda.toLowerCase())
            ){
                return elemento;
            }else{
                return null;
            }
        });
        setClientes(resultadosBusqueda);
    }
    return(
        <>
        <Header></Header>
        <Aside></Aside>

        <div className="content-wrapper contenteSites-body">
            <div className="bodyItems">
            {clientes.desError ? <label>No existen Empleados</label>
                :(<>
                <div className="buttonSection">
                    <Form.Control 
                        className="searchBar"
                        type="text"
                        placeholder="Buscar..."
                        value={busqueda}
                        onChange={handleChangeSerch}
                    />
                </div>
                
                <Table striped bordered hover className="table">
                    <thead>
                        <tr className="columnTittle">
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th> CI </th>
                            <th>Hora Ingreso</th>
                            <th>Hora Salida</th>
                            <th>Tipo Persona</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            clientes.map((persona) => (
                                    <tr className="columnContent" key={persona.persona_id}>
                                        <td>{persona.persona_id}</td>
                                        <td>{persona.persona_nombre} {persona.persona_apellido}</td>
                                        <td>{persona.persona_telefono}</td>
                                        <td>{persona.persona_ci}</td>
                                        <td>{persona.horario_entrada}</td>
                                        <td>{persona.horario_salida}</td>
                                        <td>{persona.personatipo}</td>
                                        <td>{persona.personaestado}</td>
                                    </tr>
                            ))
                        }
                    </tbody>
                </Table>
                </>)}
            </div>
        </div>    
        <Footer></Footer>
        </>
    )
}