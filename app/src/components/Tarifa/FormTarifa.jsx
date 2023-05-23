
import React, { useEffect } from "react";
import { Form, Button,Modal,Image } from "react-bootstrap";
import {Formik, ErrorMessage } from 'formik';
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import "./Tarifa.css"
import ComboboxReferences from "../ComboboxReferences/ComboboxReferences";
const Formulario = ({asunto,cancelar, tarifa}) => {

  const {data,fetchData} = useFetchSendData();
  useEffect(() => {
    console.log('Data actualizada o creada :', data);
  }, [data]);
  console.log(tarifa.tarifa_ruta);

  return (
    <Formik
    initialValues={
      tarifa? {
      idRate:      tarifa.tarifa_id   ,
      statusRate:  tarifa.tarifa_estado ,
      nameRate:    tarifa.tarifa_nombre ,
      valueRate:   tarifa.tarifa_valor ,
      routeRate:   tarifa.tarifa_ruta ,
      }:{
        statusRate:'' ,
        nameRate:  '' ,
        valueRate: '' ,
        routeRate: '' ,
      }}
    
    validate={values => {
      const errors = {};


      if(!values.nameRate){
        errors.nameRate ='El campo es requerido';
      }


      if(!values.valueRate){
        errors.valueRate ='El campo es requerido';
      }

      if(!values.routeRate){
        errors.routeRate ='El campo es requerido';
      }
      console.log(errors);
      return errors;
    }}
    

    onSubmit={async (values) => {
      if (tarifa) {
        console.log(values);
        // fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiVehicle/apiVehicle.php/editVehicle',values);
        // cancelar();
        
      } else {
        console.log(values);
        // fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiVehicle/apiVehicle.php/insertVehicle',values);
        // cancelar();
      }

    }
    }

    >

      {({values,errors,handleBlur,handleChange,handleSubmit})=>(
        <Form  className="container">

          <Form.Group className="inputGroup" controlId="nameRate text-left">
            <Form.Label className="text-left">Plazo</Form.Label>
            <Form.Control 
            type="text" 
            name="nameRate"
            onChange={handleChange}
            onBlur={handleBlur}
            value={values.nameRate}
            />
          </Form.Group>
          <ErrorMessage name="nameRate" component={()=>(<div className="text-danger">{errors.nameRate}</div>)}></ErrorMessage>
          
          <Form.Group className="inputGroup" controlId="valueRate">
            <Form.Label className="text-left">Valor en Bs</Form.Label>
            <Form.Control 
            type="text"
            name="valueRate"
            onChange={handleChange}
            onBlur={handleBlur} 
            value={values.valueRate} 
            />
          </Form.Group>
          <ErrorMessage name="valueRate" component={()=>(<div className="text-danger">{errors.valueRate}</div>)}></ErrorMessage>
          
          <Form.Group className="inputGroup" controlId="routeRate">
            <Form.Label className="text-left">Imágen QR</Form.Label>
            <Form.Control 
            type="file" 
            accept="image/*"
            name="routeRate"
            onChange={handleChange}
            onBlur={handleBlur}
            />
          </Form.Group>
          <ErrorMessage name="routeRate" component={()=>(<div className="text-danger">{errors.routeRate}</div>)}></ErrorMessage>
          <br/>
          <div>
              {tarifa == null ?(<br/>):(
                  <>
                  <h2>{tarifa.tarifa_nombre}</h2>
                  <h2>{tarifa.tarifa_valor}</h2>
                  <Image src={tarifa.tarifa_ruta} alt="imagen qr" fluid />
                  </>
              )}
            </div>
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
