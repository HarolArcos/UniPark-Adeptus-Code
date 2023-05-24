
import React, { useEffect ,useState} from "react";
import { Form, Button,Modal,Image } from "react-bootstrap";
import {Formik, ErrorMessage } from 'formik';
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import "./Solicitude.css"
import { useContext } from "react"
import { DataUser } from '../context/UserContext.jsx';
import ComboboxAvaliableSites from "../ComboboxAvaliableSites/ComboboxAvaliableSites";
import ComboboxTarifa from "../ComboboxTarifa/ComboboxTarifa";


const Formulario = ({cancelar}) => {
    const {userglobal} = useContext(DataUser);
    console.log(userglobal);
  

  
    const {data,fetchData} = useFetchSendData();
    useEffect(() => {
        console.log('Data actualizada o creada :', data);
    }, [data]);

    

    const [selectedTarifa, setSelectedTarifa] = useState(null);

    const [selectedSiteId, setSelectedSiteId] = useState(null);
    
    // const [selectedReferenciaId, setSelectedReferenciaId] = useState(null);
    //------------HandlePersona
    const handleTarifaChange = (tarifa) => {
        setSelectedTarifa(tarifa);
    };

    // const handleReferenciaIdChange = (referenciaId) => {
    //     setSelectedReferenciaId(referenciaId);
    //   };
    
    
    //------------HandleSitio

    const handleSiteIdChange = (siteId) => {
        setSelectedSiteId(siteId);
    };



    return (
        <Formik
        initialValues={{
        idTarifa: '',
        idPerson: userglobal.persona_id,
        statusSubscription: '15',
        activationSubscription: '',
        expirationSubscription:'',
        numParkSubscription:''
        }}
        
        validate={values => {
        const errors = {};

        if(!selectedTarifa){
            errors.idTarifa ='El campo es requerido';
        }

        if(!values.activationSubscription){
            errors.activationSubscription ='El campo es requerido';
        }


        if(!values.expirationSubscription){
            errors.expirationSubscription ='El campo es requerido';
        }

        if(!selectedSiteId){
            errors.numParkSubscription ='El campo es requerido';
        }
        
        console.log(errors);
        return errors;
        }}

        onSubmit={async (values) => {
            values.idTarifa =selectedTarifa.tarifa_id;
            values.numParkSubscription = selectedSiteId;
            console.log(values);
            //fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiSubscription/apiSubscription.php/insertSubscription',values);
            //cancelar();
        }}
        >

        {({values,errors,handleBlur,handleChange,handleSubmit})=>(
            <Form  className="container">

            <Form.Group className="inputGroup" controlId="activationSubscription text-left">
            <div className="row align-items-center">
            <Form.Label className="text-left col-sm-4">Fecha de Activación</Form.Label>
                <div className="col-sm-8">
                <Form.Control 
                    type="date" 
                    name="activationSubscription"
                    onChange={handleChange}
                    onBlur={handleBlur}
                />
                </div>
            </div>
            </Form.Group>
            <ErrorMessage name="activationSubscription" component={()=>(<div className="text-danger">{errors.activationSubscription}</div>)}></ErrorMessage>
            
            <Form.Group className="inputGroup" controlId="expirationSubscription">
            <div className="row align-items-center">
            <Form.Label className="text-left col-sm-4">Fecha de Expiración</Form.Label>
                <div className="col-sm-8">
                <Form.Control 
                    type="date"
                    name="expirationSubscription"
                    onChange={handleChange}
                    onBlur={handleBlur} 
                />
                </div>
            </div>
            </Form.Group>
            <ErrorMessage name="expirationSubscription" component={()=>(<div className="text-danger">{errors.expirationSubscription}</div>)}></ErrorMessage>
            
            <Form.Group className="inputGroup" controlId="numParkSubscription">
            <div className="row align-items-center">
            <Form.Label className="text-left col-sm-4">Número de Parqueo</Form.Label>
                <div className="col-sm-8">
                <ComboboxAvaliableSites
                onSiteIdChange = {handleSiteIdChange}
                />
                </div>
            </div>
            </Form.Group>
            <ErrorMessage name="numParkSubscription" component={()=>(<div className="text-danger">{errors.numParkSubscription}</div>)}></ErrorMessage>
            
            <br/>
            <Form.Group className="inputGroup" controlId="idTarifa">
            <div className="row align-items-center">
            <Form.Label className="text-left col-sm-4">Tarifa</Form.Label>
                <div className="col-sm-8">
                <ComboboxTarifa 
                    // id={suscripcion ? suscripcion.tarifa_id : null}
                    onTarifaIdChange={handleTarifaChange}
                />
                </div>
            </div>
            </Form.Group>
            <ErrorMessage name="idTarifa" component={()=>(<div className="text-danger">{errors.idTarifa}</div>)}></ErrorMessage>
                <div>
                {selectedTarifa == null ?(<br/>):(
                    <>
                    <h2 className="align-text-left">{selectedTarifa.tarifa_nombre}</h2>
                    <h2 className="align-text-left">{selectedTarifa.tarifa_valor}</h2>
                    <Image src={selectedTarifa.tarifa_ruta} alt="imagen qr" fluid />
                    </>
                )}
                </div>
          
            <Modal.Footer >
                <Button variant="secondary" onClick={cancelar}>
                Cancelar
                </Button>
                <Button variant="success" className="button" onClick={handleSubmit}  >
                Enviar Solicitud
                </Button>
            </Modal.Footer>
            </Form>
        )}
        </Formik>
    );
};

export default Formulario;
