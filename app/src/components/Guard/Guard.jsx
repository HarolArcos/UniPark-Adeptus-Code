import React ,{useState}from 'react';
import Modal from '../Modal/Modal';
import Formulario from './FormGuard';
import {Table} from 'react-bootstrap';
import Header from '../Header/Header';
import Aside from '../Aside/Aside';
import Footer from '../Footer/Footer';

export const Guard = () => {

    const [guardias,setGuardias] =  useState([
        {id:2,nombre:'Robert',apellido: 'Soliz' ,ci:547842,telefono:71462654,telegram:6761221,nickName: 'rob@', email:'robert@gmail.com' ,listCar:[{id:1,placa:'1844KGG',modelo:'2000',color:'turqueza'},{id:2,placa:'0564PPO',modelo:1999,color:'azul'}]},
        {id:1,nombre:'Maria',apellido: 'Ramirez' ,ci:540042, email:'mari@gmail.com',listCar:[{id:8,placa:'2016KÑO',modelo:'2008',color:'negro'}]},
        {id:3,nombre:'Alex',apellido: 'Pardo' ,ci:700842, email:'alex@gmail.com',listCar:[{id:3,placa:'0132KÑO',modelo:'1995',color:'rojo'}]}
    ]);
    
   
    //----------------------ShowModal-------------------------------
    
    const [showEdit, setShowEdit] = useState(false);
     
    const [showCreate, setShowCreate] = useState(false);
     
    const [showView, setShowView] = useState(false);
    
    //----------------------Cliente para:-------------------------------
    //------Editar :
    const [guardiaSeleccionado, setGuardiaSeleccionado] = useState(null);
    //------Crear :
    const [guardiaNuevo, setGuardiaNuevo] = useState();


    
    
    //-----------------------Activate-------------------------------------------
    //------Edit Modal
    const handleEditar = (guardia) => {
        setShowEdit(true);
        setGuardiaSeleccionado(guardia);
    };
    
    //-----Create Modal
    const handleCreate = () => {
        setShowCreate(true);
    };

    //-----View Modal
    const handleView = (guardia) => {
        setShowView(true);
        setGuardiaSeleccionado(guardia);
    };
    
    //---Desactive Any Modal
    const handleCancelar = () => {
        setShowEdit(false);
        setShowCreate(false);
        setShowView(false);
        setGuardiaSeleccionado(null);
        setGuardiaNuevo(null);
    };
    
    //-----------------------Crud-------------------------------------------
    //------Edit
    const handleGuardarEditado = (guardiaEditado) => {
        const nuevosGuardias = guardias.map((guardia) =>
        guardia.id === guardiaEditado.id ? guardiaEditado : guardia
        );
        setGuardias(nuevosGuardias);
        setShowCreate(false);
        setGuardiaSeleccionado(null);
    };

    //-------Delete
    const handleEliminar = (id) => {
      const nuevosGuardias = guardias.filter((guardia) => guardia.id !== id);
      setGuardias(nuevosGuardias);
    };

    //-------Crear
    const handleGuardarNuevo = (guardiaNuevo) => {
        guardiaNuevo.id = guardias.lengthb;
         guardias.push(guardiaNuevo);
         const nuevosGuardias = guardias;
        setGuardias(nuevosGuardias);
      };
    


    console.log(guardias);

    return (
        <>
        <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper content-body">
            <div className='row'>
            <button className='col btn btn-primary btn-lg'   onClick={() => {handleCreate()}}>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
            </button>
            </div>
                
                <Table striped bordered hover className='table'>
                    <thead>
                        <tr>
                        <th>Nombre</th>
                        <th>Datos Personales</th>
                        <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {guardias.map(item =>(
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
                        <button className='btn btn-primary btn-md mr-1' onClick={() => handleView(item)} >
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
            mostrarModal={showView}
            title = 'Detalle Guardia '
            contend = {
            <Formulario
            asunto ='Guardar Cambios'
            guardia= {guardiaSeleccionado}
            cancelar={handleCancelar}
            soloLectura = {true}
            ></Formulario>}
            hide = {handleCancelar}
            >
            </Modal>

            <Modal
            mostrarModal={showEdit}
            title = 'Editar Guardia '
            contend = {
            <Formulario
            asunto ='Guardar Cambios'
            guardia= {guardiaSeleccionado}
            cancelar={handleCancelar}
            actualizarGuardia = {handleGuardarEditado}
            ></Formulario>}
            hide = {handleCancelar}
            >
            </Modal>
            

            <Modal
            mostrarModal={showCreate}
            title = 'Crear Nuevo Guardia'
            contend = {
            <Formulario
            asunto = "Guardar Guardia"
            cancelar={handleCancelar}
            añadirNuevo = {handleGuardarNuevo}
            ></Formulario>}
            hide = {handleCancelar}
            >
            </Modal>
        </div>
        <Footer></Footer>
        </>


    )
}
