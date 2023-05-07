
//import React, { useState, useEffect } from "react";
import { Form, Button,Modal } from "react-bootstrap";
import {Formik, ErrorMessage, FieldArray } from 'formik';
import { useFetchSendData } from "../../hooks/HookFetchSendData";

const Formulario = ({asunto,cancelar, cliente,actualizarCliente, añadirNuevo,soloLectura = false}) => {

  const {data,fetchData,error} = useFetchSendData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/insertPerson');
  
  return (
    <Formik
    initialValues={{
      id: cliente ? cliente.id :'',
      nombre: cliente ? cliente.nombre :'',
      apellido: cliente ? cliente.apellido :'',
      ci: cliente ? cliente.ci :'',
      telefono: cliente ? cliente.telefono :'',
      telegram: cliente ? cliente.telegram :'',
      nickName: cliente ? cliente.nickName :'',
      email: cliente ? cliente.email :'',
      listCar: cliente? cliente.listCar:[{placa:'',modelo:'',color:''}],
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


      //-------------Lista de automoviles--------------
      values.listCar.forEach((car, index) => {
        if (!car.placa) {
          errors[`listCar[${index}].placa`] = "La placa es requerida";
        } else if (!/^[A-Za-z]{3}-\d{3}$/.test(car.placa)) {
          errors[`listCar[${index}].placa`] = "La placa debe tener formato AAA-111";
        }
    
        if (!car.modelo) {
          errors[`listCar[${index}].modelo`] = "El modelo es requerido";
        }
    
        if (!car.color) {
          errors[`listCar[${index}].color`] = "El color es requerido";
        }
      });
      
      // console.log(errors);
      return errors;
    }}
    

    onSubmit={async (values)=>{
           if (cliente) {
             actualizarCliente(values);
           } else {
            
               const myData = {typePerson : 2, namePerson : "Dory", lastNamePerson : "Arcos", ciPerson : "5295189", phonePerson: "59167418809", telegramPerson : "", statusPerson : 1, nicknamePerson : "lolii", passwordPerson : "abc123"}; // datos a enviar en la primera llamada
              fetchData(myData);
              console.log(data);
          }
      console.log(values);
          //  cancelar();
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
            <Form.Label>Telefono</Form.Label>
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

          <FieldArray name="listCar">

            {({ push, remove }) => (
              <>
                {values.listCar.map((car, index) => (
                  <div key={index}>
                    <Form.Group>
                      <Form.Label>Placa</Form.Label>
                      <Form.Control
                        name={`listCar[${index}].placa`}
                        value={car.placa}
                        onChange={handleChange}
                        onBlur={handleBlur}
                        isInvalid={Boolean(errors[`listCar[${index}].placa`])}
                        readOnly = {soloLectura}
                      />
                      <ErrorMessage  component={()=>(
                      <div>{errors[`listCar[${index}].placa`]}</div>
                      )}/>
                    </Form.Group>

                    <Form.Group>
                      <Form.Label>Modelo</Form.Label>
                      <Form.Control
                        name={`listCar[${index}].modelo`}
                        value={car.modelo}
                        onBlur={handleBlur}
                        onChange={handleChange}
                        isInvalid={Boolean(errors[`listCar[${index}].modelo`])}
                        readOnly = {soloLectura}
                      />
                      <ErrorMessage  component={()=>(
                      <div>{errors[`listCar[${index}].modelo`]}</div>
                      )}/>
                    </Form.Group>

                    <Form.Group>
                      <Form.Label>Color</Form.Label>
                      <Form.Control
                        name={`listCar[${index}].color`}
                        value={car.color}
                        onBlur={handleBlur}
                        onChange={handleChange}
                        isInvalid={Boolean(errors[`listCar[${index}].color`])}
                        readOnly = {soloLectura}
                      />
                      <ErrorMessage  component={()=>(
                      <div>{errors[`listCar[${index}].color`]}</div>
                      )}/>
                    </Form.Group>


                    <Button 
                    variant="danger" 
                    onClick={() => remove(index)}
                    disabled = {soloLectura} 
                    >
                      Eliminar
                    </Button>
                  </div>
                ))}

                <Button 
                variant="success" 
                onClick={() => push({ placa: "", modelo: "", color: "" })}
                disabled = {soloLectura}
                className="mg-5"
                >
                  Agregar nuevo carro
                </Button>
              </>
            )}
          </FieldArray>
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
