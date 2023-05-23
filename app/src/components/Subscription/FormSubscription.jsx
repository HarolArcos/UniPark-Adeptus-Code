
import React, { useEffect ,useState} from "react";
import { Form, Button,Modal , Image} from "react-bootstrap";
import {Formik, ErrorMessage } from 'formik';
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import ComboboxPerson from "../ComboboxPerson/ComboboxPerson";
import "./Subscription.css"
import ComboboxReferences from "../ComboboxReferences/ComboboxReferences";
import ComboboxAvaliableSites from "../ComboboxAvaliableSites/ComboboxAvaliableSites";
import ComboboxTarifa from "../ComboboxTarifa/ComboboxTarifa";
const Formulario = ({asunto,cancelar, suscripcion}) => {

  const {data,fetchData} = useFetchSendData();
  useEffect(() => {
    // console.log('Data actualizada o creada :', data);
  }, [data]);


  const [selectedPersonaId, setSelectedPersonaId] = useState(
    suscripcion ? suscripcion.persona_id : null
  );

  const [selectedReferenciaId, setSelectedReferenciaId] = useState(
    suscripcion ? suscripcion.suscripcion_estado : null
  );

  const [selectedSiteId, setSelectedSiteId] = useState(
    suscripcion ? suscripcion.suscripcion_numero_parqueo : null
  );

  const [selectedTarifa, setSelectedTarifa] = useState(null);

  //------------HandlePersona
  const handlePersonaIdChange = (personaId) => {
    setSelectedPersonaId(personaId);
  };

  const handleReferenciaIdChange = (referenciaId) => {
    setSelectedReferenciaId(referenciaId);
  };
  
  //------------HandleSitio

  const handleSiteIdChange = (siteId) => {
    setSelectedSiteId(siteId);
  };

  const handleTarifaChange = (tarifa) => {
    setSelectedTarifa(tarifa);
  };

  console.log(suscripcion,selectedTarifa);

  return (
    <Formik
    initialValues={
      suscripcion? {
      idSubscription:         suscripcion.suscripcion_id   ,
      idTarifa:               suscripcion.tarifa_id ,
      idPerson:               suscripcion.persona_id,
      statusSubscription:     suscripcion.suscripcion_estado ,
      activationSubscription: suscripcion.suscripcion_activacion ,
      expirationSubscription: suscripcion.suscripcion_expiracion ,
      numParkSubscription:    suscripcion.suscripcion_numero_parqueo ,
      }:{
      idTarifa: '1',
      idPerson: '',
      statusSubscription: '',
      activationSubscription: '',
      expirationSubscription:'',
      numParkSubscription:''
      }}
    
    validate={values => {
      const errors = {};

      if(!selectedPersonaId){
        errors.idPerson ='Seleccione un elemento porfavor';
      }

      if(!values.activationSubscription){
        errors.activationSubscription ='El campo es requerido';
      }


      if(!values.expirationSubscription){
        errors.expirationSubscription ='El campo es requerido';
      }

      if(!selectedSiteId){
        errors.numParkSubscription ='Seleccione un elemento porfavor';
      }

      if(!selectedReferenciaId){
        errors.statusSubscription ='Seleccione un elemento porfavor';
      }
      
      console.log(errors);
      return errors;
    }}
    

    onSubmit={async (values) => {
      if (suscripcion) {
        values.idPerson = selectedPersonaId;
        values.statusSubscription = selectedReferenciaId;
        values.numParkSubscription = selectedSiteId;
        values.idTarifa = selectedTarifa;
        console.log(values,selectedPersonaId);
        fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiSubscription/apiSubscription.php/editSubscription',values);
        cancelar();
        
      } else {
        values.idPerson = selectedPersonaId;
        values.statusSubscription= selectedReferenciaId;
        values.numParkSubscription = selectedSiteId;
        values.idTarifa = selectedTarifa;
        console.log(values,selectedPersonaId);
        fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiSubscription/apiSubscription.php/insertSubscription',values);
        cancelar();
      }

    }
    }

    >

      {({values,errors,handleBlur,handleChange,handleSubmit})=>(
        <Form  className="container">

          <Form.Group className="inputGroup" controlId="activationSubscription text-left">
            <div className="row align-items-center">
            <Form.Label className="text-left col-sm-4">Fecha de Activación</Form.Label>
              <div className="col-sm-8">
                <Form.Control 
                  type="datetime-local" 
                  name="activationSubscription"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.activationSubscription}
                />
                <ErrorMessage name="activationSubscription" component={()=>(<div className="text-danger">{errors.activationSubscription}</div>)}></ErrorMessage>
              </div>
            </div>
          </Form.Group>
          
          <Form.Group className="inputGroup" controlId="expirationSubscription">
          <div className="row align-items-center">
          <Form.Label className="text-left col-sm-4">Fecha de Expiración</Form.Label>
            <div className="col-sm-8">
              <Form.Control 
                type="datetime-local"
                name="expirationSubscription"
                onChange={handleChange}
                onBlur={handleBlur} 
                value={values.expirationSubscription } 
              />
              <ErrorMessage name="expirationSubscription" component={()=>(<div className="text-danger">{errors.expirationSubscription}</div>)}></ErrorMessage>
            </div>
          </div>
          </Form.Group>
          
          
          
          <br/>
          <Form.Group className="inputGroup" controlId="idPerson">
          <div className="row align-items-center">
          <Form.Label className="text-left col-sm-4">Cliente</Form.Label>
            <div className="col-sm-8">
              <ComboboxPerson 
                id={suscripcion ? suscripcion.persona_id : null}
                onPersonaIdChange={handlePersonaIdChange}
              />
              <ErrorMessage name="idPerson" component={()=>(<div className="text-danger">{errors.idPerson}</div>)}></ErrorMessage>
            </div>
          </div>
          </Form.Group>
          
          <br/>
          <Form.Group className="inputGroup" controlId="statusSubscription">
          <div className="row align-items-center">
          <Form.Label className="text-left col-sm-4">Estado</Form.Label>
            <div className="col-sm-8">
            <ComboboxReferences 
              referenciaObjeto = {{tableNameReference:"suscripcion",nameSpaceReference:"suscripcion_estado"}}
              defaultValor={suscripcion? {value:suscripcion.suscripcion_estado,label:suscripcion.referencia_valor}:null}
              onReferenciaIdChange={handleReferenciaIdChange}
            />
            <ErrorMessage name="statusSubscription" component={()=>(<div className="text-danger">{errors.statusSubscription}</div>)}></ErrorMessage>
            </div>
          </div>
          </Form.Group>
          
          <br/>
          
          <Form.Group className="inputGroup" controlId="numParkSubscription">
          <div className="row align-items-center">
          <Form.Label className="text-left col-sm-4">Número de Parqueo</Form.Label>
            <div className="col-sm-8">
            <ComboboxAvaliableSites
              nro = {suscripcion? suscripcion.suscripcion_numero_parqueo:null}
              onSiteIdChange = {handleSiteIdChange}
            />
            <ErrorMessage name="numParkSubscription" component={()=>(<div className="text-danger">{errors.numParkSubscription}</div>)}></ErrorMessage>
            </div>
          </div>
          </Form.Group>

          <br/>
          <Form.Group className="inputGroup" controlId="idTarifa">
            <div className="row align-items-center">
            <Form.Label className="text-left col-sm-4">Tarifa</Form.Label>
                <div className="col-sm-8">
                <ComboboxTarifa 
                    id={suscripcion ? suscripcion.tarifa_id : null}
                    onTarifaIdChange={handleTarifaChange}
                />
                </div>
            </div>
          </Form.Group>
          <ErrorMessage name="idTarifa" component={()=>(<div className="text-danger">{errors.idTarifa}</div>)}></ErrorMessage>

          <br/>
          <Modal.Footer >
            <Button variant="secondary" onClick={cancelar}>
              Cancelar
            </Button>
            <Button variant="success" className="button" onClick={handleSubmit}  >
              {asunto}
            </Button>
          </Modal.Footer>
        </Form>
      )}
    </Formik>
  );
};

export default Formulario;
