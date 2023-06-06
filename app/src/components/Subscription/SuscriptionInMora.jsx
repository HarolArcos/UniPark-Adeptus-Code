import React ,{useState, useEffect}from 'react';
import {Table,Form} from 'react-bootstrap';
import Header from '../Header/Header';
import Aside from '../Aside/Aside';
import Footer from '../Footer/Footer';
import { useFetch } from '../../hooks/HookFetchListData';
import "./Subscription.css";


export const SubscriptionInMora = () => {
    
    const [busqueda, setBusqueda] = useState("");
    const [suscripciones,setSuscripciones] = useState([]);
    const [tablaSuscripciones, setTablaSuscripciones] = useState([]);
    const [error,setError] =  useState(null);
    
    const{data} = useFetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiSubscription/apiSubscription.php/listSubscriptionMora');
    //listSuscriptionInProcess
    
    
    //----------------------Cliente para:-------------------------------
    //------Editar :
    const [suscripcionSeleccionado, setSuscripcionSeleccionado] = useState(null);
    
    
    useEffect(() => {
        if (data.desError) {
            console.log(data);
            setError(data.desError);
        }else{
            setSuscripciones(data);
            setTablaSuscripciones(data);
        }
        console.log(data,suscripciones);
    }, [data]);

    
    

    const  obtenerFecha = (stringFechaHora) =>{
        console.log(stringFechaHora);
        const fechaHora = new Date(stringFechaHora);
        const fecha = fechaHora.toISOString().split('T')[0];
        console.log(fecha);
        return fecha;
      }
    
      /*--------------------- Barra Busqueda------------------------- */
    const handleChangeSerch = e => {
        setBusqueda(e.target.value);
        filtrar(e.target.value);

    }

    const filtrar = (termBusqueda) => {
        var resultadosBusqueda = tablaSuscripciones.filter((elemento) => {
            if(
                    elemento.suscripcion_id.toString().toLowerCase().includes(termBusqueda.toLowerCase())
                ||  elemento.cliente.toString().toLowerCase().includes(termBusqueda.toLowerCase())
                ||  elemento.suscripcion_numero_parqueo.toString().toLowerCase().includes(termBusqueda.toLowerCase())
            ){
                return elemento;
            }else{
                return null;
            }
        });
        setSuscripciones(resultadosBusqueda);
    }

    return (
        <>
        <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper contenteSites-body">
            <div className="bodyItems">
                <div className="buttonSection">
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
                            <th>Nro de Parqueo</th>
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
                                        <td>{obtenerFecha(suscripcion.suscripcion_activacion)}</td>
                                        <td>{obtenerFecha(suscripcion.suscripcion_expiracion)}</td>
                                        <td>{suscripcion.referencia_valor.charAt(0).toUpperCase()+suscripcion.referencia_valor.slice(1)}</td>
                                        <td>
                                            <ul>
                                                <li><strong>Tiempo:</strong> {suscripcion.tarifa_nombre}</li>
                                                <li><strong>Bs:</strong>    {suscripcion.tarifa_valor}</li>
                                            </ul>
                                        </td>
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
