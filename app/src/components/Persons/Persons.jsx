import React, {useEffect, useState} from "react";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import { Button, ButtonGroup, Form, Table } from "react-bootstrap";
import { CSVLink } from "react-csv";
import { useFetch } from "../../hooks/HookFetchListData";
import Modal from "../Modal/Modal";
import FormularioPersona from './FormPersona';
import "./Persons.css";

export default function Persons(){   
    const [searchTerm, setSearchTerm] = useState('');

    const [personas,setPersonas] =  useState([]);
    const {data, loading} = useFetch(
        'http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPerson'
    )

    //----------------------ShowModal-------------------------------
    
    const [showEdit, setShowEdit] = useState(false);
     
    const [showCreate, setShowCreate] = useState(false);
     
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
    const handleCreate = () => {
        setShowCreate(true);
    };
    
    //---Desactive Any Modal
    const handleCancelar = () => {
        setShowEdit(false);
        setShowCreate(false);
        console.log(data);
    };
    
    //-----------------------Crud-------------------------------------------
    //------Edit
    const handleGuardarEditado = (personaEditado) => {
        const nuevasPersonas = personas.map((persona) =>
        persona.id === personaEditado.id ? personaEditado : persona
        );
        setPersonas(nuevasPersonas);
        setShowCreate(false);
        setPersonaSeleccionado(null);
    };

    //-------Delete
    const handleEliminar = (id) => {
      const nuevasPersonas = personas.filter((persona) => persona.id !== id);
      setPersonas(nuevasPersonas);
    };

    //-------Crear
    const handleGuardarNuevo = (personaNueva) => {
        personaNueva.id = personas.lengthb;
            personas.push(personaNueva);
            const nuevasPersonas = personas;
        setPersonas(nuevasPersonas);
    };

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
                        <Button variant="success" className="button" onClick={() => handleCreate()} >+</Button>
                        <Button variant="success" className="button"> 
                            <CSVLink data={data} filename="Usuarios Unipark" className="csv"> Excel </CSVLink>
                        </Button>
                        <Button variant="success" className="button"> PDF </Button>
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
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Telefono</th>
                            <th> CI </th>
                            <th>Estado</th>
                            <th>Acciones</th>
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
                                        <td>{persona.persona_nombre}</td>
                                        <td>{persona.persona_apellido}</td>
                                        <td>{persona.persona_telefono}</td>
                                        <td>{persona.persona_ci}</td>
                                        <td>{persona.persona_estado}</td>
                                        <td className="actionsButtons">
                                            <button className='btn btn-success btn-md mr-1 ' onClick={() => handleEditar(persona)}>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fillRule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                            </button>

                                            <button className='btn btn-success btn-md mr-1 ' onClick={() => handleEliminar(persona.persona_id)}>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-person-dash-fill" viewBox="0 0 16 16">
                                                <path fillRule="evenodd" d="M11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z"/>
                                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
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
                <FormularioPersona
                asunto ='Guardar Cambios'
                persona= {personaSeleccionado}
                cancelar={handleCancelar}
                actualizarVehiculo = {handleGuardarEditado}
                ></FormularioPersona>}
                hide = {handleCancelar}
                >
                </Modal>
                

                <Modal
                mostrarModal={showCreate}
                title = 'Crear Nueva Persona'
                contend = {
                <FormularioPersona
                asunto = "Guardar Persona"
                cancelar={handleCancelar}
                añadirNuevo = {handleGuardarNuevo}
                ></FormularioPersona>}
                hide = {handleCancelar}
                >
                </Modal>
            </div>
        </div>
        
        <Footer></Footer>
        </>
    )
}