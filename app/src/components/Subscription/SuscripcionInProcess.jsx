import React ,{useState, useEffect}from 'react';
import Modal from '../Modal/Modal';
import Formulario from './FormSubscription';
import {Table, Button,ButtonGroup,Form} from 'react-bootstrap';
import Header from '../Header/Header';
import Aside from '../Aside/Aside';
import Footer from '../Footer/Footer';
import { useFetch } from '../../hooks/HookFetchListData';
import "./Subscription.css";


export const SubscriptionInProcess = () => {
    

    const [suscripciones,setSuscripciones] = useState([]);
    const [error,setError] =  useState(null);
    
    const{data} = useFetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiSubscription/apiSubscription.php/listSubscriptionInProgress');
    //listSuscriptionInProcess
    
    //----------------------ShowModal-------------------------------
    
    const [showEdit, setShowEdit] = useState(false);
    const [showCreate, setShowCreate] = useState(false);
    
    //----------------------Cliente para:-------------------------------
    //------Editar :
    const [suscripcionSeleccionado, setSuscripcionSeleccionado] = useState(null);
    
    
    useEffect(() => {
        if (data.desError) {
            console.log(data);
            setError(data.desError);
        }else{
            setSuscripciones(data);
        }
        console.log(data,suscripciones);
    }, [data]);

    //-----------------------Activate-------------------------------------------
    //------Edit Modal
    const handleEditar = (suscripcion) => {
        setShowEdit(true);
        setSuscripcionSeleccionado(suscripcion);
    };
    
    //-----Create Modal
    const handleCreate = () => {
        setShowCreate(true);
    };
    
    //---Desactive Any Modal
    const handleCancelar = () => {
        setShowEdit(false);
        setShowCreate(false);
    };
 

    const  obtenerFecha = (stringFechaHora) =>{
        console.log(stringFechaHora);
        const fechaHora = new Date(stringFechaHora);
        const fecha = fechaHora.toISOString().split('T')[0];
        console.log(fecha);
        return fecha;
      }

    return (
        <>
        <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper contenteSites-body">
            <div className="bodyItems">
                {/* <div className="buttonSection">
                    <ButtonGroup className="buttonGroup">
                        <Button variant="success" className="button" onClick={() => handleCreate()} >+</Button>
                        <Button variant="success" className="button"> PDF </Button>
                    </ButtonGroup>
                    <Form.Control 
                        className="searchBar"
                        type="text"
                        placeholder="Buscar..."
                    />
                </div> */}
                <Table striped bordered hover className="table">
                    <thead>
                        <tr className="columnTittle">
                            <th>Id</th>
                            <th>Número de Parqueo</th>
                            <th>Cliente</th>
                            <th>Fecha Activación</th>
                            <th>Fecha Expiración</th>
                            <th>Estado</th>
                            <th>Tarifa</th>
                            {/* <th>Acciones</th> */}
                        </tr>
                    </thead>
                    <tbody>
                        {error!=null ? (
                            <tr>
                                <td colSpan={"7"} >{error}</td>
                            </tr>
                        ): (
                            suscripciones.map((suscripcion) => (
                                    <tr className="columnContent" key={suscripcion.suscripcion_id}>
                                        <td>{suscripcion.suscripcion_id}</td>
                                        <td>{suscripcion.suscripcion_numero_parqueo}</td>
                                        <td>{suscripcion.cliente}</td>
                                        <td>{}</td>
                                        <td>{suscripcion.suscripcion_expiracion}</td>
                                        <td>{suscripcion.referencia_valor}</td>
                                        <td>
                                            <ul>
                                                <li>Tiempo: {suscripcion.tarifa_nombre}</li>
                                                <li>Bs :    {suscripcion.tarifa_valor}</li>
                                            </ul>
                                        </td>
                                        {/* <td className="actionsButtons">
                                            <button className='btn btn-success btn-md mr-1 ' onClick={() => handleEditar(suscripcion)}>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fillRule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                            </button>
                                        </td> */}
                                    </tr>
                            ))
                        )}
                    </tbody>
                </Table>
                
            </div>
        </div>
        <Footer></Footer>
        </>

    )
}
