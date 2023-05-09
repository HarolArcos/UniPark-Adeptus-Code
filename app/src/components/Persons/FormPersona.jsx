
import React, { useEffect } from "react";
import { Form, Button,Modal } from "react-bootstrap";
import {Formik, ErrorMessage } from 'formik';
import { useFetchSendData } from "../../hooks/HookFetchSendData";

const Formulario = ({asunto,cancelar, persona,actualizarVehiculo, añadirNuevo}) => {

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
        phonePerson: persona.persona_telefono
      }:{
        idVehiculo: '1',
        fnamePerson: '',
        lnamePerson: '',
        cIPerson: '',
        phonePerson: ''
      }}
    
    validate={values => {
      const errors = {};

      if(!values.fnamePerson){
        errors.fnamePerson ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.fnamePerson)){
        errors.plateVehicle ='caracteres invalidos'
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
        <div className="col-md-4">

          <Form.Group controlId="fnamePerson">
            <Form.Label className="text-left">Nombre</Form.Label>
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
            <Form.Label>Apellido</Form.Label>
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
            <Form.Label>CI</Form.Label>
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
            <Form.Label>Telefono</Form.Label>
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

export default Formulario;
