
import React from "react";
import { Form, Button,Modal } from "react-bootstrap";
import {Formik, ErrorMessage } from 'formik';

const Formulario = ({asunto,cancelar, guardia,actualizarGuardia, añadirNuevo,soloLectura = false}) => {


  return (
    <Formik
    initialValues={{
      id: guardia ? guardia.id :'',
      nombre: guardia ? guardia.nombre :'',
      apellido: guardia ? guardia.apellido :'',
      ci: guardia ? guardia.ci :'',
      telefono: guardia ? guardia.telefono :'',
      telegram: guardia ? guardia.telegram :'',
      nickName: guardia ? guardia.nickName :'',
      email: guardia ? guardia.email :'',
    }}
    
    validate={values => {
      const errors = {};
      
      
      if(!values.nombre){
        errors.nombre ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.nombre)){
        errors.nombre ='caracteres invalidos'
      }

      if(!values.apellido){
        errors.apellido ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.apellido)){
        errors.apellido ='datos invalidos'
      }

      

      if(!values.ci){
        errors.ci ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.ci)){
        errors.ci ='datos invalidos'
      }

      if(!values.telefono){
        errors.telefono ='El campo es requerido';
      }

      if(!values.telegram){
        errors.telegram ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.telegram)){
        errors.telegram ='datos invalidos'
      }

      if(!values.nickName){
        errors.nickName ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.nickName)){
        errors.nickName ='datos invalidos'
      }

      if(!values.email){
        errors.email ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.email)){
        errors.email ='datos invalidos'
      }

      console.log(errors);
      return errors;
    }}
    

    onSubmit={(values)=>{
           if (guardia) {
             actualizarGuardia(values);
           } else {
             añadirNuevo(values);
           }
      console.log(values);
           cancelar();
      }}

    >

      {({values,errors,handleBlur,handleChange,handleSubmit})=>(
        <Form  className="container">
      <div className="row ">
        <div className="col-md-4">

          <Form.Group controlId="nombre">
            <Form.Label className="text-left">Nombre</Form.Label>
            <Form.Control 
            type="text" 
            name="nombre"
            onChange={handleChange}
            onBlur={handleBlur}
            value={values.nombre}
            readOnly = {soloLectura}
            />
          </Form.Group>
          <ErrorMessage name="nombre" component={()=>(<div className="error">{errors.nombre}</div>)}></ErrorMessage>
          
          <Form.Group controlId="apellido">
            <Form.Label>Apellido</Form.Label>
            <Form.Control type="text" 
            name="apellido"
            onChange={handleChange}
            onBlur={handleBlur}
            value={values.apellido}
            readOnly = {soloLectura}

            />
          </Form.Group>
          <ErrorMessage name="apellido" component={()=>(<div className="error">{errors.apellido}</div>)}></ErrorMessage>
          
          <Form.Group controlId="nickName">
            <Form.Label>NickName</Form.Label>
            <Form.Control type="nickName"
            name="nickName"
            onChange={handleChange}
            onBlur={handleBlur} 
            value={values.nickName} 
            readOnly = {soloLectura}
            />
          </Form.Group>
          <ErrorMessage name="nickName" component={()=>(<div className="error">{errors.nickName}</div>)}></ErrorMessage>
          
          <Form.Group controlId="ci">
            <Form.Label>C.I.</Form.Label>
            <Form.Control type="ci"
            name="ci"
            onChange={handleChange}
            onBlur={handleBlur} 
            value={values.ci} 
            readOnly = {soloLectura}
            />
          </Form.Group>
          <ErrorMessage name="ci" component={()=>(<div className="error">{errors.ci}</div>)}></ErrorMessage>

          <Form.Group controlId="telefono">
            <Form.Label>Teléfono</Form.Label>
            <Form.Control type="telefono"
            name="telefono"
            onChange={handleChange}
            onBlur={handleBlur} 
            value={values.telefono} 
            readOnly = {soloLectura}
            />
          </Form.Group>
          <ErrorMessage name="telefono" component={()=>(<div className="error">{errors.telefono}</div>)}></ErrorMessage>

          <Form.Group controlId="telegram">
            <Form.Label>Telegram</Form.Label>
            <Form.Control type="telegram"
            name="telegram"
            onChange={handleChange}
            onBlur={handleBlur} 
            value={values.telegram} 
            readOnly = {soloLectura}
            />
          </Form.Group>
          <ErrorMessage name="telegram" component={()=>(<div className="error">{errors.telegram}</div>)}></ErrorMessage>


          <Form.Group controlId="email">
            <Form.Label>Email</Form.Label>
            <Form.Control type="email"
            name="email"
            onChange={handleChange}
            onBlur={handleBlur} 
            value={values.email} 
            readOnly = {soloLectura}
            />
          </Form.Group>
          <ErrorMessage name="email" component={()=>(<div className="error">{errors.email}</div>)}></ErrorMessage>
        </div>

        <div className="col-md-6">


        </div>

      </div>
      <br/>
        <Modal.Footer >
          <Button variant="secondary" onClick={cancelar}>
            Cancelar
          </Button>
          <Button variant="primary" onClick={handleSubmit} disabled ={soloLectura} >
            {asunto}
          </Button>
        </Modal.Footer>
    </Form>
      )}
    </Formik>
  );
};

export default Formulario;
