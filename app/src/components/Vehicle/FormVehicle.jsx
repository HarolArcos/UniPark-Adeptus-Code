
import React, { useEffect ,useState} from "react";
import { Form, Button,Modal } from "react-bootstrap";
import {Formik, ErrorMessage } from 'formik';
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import { useFetch } from "../../hooks/HookFetchListData";
import ComboboxPerson from "../ComboboxPerson/ComboboxPerson";
import "./Vehicle.css"
import { useNavigate } from "react-router-dom";
const Formulario = ({asunto,cancelar, vehiculo,actualizarVehiculo}) => {

  const {data,fetchData} = useFetchSendData();
  const navigate = useNavigate();
  useEffect(() => {
    console.log('Data actualizada o creada :', data);
  }, [data]);

  //añadidas new

  const [selectedPersonaId, setSelectedPersonaId] = useState(
    vehiculo ? vehiculo.persona_id : null
  );

  const handlePersonaIdChange = (personaId) => {
    setSelectedPersonaId(personaId);
  };
  //------------


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
      idPerson: '',
      statusVehicle: '3',
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

      if(!selectedPersonaId){
        errors.idPerson ='Seleccione un elemento porfavor';
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
      console.log(errors);
      return errors;
    }}
    

    onSubmit={async (values) => {
      if (vehiculo) {
        values.idPerson = selectedPersonaId;
        console.log(values,selectedPersonaId);
        actualizarVehiculo(values);
        fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiVehicle/apiVehicle.php/editVehicle',values);
        
        navigate("/vehiculo");
        cancelar();
      } else {
        values.idPerson = selectedPersonaId;
        console.log(values,selectedPersonaId);
        fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiVehicle/apiVehicle.php/insertVehicle',values);
        navigate("/vehiculo");
        cancelar();
      }

    }
    }

    >

      {({values,errors,handleBlur,handleChange,handleSubmit})=>(
        <Form  className="container">

              <Form.Group className="inputGroup" controlId="plateVehicle text-left">
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
              
              <Form.Group className="inputGroup" controlId="modelVehicle">
                <Form.Label className="text-left">modelo</Form.Label>
                <Form.Control type="modelVehicle"
                name="modelVehicle"
                onChange={handleChange}
                onBlur={handleBlur} 
                value={values.modelVehicle} 
                />
              </Form.Group>
              <ErrorMessage name="modelVehicle" component={()=>(<div className="text-danger">{errors.modelVehicle}</div>)}></ErrorMessage>
              
              <Form.Group className="inputGroup" controlId="colorVehicle">
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
            <Form.Group className="inputGroup" controlId="idPerson">
            <Form.Label className="text-left">Propietario</Form.Label>
            <ComboboxPerson 
            id={vehiculo? vehiculo.persona_id:null}
            onPersonaIdChange={handlePersonaIdChange}
            />
            </Form.Group>
            <ErrorMessage name="idPerson" component={()=>(<div className="text-danger">{errors.idPerson}</div>)}></ErrorMessage>
            
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
