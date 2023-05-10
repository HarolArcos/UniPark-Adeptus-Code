
import React, { useEffect } from "react";
import { Form, Button,Modal } from "react-bootstrap";
import {Formik, ErrorMessage } from 'formik';
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import { useFetch } from "../../hooks/HookFetchListData";
import ComboboxPerson from "../ComboboxPerson/ComboboxPerson";

const Formulario = ({asunto,cancelar, vehiculo,actualizarVehiculo, añadirNuevo}) => {

  const {data,fetchData} = useFetchSendData();
  
  useEffect(() => {
    console.log('Data actualizada o creada :', data);
  }, [data]);

  return (
    <Formik
    initialValues={
      vehiculo? {
      idVehicle: vehiculo.vehiculo_id   ,
      idPerson: vehiculo.persona_id,
      statusVehicle: vehiculo.vehiculo_estado ,
      plateVehicle: vehiculo.vehiculo_placa ,
      modelVehicle: vehiculo.vehiculo_modelo ,
      colorVehicle: vehiculo.vehiculo_color ,
      }:{
      idPerson: '1',
      statusVehicle: '2',
      plateVehicle: '',
      modelVehicle: '',
      colorVehicle: '',
      }}
    
    validate={values => {
      const errors = {};

      if(!values.plateVehicle){
        errors.plateVehicle ='El campo es requerido';
      }
      else if(!/^[A-Za-z-0-9]+$/i.test(values.plateVehicle)){
        errors.plateVehicle ='caracteres invalidos'
      }

      if(!values.modelVehicle){
        errors.modelVehicle ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.modelVehicle)){
        errors.modelVehicle ='datos invalidos'
      }

      if(!values.colorVehicle){
        errors.colorVehicle ='El campo es requerido';
      }
      else if(!/^[A-Za-z]+$/i.test(values.colorVehicle)){
        errors.colorVehicle ='datos invalidos'
      }

      return errors;
    }}
    

    onSubmit={async (values) => {
      if (vehiculo) {
        console.log(values);
        // actualizarVehiculo(values);
        fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiVehicle/apiVehicle.php/editVehicle',values);
        cancelar();
      } else {
        console.log(values);
        fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiVehicle/apiVehicle.php/insertVehicle',values);
        cancelar();
      }
      }
    }

    >

      {({values,errors,handleBlur,handleChange,handleSubmit})=>(
        <Form  className="container">
          {/* <div className="row ">
            <div className="col-md-4"> */}

              <Form.Group controlId="plateVehicle text-left">
                <Form.Label className="text-left">Placa</Form.Label>
                <Form.Control 
                type="text" 
                name="plateVehicle"
                onChange={handleChange}
                onBlur={handleBlur}
                value={values.plateVehicle}
                />
              </Form.Group>
              <ErrorMessage name="plateVehicle" component={()=>(<div className="text-danger">{errors.plateVehicle}</div>)}></ErrorMessage>
              
              <Form.Group controlId="modelVehicle">
                <Form.Label className="text-left">modelo</Form.Label>
                <Form.Control type="modelVehicle"
                name="modelVehicle"
                onChange={handleChange}
                onBlur={handleBlur} 
                value={values.modelVehicle} 
                />
              </Form.Group>
              <ErrorMessage name="modelVehicle" component={()=>(<div className="text-danger">{errors.modelVehicle}</div>)}></ErrorMessage>
              
              <Form.Group controlId="colorVehicle">
                <Form.Label className="text-left">Color</Form.Label>
                <Form.Control type="text" 
                name="colorVehicle"
                onChange={handleChange}
                onBlur={handleBlur}
                value={values.colorVehicle}
                />
              </Form.Group>
              <ErrorMessage name="colorVehicle" component={()=>(<div className="text-danger">{errors.colorVehicle}</div>)}></ErrorMessage>
              
      <br/>
            <ComboboxPerson id = { vehiculo? values.idPerson:null }/>
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
