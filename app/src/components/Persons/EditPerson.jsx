import React from "react";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import Modal from "../Modal/Modal";
import { Form, Table } from "react-bootstrap";
import { useState, useEffect } from "react";
//import FormularioPersona from "./FormPersona";
import { useFetch } from "../../hooks/HookFetchListData";
import FormularioEditarPersona from "./FormEditPerson";

export default function EditPerson(){
    const [busqueda, setBusqueda] = useState("");
    const [clientes, setClientes] = useState([]);
    const [tablaClientes, setTablaClientes] = useState([])

    const [personas,setPersonas] =  useState([]);
    const {data, loading} = useFetch(
        'http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPersonClient'
    )
    const getClients = async () => {
        await fetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPersonClient')
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
    //----------------------ShowModal-------------------------------
    
    const [showEdit, setShowEdit] = useState(false);
     
    //const [showCreate, setShowCreate] = useState(false);
     
    //----------------------Cliente para:-------------------------------
    //------Editar :
    const [personaSeleccionado, setPersonaSeleccionado] = useState(null);
        
    useEffect(() => {
        setPersonas(data);
        console.log(data);
    }, [data]);
    
    //-----------------------Activate-------------------------------------------
    //------Edit Modal
    const handleEditar = (persona) => {
        setShowEdit(true);
        setPersonaSeleccionado(persona);
    };
    
    //-----Create Modal
    // const handleCreate = () => {
    //     setShowCreate(true);
    // };
    
    //---Desactive Any Modal
    const handleCancelar = () => {
        setShowEdit(false);
        // setShowCreate(false);
        console.log(data);
    };
    
    //-----------------------Crud-------------------------------------------
    //------Edit
    const handleGuardarEditado = (personaEditado) => {
        const nuevasPersonas = personas.map((persona) =>
        persona.id === personaEditado.id ? personaEditado : persona
        );
        setPersonas(nuevasPersonas);
        //setShowCreate(false);
        setPersonaSeleccionado(null);
    };
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

            <div className="content-wrapper">
            <div className="bodyItems">
                <div className="buttonSection">
                    <Form.Control 
                        className="searchBar2"
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
                            <th>Nombre Completo</th>
                            <th>Telefono</th>
                            <th> CI </th>
                            <th>Tipo Persona</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        {loading ? (
                            <tr>
                                <td colSpan={"3"} >Cargando...</td>
                            </tr>
                        ): (
                            clientes.map((persona) => (
                                    <tr className="columnContent" key={persona.persona_id}>
                                        <td>{persona.persona_id}</td>
                                        <td>{persona.persona_nombre} {persona.persona_apellido}</td>
                                        <td>{persona.persona_telefono}</td>
                                        <td>{persona.persona_ci}</td>
                                        <td>{persona.personatipo}</td>
                                        <td>{persona.personaestado}</td>
                                        <td>
                                            <button className='btn btn-success btn-md mr-1 ' onClick={() => handleEditar(persona)}>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fillRule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                            ))
                        )}
                    </tbody>
                </Table>

                <Modal
                mostrarModal={showEdit}
                title = 'Editar Persona'
                contend = {
                <FormularioEditarPersona
                asunto ='Guardar Cambios'
                persona= {personaSeleccionado}
                cancelar={handleCancelar}
                actualizarPersona = {handleGuardarEditado}
                ></FormularioEditarPersona>}
                hide = {handleCancelar}
                >
                </Modal>
            </div>
            </div>

            <Footer></Footer>
        </>
    )
}