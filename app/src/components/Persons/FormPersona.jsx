
import React, { useEffect } from "react";
import { Form, Button,Modal } from "react-bootstrap";
import {Formik, ErrorMessage } from 'formik';
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import "./FormPersona.css";

const FormularioPersona = ({asunto,cancelar, persona,actualizarVehiculo, añadirNuevo}) => {

  const {data,fetchData} = useFetchSendData();
  
  useEffect(() => {
    console.log('Data actualizada o creada :', data);
  }, [data]);

  return (
    <Formik
    initialValues={
        persona? {
        idPerson: persona.persona_id,
        idVehiculo: 1,
        fnamePerson: persona.persona_nombre,
        lnamePerson: persona.persona_apellido,
        cIPerson: persona.persona_ci,
        phonePerson: persona.persona_telefono,
        telegramPerson: persona.persona_telegram,
        statePerson: persona.persona_estado,
        nickPerson: persona.persona_nickname,
        pwPersona: persona.persona_contraseña
      }:{
        idVehiculo: '1',
        fnamePerson: '',
        lnamePerson: '',
        cIPerson: '',
        phonePerson: '',
        telegramPerson: '',
        statePerson: '',
        nickPerson: '',
        pwPersona: ''
      }}
    
    validate={values => {
      const errors = {};

      if(!values.fnamePerson){
        errors.fnamePerson ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.fnamePerson)){
        errors.fnamePerson ='caracteres invalidos'
      }

      if(!values.lnamePerson){
        errors.lnamePerson ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.lnamePerson)){
        errors.lnamePerson ='datos invalidos'
      }

      if(!values.cIPerson){
        errors.cIPerson ='El campo es requerido';
      }
      else if(!/^[0-9]+$/i.test(values.cIPerson)){
        errors.colorVehicle ='datos invalidos'
      }

      if(!values.phonePerson){
        errors.phonePerson ='El campo es requerido';
      }
      else if(!/^[0-9]+$/i.test(values.phonePerson)){
        errors.phonePerson ='datos invalidos'
      }

      if(!values.telegramPerson){
        errors.telegramPerson ='El campo es requerido';
      }
      else if(!/^[A-Za-z-0-9]+$/i.test(values.telegramPerson)){
        errors.telegramPerson ='datos invalidos'
      }

      if(!values.statePerson){
        errors.statePerson ='El campo es requerido';
      }
      else if(!/^[0-9]+$/i.test(values.statePerson)){
        errors.statePerson ='datos invalidos'
      }
      
      if(!values.nickPerson){
        errors.nickPerson ='El campo es requerido';
      }
      else if(!/^[A-Za-z-0-9]+$/i.test(values.nickPerson)){
        errors.nickPerson ='datos invalidos'
      }

      if(!values.pwPersona){
        errors.pwPersona ='El campo es requerido';
      }
      else if(!/^[A-Za-z-0-9]+$/i.test(values.pwPersona)){
        errors.pwPersona ='datos invalidos'
      }
      return errors;
    }}
    

    onSubmit={async (values) => {
      if (persona) {
        console.log(values);
        // actualizarVehiculo(values);
        fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/editPerson',values);
        // cancelar();
      } else {
        console.log(values);
        fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/insertPerson',values);
        cancelar();
      }
      }
    }

    >

      {({values,errors,handleBlur,handleChange,handleSubmit})=>(
        <Form  className="container">
      <div className="row ">
        <div className="col-md-12 contentModalPerson">

          <div className="column">
            <Form.Group controlId="fnamePerson">
              <Form.Label className="label text-left">Nombre</Form.Label>
              <Form.Control 
              type="text" 
              name="fnamePerson"
              onChange={handleChange}
              onBlur={handleBlur}
              value={values.fnamePerson}
              />
            </Form.Group>
            <ErrorMessage name="fnamePerson" component={()=>(<div className="text-danger">{errors.fnamePerson}</div>)}></ErrorMessage>
            
            <Form.Group controlId="lnamePerson">
              <Form.Label className="label" >Apellido</Form.Label>
              <Form.Control 
              type="text"
              name="lnamePerson"
              onChange={handleChange}
              onBlur={handleBlur} 
              value={values.lnamePerson} 
              />
            </Form.Group>
            <ErrorMessage name="lnamePerson" component={()=>(<div className="text-danger">{errors.lnamePerson}</div>)}></ErrorMessage>
            
            <Form.Group controlId="cIPerson">
              <Form.Label className="label" >CI</Form.Label>
              <Form.Control 
              type="text" 
              name="cIPerson"
              onChange={handleChange}
              onBlur={handleBlur}
              value={values.cIPerson}
              />
            </Form.Group>
            <ErrorMessage name="cIPerson" component={()=>(<div className="text-danger">{errors.cIPerson}</div>)}></ErrorMessage>
            
            <Form.Group controlId="phonePerson">
              <Form.Label className="label" >Telefono</Form.Label>
              <Form.Control 
              type="text" 
              name="phonePerson"
              onChange={handleChange}
              onBlur={handleBlur}
              value={values.phonePerson}
              />
            </Form.Group>
            <ErrorMessage name="phonePerson" component={()=>(<div className="text-danger">{errors.phonePerson}</div>)}></ErrorMessage>
          </div>

          <div className="column">
            <Form.Group controlId="telegramPerson">
              <Form.Label className="label">Telegram</Form.Label>
              <Form.Control 
              type="text" 
              name="telegramPerson"
              onChange={handleChange}
              onBlur={handleBlur}
              value={values.telegramPerson}
              />
            </Form.Group>
            <ErrorMessage name="telegramPerson" component={()=>(<div className="text-danger">{errors.telegramPerson}</div>)}></ErrorMessage>

            <Form.Group controlId="statePerson">
              <Form.Label className="label" >Estado Persona</Form.Label>
              <Form.Control 
              type="text" 
              name="statePerson"
              onChange={handleChange}
              onBlur={handleBlur}
              value={values.statePerson}
              />
            </Form.Group>
            <ErrorMessage name="statePerson" component={()=>(<div className="text-danger">{errors.statePerson}</div>)}></ErrorMessage>

            <Form.Group controlId="nickPerson">
              <Form.Label className="label" >Nickname</Form.Label>
              <Form.Control 
              type="text" 
              name="nickPerson"
              onChange={handleChange}
              onBlur={handleBlur}
              value={values.nickPerson}
              />
            </Form.Group>
            <ErrorMessage name="nickPerson" component={()=>(<div className="text-danger">{errors.nickPerson}</div>)}></ErrorMessage>

            <Form.Group controlId="pwPersona">
              <Form.Label className="label">Contraseña</Form.Label>
              <Form.Control 
              type="text" 
              name="pwPersona"
              onChange={handleChange}
              onBlur={handleBlur}
              value={values.pwPersona}
              />
            </Form.Group>
            <ErrorMessage name="pwPersona" component={()=>(<div className="text-danger">{errors.pwPersona}</div>)}></ErrorMessage>
          </div>
        </div>

      </div>
      <br/>
        <Modal.Footer >
          <Button variant="secondary" onClick={cancelar}>
            Cancelar
          </Button>
          <Button variant="primary" onClick={handleSubmit}  >
            {asunto}
          </Button>
        </Modal.Footer>
    </Form>
      )}
    </Formik>
  );
};

export default FormularioPersona;
