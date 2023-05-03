import React ,{useState}from 'react';
import Modal from '../Modal/Modal';
import Formulario from './AddFormClient';
import {Table} from 'react-bootstrap';


export const Client = () => {

    
    
    console.log('paso por aca');
    //Abrir o mostrar Modal
    
    
    
    const [clientes,setClientes] =  useState([
        {id:2,nombre:'Robert',apellido: 'Soliz' , email:'robert@gmail.com' },
        {id:1,nombre:'Maria',apellido: 'Ramirez' , email:'mari@gmail.com'},
        {id:3,nombre:'Alex',apellido: 'Pardo' , email:'alex@gmail.com'}
    ]);
    
   
    //----------------------ShowModal-------------------------------
    
    const [showEdit, setShowEdit] = useState(false);
    // const handleShowEdit = () =>setShowEdit(true);
    // const handleCloseEdit = () =>setShowEdit(false);
     
    const [showCreate, setShowCreate] = useState(false);
    // const handleShowCreate = () =>setShowCreate(true);
    // const handleCloseCreate = () =>setShowCreate(false);
     
    
    //----------------------Cliente para:-------------------------------
    //------Editar :
    const [clienteSeleccionado, setClienteSeleccionado] = useState(null);
    //------Crear :
    const [clienteNuevo, setClienteNuevo] = useState(null);


    
    
    //-----------------------Activate-------------------------------------------
    //------Edit Modal
    const handleEditar = (cliente) => {
        setShowEdit(true);
        setClienteSeleccionado(cliente);
    };
    
    //-----Create Modal
    const handleCreate = () => {
        setShowCreate(true);
        
    };
    
    //---Desactive Any Modal
    const handleCancelar = () => {
        setShowEdit(false);
        setShowCreate(false);
        setClienteSeleccionado(null);
        setClienteNuevo(null);
    };
    
    //-----------------------Crud-------------------------------------------
    //------Edit
    const handleGuardarEditado = (clienteEditado) => {
        const nuevosClientes = clientes.map((cliente) =>
        cliente.id === clienteEditado.id ? clienteEditado : cliente
        );
        setClientes(nuevosClientes);
        setShowCreate(false);
        setClienteSeleccionado(null);
    };

    //-------Delete
    const handleEliminar = (id) => {
      const nuevosClientes = clientes.filter((cliente) => cliente.id !== id);
      setClientes(nuevosClientes);
    };

    //-------Crear
    const handleGuardarNuevo = (clienteNuevo) => {
        clienteNuevo.id = clientes.lengthb;
         clientes.push(clienteNuevo);
         const nuevosClientes = clientes;
        setClientes(nuevosClientes);
      };
    


    console.log(clientes);

    return (
        <div className="content-wrapper ">
            <button className='btn btn-primary btn-lg mr-1'   onClick={() => {handleCreate()}}>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
            </button>
            <button className='btn btn-primary btn-lg mr-1'  >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
            </button>
                
                <Table striped bordered hover>
                    <thead>
                        <tr>
                        <th>Nombre</th>
                        <th>Datos</th>
                        <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {clientes.map(item =>(
                        <tr key ={item.id}>
                        <td>{item.nombre}</td>
                        <td>
                            <ul>
                                <li>{item.nombre}</li>
                                <li>{item.apellido}</li>
                                <li>{item.email}</li>
                            </ul>
                        </td>
                        <td>
                        <button className='btn btn-primary btn-md mr-1'  >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg> 

                        </button>

                        <button className='btn btn-primary btn-md mr-1' onClick={() => handleEditar(item)}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg> 
                        </button>


                        <button className='btn btn-primary btn-md mr-1'  onClick={() => handleEliminar(item.id)} >
                            

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                            </svg>
                        </button>
                        </td>
                        
                        </tr>
                        ))}
                    </tbody>
                </Table>
            
            <Modal
            mostrarModal={showEdit}
            title = 'Editar cliente neida'
            contend = {
            <Formulario
            asunto ='Guardar Cambios'
            cliente= {clienteSeleccionado}
            cancelar={handleCancelar}
            actualizarCliente = {handleGuardarEditado}
            ></Formulario>}
            hide = {handleCancelar}
            >
            </Modal>
            

            <Modal
            mostrarModal={showCreate}
            title = 'Crear Nuevo Cliente'
            contend = {
            <Formulario
            nuevoCliente= {clienteNuevo}
            asunto = "Guardar Cliente"
            cancelar={handleCancelar}
            añadirNuevo = {handleGuardarNuevo}
            ></Formulario>}
            hide = {handleCancelar}
            >
            </Modal>
        </div>


    )
}
