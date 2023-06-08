import React ,{useState, useEffect}from 'react';
import Modal from '../Modal/Modal';
import Formulario from './FormVehicle';
import {Table,Form} from 'react-bootstrap';// aqui se estaba importando esto: Button,ButtonGroup,Form
import Header from '../Header/Header';
import Aside from '../Aside/Aside';
import Footer from '../Footer/Footer';

import "./Vehicle.css"

export const VehicleCreate = ({show=null}) => {
    
    
    //----------------------ShowModal-------------------------------
    const [showCreate, setShowCreate] = useState(show);
    
    //---Desactive Any Modal
    const handleCancelar = async () => {
        setShowCreate(false);
    };

    /*--------------------- Barra Busqueda------------------------- */
   
    return (
        <>
        <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper contenteSites-body">
            <div className="bodyItems">

                <Modal
	            tamaño ="md"
                mostrarModal={showCreate}
                title = 'Crear Nuevo Vehiculo'
                contend = {
                <Formulario
                asunto = "Guardar Vehiculo"
                cancelar={handleCancelar}
                ></Formulario>}
                hide = {handleCancelar}
                >
                </Modal>
            </div>
        </div>

        <Footer></Footer>
        </>

    )
}
