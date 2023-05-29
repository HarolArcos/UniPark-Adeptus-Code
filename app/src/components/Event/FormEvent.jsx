
import React, { useEffect ,useState} from "react";
import { Form, Button,Modal } from "react-bootstrap";
import {Formik, ErrorMessage } from 'formik';
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import ComboboxPersonaEvento from "./ComboboxPersonaEvento";
import ComboboxPlacas from "./ComboboxPlacas";
import ComboboxTipoEvento from "./ComboboxTipoEvento";

const FormEvent = ({asunto,cancelar, evento}) => {

  const {data,fetchData} = useFetchSendData();
  
  //añadidas new

  const [errorDuply, seterrorDuply] = useState(null);

  const [selectedPersonaId, setSelectedPersonaId] = useState(
    evento ? evento.vehiculo_persona_id : null
  );

  const [selectedVehicleId, setSelectedVehicleId] = useState(
    evento ? evento.vehiculo_id : null
  );

  const [selectedRefTypeEventId, setSelectedTypeEventId] = useState(
    evento ? evento.evento.referencia_valor : null
  );

  const handlePersonaIdChange = (personaId) => {
    setSelectedPersonaId(personaId);
  };

  const handleVehicleIdChange = (vehicleId) => {
    setSelectedVehicleId(vehicleId);
  };

  const handleTypeEventIdChange = (referenciaId) => {
    setSelectedTypeEventId(referenciaId);
    console.log(referenciaId);
  };
  //------------
  
  useEffect(() => {
    console.log(data);
    if (data.desError === "Inserción fallida, ya existe la placa") {
      console.log(data.desError);
      seterrorDuply(data.desError);
    }else if (data.desError === "Cambios realizados con exito" || data.desError === "Inserción exitosa"){
      cancelar();
    }
  }, [data, cancelar]);

  return (
    <Formik
    initialValues={
      evento? {
        idPerson : evento.vehiculo_persona_id,
        idVehicle :  evento.vehiculo_id,
        typeEvent :  evento.evento_tipo,
        alarmEvent : evento.evento_alarma,
        descriptionEvent : evento.evento_descripcion,
        registerUser : evento.propietario
      }:{
        idPerson : '',
        idVehicle :  '',
        typeEvent :  '',
        alarmEvent : 'false',
        descriptionEvent : '',
        registerUser : 'harex'
      }}
    
    validate={values => {
      const errors = {};

        if(!selectedPersonaId){
            errors.idPerson ='Seleccione un elemento porfavor';
        }

        if(!selectedVehicleId){
            errors.idVehicle ='Seleccione una placa porfavor';
        }

        if(!selectedRefTypeEventId){
            errors.typeEvent ='Seleccione el tipo de evento porfavor';
        }

        if(!values.descriptionEvent){
            errors.descriptionEvent ='El campo es requerido';
        }
    //   else if(!/^(?! )[A-Za-z]+( [A-Za-z]+)?$/i.test(values.descriptionEvent)){
    //     errors.descriptionEvent ='Solo se admite un espacio entre dos palabras'
    //   }

      return errors;
    }}
    

    onSubmit={async (values) => {
      if (evento) {
        values.idPerson = selectedPersonaId;
        values.idVehicle = selectedVehicleId;
        values.typeEvent = selectedRefTypeEventId;
        await fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiEvent/apiEvent.php/editEvent',values);
        console.log('editar:',values);
      } else {
        values.idPerson = selectedPersonaId;
        values.idVehicle = selectedVehicleId;
        values.typeEvent = selectedRefTypeEventId;
        await fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiEvent/apiEvent.php/insertEvent',values);
        console.log('no hubo duplicidad',errorDuply);
        window.location.reload();
      }

    }
    }

    >

      {({values,errors,handleBlur,handleChange,handleSubmit})=>(
        <Form  className="container">
            <Form.Group className="inputGroup" controlId="idPerson">
                <Form.Label className="text-left">Propietario</Form.Label>
                <ComboboxPersonaEvento 
                name="idPerson"
                id={evento? evento.vehiculo_persona_id:null}
                onPersonaIdChange={handlePersonaIdChange}
                onBlur={handleBlur}
                />
            </Form.Group>
            <ErrorMessage name="idVehicle" component={()=>(<div className="text-danger">{errors.idPerson}</div>)}></ErrorMessage>
            <Form.Group className="inputGroup" controlId="idVehicle">
                <Form.Label className="text-left">Placas Asociadas</Form.Label>
                <ComboboxPlacas
                    name="idVehicle"
                    id={evento? evento.vehiculo_id:null}
                    onVehicleIdChange={handleVehicleIdChange}
                    onBlur={handleBlur}
                />
            </Form.Group>
            <ErrorMessage name="idVehicle" component={()=>(<div className="text-danger">{errors.idVehicle}</div>)}></ErrorMessage>
            
            <Form.Group className="inputGroup" controlId="idPerson">
                <Form.Label className="text-left">Tipo de evento</Form.Label>
                <ComboboxTipoEvento
                    referenciaObjeto = {{tableNameReference:"evento",nameSpaceReference:"evento_tipo"}}
                    // defaultValor={evento? {value:evento.vehiculo_estado,label:evento.vehiculoestado}:null}
                    onReferenciaIdChange={handleTypeEventIdChange}
                />
            </Form.Group>
            <ErrorMessage name="idPerson" component={()=>(<div className="text-danger">{errors.idPerson}</div>)}></ErrorMessage>
              

            <Form.Group className="inputGroup" controlId="descriptionEvent">
                <Form.Label className="text-left">Descripcion del Evento</Form.Label>
                <Form.Control type="descriptionEvent"
                    as="textarea"
                    name="descriptionEvent"
                    onChange={handleChange}
                    onBlur={handleBlur} 
                    value={values.descriptionEvent} 
                />
            </Form.Group>
            <ErrorMessage name="descriptionEvent" component={()=>(<div className="text-danger">{errors.descriptionEvent}</div>)}></ErrorMessage>
            
            <br/>
      <div className="text-danger">{errorDuply? errorDuply :''}</div>
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

export default FormEvent;
