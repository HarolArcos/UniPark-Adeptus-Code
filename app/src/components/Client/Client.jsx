import React ,{useState}from 'react';
import Modal from '../Modal/Modal';
import Formulario from './FormClient';
import {Table} from 'react-bootstrap';
import "./Client.css"
import Header from '../Header/Header';
import Aside from '../Aside/Aside';
import Footer from '../Footer/Footer';
// import  "../../datos.json" ;
import { useFetch } from '../../hooks/HookFetchListData';
import { useFetchSendData } from '../../hooks/HookFetchSendData';

export const Client = () => {
    //----------------------ShowModal-------------------------------
    
    const [showEdit, setShowEdit] = useState(false);
     
    const [showCreate, setShowCreate] = useState(false);
     
    const [showView, setShowView] = useState(false);
    
    //----------------------Cliente para:-------------------------------
    //------Editar :
    const [clienteSeleccionado, setClienteSeleccionado] = useState(null);

    // console.log(datos);
    const [clientes,setClientes] =  useState([
        {id:2,nombre:'Robert',apellido: 'Soliz' ,ci:547842,telefono:71462654,telegram:6761221,nickName: 'rob@', email:'robert@gmail.com' ,listCar:[{id:1,placa:'1844KGG',modelo:'2000',color:'turqueza'},{id:2,placa:'0564PPO',modelo:1999,color:'azul'}]},
        {id:1,nombre:'Maria',apellido: 'Ramirez' ,ci:540042, email:'mari@gmail.com',listCar:[{id:8,placa:'2016KÑO',modelo:'2008',color:'negro'}]},
        {id:3,nombre:'Alex',apellido: 'Pardo' ,ci:700842, email:'alex@gmail.com',listCar:[{id:3,placa:'0132KÑO',modelo:'1995',color:'rojo'}]}
    ]);
    

        // function Insertar() {
        //     const { data,error } =  useFetchSendData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/insertPerson', {typePerson : 2, namePerson : "Pedro", lastNamePerson : "Arcos", ciPerson : "5295189", phonePerson: "59167418809", telegramPerson : "", statusPerson : 1, nicknamePerson : "lolii", passwordPerson : "abc123"});


        // console.log(data);

        // }
    // const{data,loading,error} = useFetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPerson');
    // console.log(data);

   


    
    
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

    //-----View Modal
    const handleView = (cliente) => {
        setShowView(true);
        setClienteSeleccionado(cliente);
    };
    
    //---Desactive Any Modal
    const handleCancelar = () => {
        setShowEdit(false);
        setShowCreate(false);
        setShowView(false);
        setClienteSeleccionado(null);
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
    


    //    console.log(clientes);

    return (
        <>
        <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper content-body">
            <div className='align-items-left'>
                <button className='col btn btn-primary btn-lg' type='submit' onClick={()=>handleCreate()} >
                    Añadir
                </button>
           
            </div>
                
                <Table striped bordered hover className='table'>
                    <thead>
                        <tr>
                        <th>Nombre</th>
                        <th>Datos Personales</th>
                        {/* <th>Datos Automovil(les)</th> */}
                        <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {clientes.map((item,index) =>(
                        <tr key ={item.id}>
                        <td>{item.nombre}</td>
                        <td>
                            <ul key={index} >
                                <li key={`1${index}`} >{item.nombre}</li>
                                <li key={`3${index}`} >{item.apellido}</li>
                                <li key={`4${index}`} >{item.email}</li>
                            </ul>
                        </td>
                        {/* <td>
                            {item.listCar?.map(i =>(
                            <ul >
                              <li>{i.placa}</li>
                              <li>{i.modelo}</li>
                              <li>{i.color}</li>
                            </ul>  
                            ))}
                        </td> */}
                        <td>
                        <button className='btn btn-primary btn-md mr-1' onClick={() => handleView(item)} >
                                Ver
                        </button>

                        <button className='btn btn-primary btn-md mr-1' onClick={() => handleEditar(item)}>
                            Editar
                        </button>


                        <button className='btn btn-primary btn-md mr-1'  onClick={() => handleEliminar(item.id)} >
                            

                            Eliminar
                        </button>
                        </td>
                        
                        </tr>
                        ))}
                    </tbody>
                </Table>
            
            <Modal
            mostrarModal={showView}
            title = 'Detalle Cliente '
            contend = {
            <Formulario
            asunto ='Guardar Cambios'
            cliente= {clienteSeleccionado}
            cancelar={handleCancelar}
            soloLectura = {true}
            ></Formulario>}
            hide = {handleCancelar}
            >
            </Modal>

            <Modal
            mostrarModal={showEdit}
            title = 'Editar Cliente '
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
            asunto = "Guardar Cliente"
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
