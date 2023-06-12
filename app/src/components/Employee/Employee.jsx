import React, {useEffect, useState} from "react";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import { Button, ButtonGroup, Form, Table } from "react-bootstrap";
//import { CSVLink } from "react-csv";
import { useFetch } from "../../hooks/HookFetchListData";
import Modal from "../Modal/Modal";
import FormularioEmpleado from "./FormEmployee";
//import FormularioEmpleado from "./FormEmployee";
import "./Employee.css";

export default function Employee(){   
   
    const [busqueda, setBusqueda] = useState("");
    const [clientes, setClientes] = useState([]);
    const [tablaClientes, setTablaClientes] = useState([])

    const [personas,setPersonas] =  useState([]);
    const {data, loading} = useFetch(
        'http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPersonEmployee'
    )
    
        setTimeout(() => {
            localStorage.removeItem("Error")
           }, 3000)
    
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
            <div className="bodyItems">
                <div className="buttonSection">
                    <ButtonGroup className="buttonGroup">
                        <Button variant="success" className="button" onClick={() => handleCreate()} >Añadir +</Button>
                        {/* <Button variant="success" className="button"> 
                            <CSVLink data={data} filename="Usuarios Unipark" className="csv"> Excel </CSVLink>
                        </Button> */}
                    </ButtonGroup>
                    {!clientes.desError &&
                    <Form.Control 
                        className="searchBar"
                        type="text"
                        placeholder="Buscar..."
                        value={busqueda}
                        onChange={handleChangeSerch}
                    />}
                </div>
                {clientes.desError ? <label>No existen Empleados</label>
                :(<>
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
                                        <td>{persona.horario_entrada}</td>
                                        <td>{persona.horario_salida}</td>
                                        <td>{persona.personatipo}</td>
                                        <td>{persona.personaestado}</td>
                                    </tr>
                            ))
                        )}
                    </tbody>
                </Table>
                </>)}

                <Modal
                mostrarModal={showCreate}
                title = 'Crear Nuevo Empleado'
                contend = {
                <FormularioEmpleado
                asunto = "Guardar Empleado"
                cancelar={handleCancelar}
                añadirNuevo = {handleGuardarNuevo}
                ></FormularioEmpleado>}
                hide = {handleCancelar}
                >
                </Modal>
            </div>
        </div>
        
        <Footer></Footer>
        </>
    )
}