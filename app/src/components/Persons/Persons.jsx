import React, {useEffect, useState} from "react";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import { Button, ButtonGroup, Form, Table } from "react-bootstrap";
//import { CSVLink } from "react-csv";
import { useFetch } from "../../hooks/HookFetchListData";
import Modal from "../Modal/Modal";
import FormularioPersona from './FormPersona';
import "./Persons.css";
//import axios from "axios";

export default function Persons(){   
   
    const [busqueda, setBusqueda] = useState("");
    const [clientes, setClientes] = useState([]);
    const [tablaClientes, setTablaClientes] = useState([])
    
    const [personas,setPersonas] =  useState([]);
    const {data} = useFetch(
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
    
        setTimeout(() => {
            localStorage.removeItem("Error")
           }, 3000)
       
    //----------------------ShowModal-------------------------------
    
    const [showCreate, setShowCreate] = useState(false);
    
    //----------------------Cliente para:-------------------------------
    //------Editar :
    useEffect(() => {
        setPersonas(data);
    }, [data]);
    
    //-----------------------Activate-------------------------------------------
    
    //-----Create Modal
    const handleCreate = () => {
        setShowCreate(true);
    };
    
    //---Desactive Any Modal
    const handleCancelar = () => {
        setShowCreate(false);
        console.log(data);
    };
    
    //-----------------------Crud-------------------------------------------
    //-------Crear
    const handleGuardarNuevo = (personaNueva) => {
        personaNueva.id = personas.lengthb;
            personas.push(personaNueva);
            const nuevasPersonas = personas;
        setPersonas(nuevasPersonas);
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

        <div className="content-wrapper contenteSites-body">
        
                {/* {localStorage.getItem("Error") ?
                <div className="text-danger">{localStorage.getItem("Error")}</div>
                
                :<span></span>} */}
            <div className="bodyItems">
                <div className="buttonSection">
                    <ButtonGroup className="buttonGroup">
                        <Button variant="success" className="button" onClick={() => handleCreate()} >+</Button>
                        {/* <Button variant="success" className="button"> 
                            <CSVLink data={data} filename="Usuarios Unipark" className="csv"> Excel </CSVLink>
                        </Button> */}
                    </ButtonGroup>
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
                            <th>Nombre Completo</th>
                            <th>Telefono</th>
                            <th> CI </th>
                            <th>Tipo Persona</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {/* {loading ? (
                            <tr>
                                <td colSpan={"3"} >Cargando...</td>
                            </tr>
                        ): ( */}
                            {
                                clientes.map((persona) => (
                                    <tr className="columnContent" key={persona.persona_id}>
                                        <td>{persona.persona_id}</td>
                                        <td>{persona.persona_nombre} {persona.persona_apellido}</td>
                                        <td>{persona.persona_telefono}</td>
                                        <td>{persona.persona_ci}</td>
                                        <td>{persona.personatipo}</td>
                                        <td>{persona.personaestado}</td>
                                    </tr>
                                ))
                            }
                        {/* )} */}
                    </tbody>
                </Table>
                

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
        <br></br>
        
        <Footer></Footer>
        </>
    )
}