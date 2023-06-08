import React ,{useState, useEffect}from 'react';
import Modal from '../Modal/Modal';
import Formulario from './FormTarifa';
import {Table, Button,ButtonGroup,Form, Image} from 'react-bootstrap';
import Header from '../Header/Header';
import Aside from '../Aside/Aside';
import Footer from '../Footer/Footer';
import { useSend } from '../../hooks/HookList';

import "./Tarifa.css"

export const TarifaList = () => {
    
  const [tarifas,setTarifas] = useState([]);

    const [error,setError] =  useState(null);
    const{data,fetchData} = useSend();
    
    //----------------------ShowModal-------------------------------
    
    const [showEdit, setShowEdit] = useState(false);
     
    const [showCreate, setShowCreate] = useState(false);
    
    //----------------------Cliente para:-------------------------------
    //------Editar :
    const [tarifaSeleccionado, setTarifaSeleccionado] = useState(null);

    useEffect(() => {
        fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRate/apiRate.php/listRate');
        console.log(data);
    }, []);
    
    useEffect(() => {
        if (data.desError) {
            setError("No existe ningúna tarifa registrada");
        }else{
            setTarifas(data);
        }
        console.log(data);
    }, [data]);

    //-----------------------Activate-------------------------------------------
    //------Edit Modal
    const handleEditar = (tarifa) => {
        setShowEdit(true);
        setTarifaSeleccionado(tarifa);
    };
    
    //-----Create Modal
    const handleCreate = () => {
        setShowCreate(true);
    };
    
    //---Desactive Any Modal
    const handleCancelar = async () => {
        setShowEdit(false);
        setShowCreate(false);
        console.log(data);
        await fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRate/apiRate.php/listRate');
        await fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRate/apiRate.php/listRate');
        await fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRate/apiRate.php/listRate');
        await fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRate/apiRate.php/listRate');
        
    };
 
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
                    />
                </div>
                <Table striped bordered hover className="table">
                    <thead>
                        <tr className="columnTittle">
                            <th>Id</th>
                            <th>Detalle</th>
                            <th>QR</th>
                        </tr>
                    </thead>
                    <tbody>
                        {error!=null ? (
                            <tr>
                                <td colSpan={"4"} >No existe Tarifas</td>
                            </tr>
                        ): (
                            tarifas.map((tarifa) => (
                                    <tr className="columnContent" key={tarifa.tarifa_id}>
                                        <td>{tarifa.tarifa_id}</td>
                                        <td>
                                            <ul>
                                                <li><strong>Plazo:</strong>{tarifa.tarifa_nombre}</li>
                                                <li><strong>Bs:</strong>{tarifa.tarifa_valor}</li>
                                                <li><strong>Estado:</strong>{tarifa.tarifa_estado}</li>
                                            </ul>
                                            </td>
                                        <td><Image src={tarifa.tarifa_ruta} alt="imagen qr" fluid className="custom-image" ></Image></td>
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
