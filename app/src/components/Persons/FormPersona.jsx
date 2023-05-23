
import React, { useEffect } from "react";
import { Form, Button,Modal } from "react-bootstrap";
import {Formik, ErrorMessage } from 'formik';
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import "./FormPersona.css";
import ComboboxReferences from "../ComboboxReferences/ComboboxReferences";

const FormularioPersona = ({asunto,cancelar, persona,actualizarPersona, añadirNuevo}) => {

  const {data,fetchData} = useFetchSendData();
  
  useEffect(() => {
    console.log('Data actualizada o creada :', data);
  }, [data]);

  return (
    <Formik
    initialValues={
        persona? {
        idPerson:       persona.persona_id,
        typePerson:     persona.persona_tipo,
        namePerson:     persona.persona_nombre,
        lastNamePerson: persona.persona_apellido,
        ciPerson:       persona.persona_ci,
        phonePerson:    persona.persona_telefono,
        telegramPerson: persona.persona_telegram,
        statusPerson:   persona.persona_estado,
        nicknamePerson: persona.persona_nickname,
        passwordPerson: persona.persona_contraseña
      }:{
        typePerson: '3',
        namePerson: '',
        lastNamePerson: '',
        ciPerson: '',
        phonePerson: '',
        telegramPerson: '',
        statusPerson: '',
        nicknamePerson: '',
        passwordPerson: ''
      }}
    
    validate={values => {
      const errors = {};

      if(!values.namePerson){
        errors.namePerson ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.namePerson)){
        errors.namePerson ='caracteres invalidos'
      }

      if(!values.lastNamePerson){
        errors.lastNamePerson ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.lastNamePerson)){
        errors.lastNamePerson ='datos invalidos'
      }

      if(!values.ciPerson){
        errors.ciPerson ='El campo es requerido';
      }
      else if(!/^[0-9]+$/i.test(values.ciPerson)){
        errors.ciPerson ='datos invalidos'
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

      if(!values.statusPerson){
        errors.statusPerson ='El campo es requerido';
      }
      else if(!/^[0-9]+$/i.test(values.statusPerson)){
        errors.statusPerson ='datos invalidos'
      }
      
      if(!values.nicknamePerson){
        errors.nicknamePerson ='El campo es requerido';
      }
      else if(!/^[A-Za-z-0-9]+$/i.test(values.nicknamePerson)){
        errors.nicknamePerson ='datos invalidos'
      }

      if(!values.passwordPerson){
        errors.passwordPerson ='El campo es requerido';
      }
      else if(!/^[A-Za-z-0-9]+$/i.test(values.passwordPerson)){
        errors.passwordPerson ='datos invalidos'
      }
      return errors;
    }}
    

    onSubmit={async (values) => {
      if (persona) {
        console.log(values, "editar personas");
        // actualizarVehiculo(values);
        fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/editPerson',values);
        cancelar();
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
                <Form.Group className="inputGroup" controlId="namePerson">
                  <Form.Label className="label text-left">Nombre</Form.Label>
                  <Form.Control 
                  type="text" 
                  name="namePerson"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.namePerson}
                  />
                </Form.Group>
                <ErrorMessage name="namePerson" component={()=>(<div className="text-danger">{errors.namePerson}</div>)}></ErrorMessage>
                
                <Form.Group className="inputGroup" controlId="lastNamePerson">
                  <Form.Label className="label" >Apellido</Form.Label>
                  <Form.Control 
                  type="text"
                  name="lastNamePerson"
                  onChange={handleChange}
                  onBlur={handleBlur} 
                  value={values.lastNamePerson} 
                  />
                </Form.Group>
                <ErrorMessage name="lastNamePerson" component={()=>(<div className="text-danger">{errors.lastNamePerson}</div>)}></ErrorMessage>
                
                <Form.Group className="inputGroup" controlId="ciPerson">
                  <Form.Label className="label" >CI</Form.Label>
                  <Form.Control 
                  type="text" 
                  name="ciPerson"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.ciPerson}
                  />
                </Form.Group>
                <ErrorMessage name="ciPerson" component={()=>(<div className="text-danger">{errors.ciPerson}</div>)}></ErrorMessage>
                
                <Form.Group className="inputGroup" controlId="phonePerson">
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
                <Form.Group className="inputGroup" controlId="telegramPerson">
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

                {/* <Form.Group className="inputGroup" controlId="statusPerson">
                  <Form.Label className="label" >Estado Persona</Form.Label>
                  <Form.Control 
                  type="text" 
                  name="statusPerson"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.statusPerson}
                  />
                </Form.Group>
                <ErrorMessage name="statusPerson" component={()=>(<div className="text-danger">{errors.statusPerson}</div>)}></ErrorMessage> */}

                <Form.Group controlId="referencias">
                  <Form.Label className="label">Referencias</Form.Label>
                  <ComboboxReferences></ComboboxReferences>
                </Form.Group>

                <Form.Group className="inputGroup" controlId="nicknamePerson">
                  <Form.Label className="label" >Nickname</Form.Label>
                  <Form.Control 
                  type="text" 
                  name="nicknamePerson"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.nicknamePerson}
                  />
                </Form.Group>
                <ErrorMessage name="nicknamePerson" component={()=>(<div className="text-danger">{errors.nicknamePerson}</div>)}></ErrorMessage>

                <Form.Group className="inputGroup" controlId="passwordPerson">
                  <Form.Label className="label">Contraseña</Form.Label>
                  <Form.Control 
                  type="text" 
                  name="passwordPerson"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.passwordPerson}
                  />
                </Form.Group>
                <ErrorMessage name="passwordPerson" component={()=>(<div className="text-danger">{errors.passwordPerson}</div>)}></ErrorMessage>
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
