import React ,{useState, useEffect}from 'react';
import Modal from '../Modal/Modal';
import Formulario from './FormTarifa';
import {Table, Button,ButtonGroup,Form, Image} from 'react-bootstrap';
import Header from '../Header/Header';
import Aside from '../Aside/Aside';
import Footer from '../Footer/Footer';
import { useSend } from '../../hooks/HookList';

import "./Tarifa.css"

export const TarifaListCreate = ({crear=false}) => {
    
    
    const [busqueda, setBusqueda] = useState("");
    const [tarifas,setTarifas] = useState([]);
    const [tablaTarifas, setTablaTarifas] = useState([]);
    const [error,setError] =  useState(null);
    
    const{data,fetchData} = useSend();
    
    //----------------------ShowModal-------------------------------
    const [showCreate, setShowCreate] = useState(false);
    
    
    useEffect(() => {
        fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRate/apiRate.php/listRate');
        console.log(data);
    }, []);
    
    
    useEffect(()=>{
        cargarDatos();
    },[]);

    const cargarDatos = async ()=>{
        await fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRate/apiRate.php/listRate');
    }

    useEffect(() => {
        if (data.desError) {
            setError(data.desError);
        }else{
            setTarifas(data);
            setTablaTarifas(data);
        }
        console.log(data);
    }, [data]);

    
    
    //-----Create Modal
    const handleCreate = () => {
        setShowCreate(true);
    };
    
    //---Desactive Any Modal
    const handleCancelar = async () => {
        setShowCreate(false);
        console.log(data);
        cargarDatos();
    };

     /*--------------------- Barra Busqueda------------------------- */
     const handleChangeSerch = e => {
        setBusqueda(e.target.value);
        filtrar(e.target.value);

    }

    const filtrar = (termBusqueda) => {
        var resultadosBusqueda = tablaTarifas.filter((elemento) => {
            if(
                elemento.tarifa_nombre.toString().toLowerCase().includes(termBusqueda.toLowerCase())
                ||  elemento.tarifa_valor.toString().toLowerCase().includes(termBusqueda.toLowerCase())
                ||  elemento.tarifa_estado.toString().toLowerCase().includes(termBusqueda.toLowerCase())
            ){
                return elemento;
            }else{
                return null;
            }
        });
        setTarifas(resultadosBusqueda);
    }
 
    return (
        <>
        <Header></Header>
        <Aside></Aside>
        <div className="h-100 w-100 content-wrapper contenteSites-body">
            <div className="bodyItems">
                <div className="buttonSection">
                    {crear?(
                    <ButtonGroup className="buttonGroup">
                        <Button variant="success" className="button" onClick={() => handleCreate()} >+</Button>
                    </ButtonGroup>):(
                        <div></div>
                    )}
                    <Form.Control 
                        className="searchBar"
                        type="text"
                        placeholder="Buscar..."
                        value={busqueda}
                        onChange={handleChangeSerch}
                    />
                </div>
                <Table striped bordered   size="sm" >
                    <thead>
                        <tr className="columnTittle">
                            <th>Id</th>
                            <th>Detalle</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        {error!=null ? (
                            <tr>
                                <td colSpan={"6"} >{error}</td>
                            </tr>
                        ): (
                            tarifas.map((tarifa) => (
                                    <tr className="columnContent" key={tarifa.tarifa_id}>
                                        <td>{tarifa.tarifa_id}</td>
                                        <td >
                                            <div className="col d-flex justify-content-center align-items-center">
                                            <ul>

                                                <li><strong>Plazo:</strong>{tarifa.tarifa_nombre}</li>
                                                <li><strong>Bs:</strong>{tarifa.tarifa_valor}</li>
                                                <li><strong>QR:</strong></li>
                                                <Image src={tarifa.tarifa_ruta} alt="imagen qr" fluid className="custom-image" ></Image>
                                            </ul>
                                            </div>
                                        </td>
                                        
                                    </tr>
                            ))
                        )}
                    </tbody>
                </Table>
                <Modal
	            tamaño ="md"
                mostrarModal={showCreate}
                title = 'Crear Tarifa'
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
