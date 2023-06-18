import React from "react";
import { useState, useEffect } from "react";
import FormAddRol from "./FormAddRol";
import Modal from "../Modal/Modal";
import { Form, Button, ButtonGroup, Table } from "react-bootstrap";

export default function AddRolSection(){

    const [busqueda, setBusqueda] = useState("");
    const [roles, setroles] = useState([]);
    const [tablaroles, setTablaroles] = useState([])

    const getRoles = async () => {
        await fetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRol/apiRol.php/listRol')
            .then(response => response.json())
            .then( response => {
                setroles(response);
                setTablaroles(response);
            })
            .catch( error => {
            
            })
    }

    useEffect(() => {
        getRoles();
    }, []);
    

        setTimeout(() => {
            localStorage.removeItem("Error")
           }, 3000)
       
    //----------------------ShowModal-------------------------------
    
    const [showCreate, setShowCreate] = useState(false);
    
    //-----------------------Activate-------------------------------------------
    
    //-----Create Modal
    const handleCreate = () => {
        setShowCreate(true);
    };
    
    //---Desactive Any Modal
    const handleCancelar = () => {
        setShowCreate(false);
       
    };

    /*--------------------- Barra Busqueda------------------------- */
    const handleChangeSerch = e => {
        setBusqueda(e.target.value);
        filtrar(e.target.value);
    }

    const filtrar = (termBusqueda) => {
        var resultadosBusqueda = tablaroles.filter((elemento) => {
            if(
                    elemento.rol_nombre.toString().toLowerCase().includes(termBusqueda.toLowerCase())
                ||  elemento.estadorol.toString().toLowerCase().includes(termBusqueda.toLowerCase())
            ){
                return elemento;
            }else{
                return null;
            }
        });
        setroles(resultadosBusqueda);
    }

    return(
        <div>
        
                {/* {localStorage.getItem("Error") ?
                <div className="text-danger">{localStorage.getItem("Error")}</div>
                
                :<span></span>} */}
            <div className="bodyItems">
                <div className="buttonSection">
                    <ButtonGroup className="buttonGroup">
                        <Button variant="success" className="button" onClick={() => handleCreate()} >Añadir +</Button>
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
                            <th>Nombre del Rol</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                            {
                                roles.map((rol) => (
                                    <tr className="columnContent" key={rol.rol_id}>
                                        <td>{rol.rol_id}</td>
                                        <td>{rol.rol_nombre}</td>
                                        <td>{rol.rol_descripcion}</td>
                                        <td>{rol.estadorol}</td>
                                    </tr>
                                ))
                            }
                        {/* )} */}
                    </tbody>
                </Table>
                

                <Modal
                tamaño={"md"}
                mostrarModal={showCreate}
                title = 'Crear Nuevo Rol'
                contend = 
                {
                    <FormAddRol 
                    cancelar={handleCancelar}
                    asunto = "Guardar Rol"
                    >
                        
                    </FormAddRol>
                }
                hide = {handleCancelar}
                >
                </Modal>
            </div>
        </div>
    )
}