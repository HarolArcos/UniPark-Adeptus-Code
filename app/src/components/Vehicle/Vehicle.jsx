import React ,{useState, useEffect}from 'react';
import Modal from '../Modal/Modal';
import Formulario from './FormVehicle';
import {Table, Button} from 'react-bootstrap';
import "./Vehicle.css"
import Header from '../Header/Header';
import Aside from '../Aside/Aside';
import Footer from '../Footer/Footer';
// import  "../../datos.json" ;
import { useFetch } from '../../hooks/HookFetchListData';

export const Vehicle = () => {
    
    const [vehiculos,setVehiculos] =  useState([]);
    const{data} = useFetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiVehicle/apiVehicle.php/listVehicle');
    
    //----------------------ShowModal-------------------------------
    
    const [showEdit, setShowEdit] = useState(false);
     
    const [showCreate, setShowCreate] = useState(false);
    
    //----------------------Cliente para:-------------------------------
    //------Editar :
    const [vehiculoSeleccionado, setVehiculoSeleccionado] = useState(null);

    
    
    useEffect(() => {
        setVehiculos(data);
        console.log(data);
    }, [data]);

    //-----------------------Activate-------------------------------------------
    //------Edit Modal
    const handleEditar = (vehiculo) => {
        setShowEdit(true);
        setVehiculoSeleccionado(vehiculo);
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
    const handleGuardarEditado = (vehiculoEditado) => {
        const nuevosVehiculos = vehiculos.map((vehiculo) =>
        vehiculo.id === vehiculoEditado.id ? vehiculoEditado : vehiculo
        );
        setVehiculos(nuevosVehiculos);
        setShowCreate(false);
        setVehiculoSeleccionado(null);
    };

    //-------Delete
    const handleEliminar = (id) => {
      const nuevosVehiculos = vehiculos.filter((vehiculo) => vehiculo.id !== id);
      setVehiculos(nuevosVehiculos);
    };

    //-------Crear
    const handleGuardarNuevo = (vehiculoNuevo) => {
        vehiculoNuevo.id = vehiculos.lengthb;
         vehiculos.push(vehiculoNuevo);
         const nuevosVehiculos = vehiculos;
        setVehiculos(nuevosVehiculos);
      };
    

    return (
        <>
        <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper content-body">
            <div className="buttonsGroup text-align-left">
                <Button className="button btn btn-primary btn-md mr-1" onClick={()=>handleCreate()}> +</Button>
            </div>
                <Table striped bordered hover className='table'>
                    <thead>
                        <tr>
                        <th>Propietario</th>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Color</th>
                        <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {vehiculos.map((item) =>(
                        <tr key ={item.vehiculo_id}>
                        <td>{item.propietario}</td>
                        <td>{item.vehiculo_placa}</td>
                        <td>{item.vehiculo_modelo}</td>
                        <td>{item.vehiculo_color}</td>
                        <td>
                            <button className='btn btn-primary btn-md mr-1' onClick={() => handleEditar(item)}>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fillRule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </button>

                            <button className='btn btn-primary btn-md mr-1'  onClick={() => handleEliminar(item.vehiculo_id)} >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-trash3" viewBox="0 0 16 16">
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
            title = 'Editar Vehiculo '
            contend = {
            <Formulario
            asunto ='Guardar Cambios'
            vehiculo= {vehiculoSeleccionado}
            cancelar={handleCancelar}
            actualizarVehiculo = {handleGuardarEditado}
            ></Formulario>}
            hide = {handleCancelar}
            >
            </Modal>
            

            <Modal
            mostrarModal={showCreate}
            title = 'Crear Nuevo Vehiculo'
            contend = {
            <Formulario
            asunto = "Guardar Vehiculo"
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
