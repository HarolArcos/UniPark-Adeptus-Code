import React ,{useState, useEffect}from 'react';
import Modal from '../Modal/Modal';
import Formulario from './FormSolicitude';
import {Table, Button,ButtonGroup,Form} from 'react-bootstrap';
import Header from '../Header/Header';
import Aside from '../Aside/Aside';
import Footer from '../Footer/Footer';
import { useFetch } from '../../hooks/HookFetchListData';
import "./Solicitude.css"
import { useContext } from "react"
import { DataUser } from '../context/UserContext.jsx';

export const Solicitude = () => {
    // localStorage.setItem("use",JSON.stringify({
    //     persona_id: 3,
    //     persona_tipo: 2,
    //     persona_nombre: "Sara",
    //     persona_apellido: "Soliz",
    //     persona_ci: 5295189,
    //     persona_telefono: 59167418809,
    //     persona_telegram: "",
    //     persona_estado: 1,
    //     persona_nickname: "saraliz",
    //     persona_contraseña: "abc123",
    //     personatipo: "Auto",
    //     personaestado: "Auto"
    // }))
    const {userglobal} = useContext(DataUser);
    
    const [suscripcion,setSuscripcion] = useState(null);
    const [error,setError] =  useState(null);
    
    //solictar api : listSubscriptionUser FetchSendData()con el id del solicitante
    const{data} = useFetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiSubscription/apiSubscription.php/listSubscription');
    
    //----------------------ShowModal-------------------------------
    
    const [showMod, setShowMod] = useState(false);
     
    //----------------------Cliente para:-------------------------------
    //------Editar :
    const [suscripcionSeleccionado, setSuscripcionSeleccionado] = useState(null);
    
    useEffect(() => {
        if (data.desError) {
            setError("No existe ningún vehiculo registrado");
        }else{
             let mysus = data.filter(suscripcion => suscripcion.persona_id == userglobal.persona_id);
            ;
            setSuscripcion(mysus[0])
            console.log(mysus);
        }
        console.log(data,suscripcion);
    }, [data]);

    //-----------------------Activate-------------------------------------------
    //------Edit Modal
    const handleMod= () => {
        setShowMod(true);
    };
    
    
    //---Desactive Any Modal
    const handleCancelar = () => {
        setShowMod(false);
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
                { suscripcion!=null?(
                    <div className=" content-wrapper contenteSites-body ">
                        <Table striped bordered hover className="table">
                            <thead>
                                <tr key={suscripcion.suscripcion_id}>
                                <th>Solicitud </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr key="2">
                                <th>Estado: </th>
                                <th>{suscripcion.referencia_valor ==="en proceso"? "Su solicitud se esta procesando":suscripcion.referencia_valor ==="activo"? "Se encuentra vigente":"Se encuentra desactivada, consulte con el Administrador"}</th>
                                    
                                </tr>
                            </tbody>
                            <tbody>
                            <tr key="3">
                                <th>Fecha de Activación: </th>
                                <th>{obtenerFecha(suscripcion.suscripcion_activacion)}</th>
                                    
                                </tr>
                            </tbody>
                            <tbody>
                            <tr key="4">
                                <th>Fecha de Expiración: </th>
                                <th>{obtenerFecha(suscripcion.suscripcion_expiracion)}</th>
                                    
                                </tr>
                            </tbody>
                            <tbody>
                            <tr key="5">
                                <th>Sitio de Parqueo: </th>
                                <th>{suscripcion.suscripcion_numero_parqueo}</th>
                                    
                                </tr>
                            </tbody>
                            <tbody>
                            <tr key="6">
                                <th>Tiempo: </th>
                                <th>{suscripcion.tarifa_nombre}</th>
                                    
                                </tr>
                            </tbody>
                            <tbody>
                            <tr key="7">
                                <th>Costo Bs: </th>
                                <th>{suscripcion.tarifa_valor}</th>
                                    
                                </tr>
                            </tbody>
                        </Table>
                    </div>
                ):(
                    <div className="buttonSection">
                    <ButtonGroup className="buttonGroup">
                        <Button variant="success" className="button" onClick={() => handleMod()} >Envia una solicitud de parqueo</Button>
                    </ButtonGroup>
                    
                    </div>
                )}

                <Modal
	            tamaño ="md"
                mostrarModal={showMod}
                title = 'Solicitud'
                contend = {
                <Formulario
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
