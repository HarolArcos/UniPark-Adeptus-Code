import React, {useEffect, useState} from "react";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import { Button, ButtonGroup, Form, Table } from "react-bootstrap";
import { CSVLink } from "react-csv";
import { useFetch } from "../../hooks/HookFetchListData";
import Modal from "../Modal/Modal";
import FormularioEmpleado from "./FormEmployee";
//import FormularioEmpleado from "./FormEmployee";
//import "./Persons.css";

export default function Employee(){   
   
    //const [searchTerm, setSearchTerm] = useState('');

    const [personas,setPersonas] =  useState([]);
    const {data, loading} = useFetch(
        'http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPerson'
    )
    
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

    // const handleSearch = (event) => {
    //     setSearchTerm(event.target.value);
    // };

    return(
        <>
        <Header></Header>
        <Aside></Aside>

        <div className="content-wrapper contenteSites-body">
        
                {localStorage.getItem("Error") ?
                <div className="text-danger">{localStorage.getItem("Error")}</div>
                
                :<span></span>}
            <div className="bodyItems">
                <div className="buttonSection">
                    <ButtonGroup className="buttonGroup">
                        <Button variant="success" className="button" onClick={() => handleCreate()} >+</Button>
                        <Button variant="success" className="button"> 
                            <CSVLink data={data} filename="Usuarios Unipark" className="csv"> Excel </CSVLink>
                        </Button>
                    </ButtonGroup>
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
                                    <tr key={persona.persona_id}>
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