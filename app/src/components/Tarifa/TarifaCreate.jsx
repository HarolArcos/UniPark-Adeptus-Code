import React ,{useState, useEffect}from 'react';
import Modal from '../Modal/Modal';
import Formulario from './FormTarifa';
import Header from '../Header/Header';
import Aside from '../Aside/Aside';
import Footer from '../Footer/Footer';

import "./Tarifa.css"

export const TarifaCreate = ({show=null}) => {
    
    const [showCreate, setShowCreate] = useState(show);
        
    //---Desactive Any Modal
    const handleCancelar = async () => {
        setShowCreate(false);
    };
 
    return (
        <>
        <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper contenteSites-body">
            <div className="bodyItems">
                <Modal
	            tamaño ="md"
                mostrarModal={showCreate}
                title = 'Crear Nueva Tarifa'
                contend = {
                <Formulario
                asunto = "Guardar Tarifa"
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
