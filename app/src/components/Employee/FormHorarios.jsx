
import React, { useEffect ,useState} from "react";
import { Form, Button,Modal } from "react-bootstrap";
import {Formik, ErrorMessage } from 'formik';
import { useFetchSendData } from "../../hooks/HookFetchSendData";

const FormHorarioEmp = ({asunto,cancelar, evento}) => {

  const {data,fetchData} = useFetchSendData();
  
  //añadidas new

  const [errorDuply, seterrorDuply] = useState(null);
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

        // if(!selectedPersonaId){
        //     errors.idPerson ='Seleccione un elemento porfavor';
        // }

        // if(!selectedVehicleId){
        //     errors.idVehicle ='Seleccione una placa porfavor';
        // }

        // if(!selectedRefTypeEventId){
        //     errors.typeEvent ='Seleccione el tipo de evento porfavor';
        // }

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
        await fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiEvent/apiEvent.php/editEvent',values);
        console.log('editar:',values);
      } else {
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
                
            </Form.Group>
            <ErrorMessage name="idVehicle" component={()=>(<div className="text-danger">{errors.idPerson}</div>)}></ErrorMessage>
            <Form.Group className="inputGroup" controlId="idVehicle">
                <Form.Label className="text-left">Placas Asociadas</Form.Label>
                
            </Form.Group>
            <ErrorMessage name="idVehicle" component={()=>(<div className="text-danger">{errors.idVehicle}</div>)}></ErrorMessage>
            
            <Form.Group className="inputGroup" controlId="idPerson">
                <Form.Label className="text-left">Tipo de evento</Form.Label>
                
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

export default FormHorarioEmp;
