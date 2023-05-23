import React ,{useState, useEffect}from 'react';
import {Table, Button,ButtonGroup,Form} from 'react-bootstrap';
import Header from '../Header/Header';
import Aside from '../Aside/Aside';
import Footer from '../Footer/Footer';
import { useFetch } from '../../hooks/HookFetchListData';
import "./Vehicle.css"

export const ListVehicle = () => {
    
    const [vehiculos,setVehiculos] =  useState([]);
    const [error,setError] =  useState(null);
    const{data} = useFetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiVehicle/apiVehicle.php/listVehicle');
    
    //----------------------ShowModal-------------------------------
    
    const [showEdit, setShowEdit] = useState(false);
     
    const [showCreate, setShowCreate] = useState(false);
    
    //----------------------Cliente para:-------------------------------
    //------Editar :
    const [vehiculoSeleccionado, setVehiculoSeleccionado] = useState(null);

    useEffect(() => {
        if (data.desError) {
            setError(data.desError);
        }else{
            setVehiculos(data);
        }
        
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
    };
 
    return (
        <>
        <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper contenteSites-body">
            <div className="bodyItems">
                <div className="buttonSection">
                    <ButtonGroup className="buttonGroup">
                        <Button variant="success" className="button" onClick={() => handleCreate()} >+</Button>
                        <Button variant="success" className="button"> PDF </Button>
                    </ButtonGroup>
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
                            <th>Placa</th>
                            <th>Propietario</th>
                            <th>Modelo</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                    <tbody>
                        {error!=null ? (
                            <tr>
                                <td colSpan={"5"} >{error}</td>
                            </tr>
                        ): (
                            vehiculos.map((vehiculo) => (
                                    <tr className="columnContent" key={vehiculo.vehiculo_id}>
                                        <td>{vehiculo.vehiculo_id}</td>
                                        <td>{vehiculo.vehiculo_placa}</td>
                                        <td>{vehiculo.propietario}</td>
		                                <td>{vehiculo.vehiculo_modelo}</td>
                                        <td>{vehiculo.vehiculo_color}</td>
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
