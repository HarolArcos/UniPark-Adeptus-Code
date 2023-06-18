import React, { useEffect, useState } from "react";
import { Form, Button,Modal,Image ,Spinner} from "react-bootstrap";
import {Formik, ErrorMessage } from 'formik';
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import "./Tarifa.css"

const Formulario = ({asunto,cancelar, tarifa = null}) => {



  const {data,fetchData} = useFetchSendData();

  useEffect(() => {
   
  }, [data]);

  
  const [image, setImage] = useState(null);
  const [imageFile, setImageFile] = useState(null);
  const [loadin, setLoadin] = useState(false);
  const [loadingImage, setloadingImage] = useState(false);


  //-------------------------imagenes------------------
  
  const handleCargarImage = (event) => {
    const file = event.target.files[0];
    const reader = new FileReader();
      setImage(reader.result);
      setImageFile(file);
    reader.onload = () => {
      setImage(reader.result);
    };

    reader.readAsDataURL(file);

  };

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
        statusRate:19 ,
        nameRate:  '' ,
        valueRate: '' ,
        routeRate: '' ,
      }}
    
    validate={values => {
      const errors = {};


      if(!values.nameRate){
        errors.nameRate ='El campo es requerido';
      }else if(values.nameRate.startsWith(" ")){
        errors.nameRate ='El campo no puede empezar con espacios';
      }else if(!/^[A-Za-z]+$/i.test(values.nameRate)){
        errors.nameRate ='Solo se admite una palabra';
      }

      if(!values.valueRate){
        errors.valueRate ='El campo es requerido';
      }else if(values.valueRate.startsWith(" ")){
        errors.valueRate ='El campo no puede empezar con espacios';
      }else if(!/^[0-9]+$/i.test(values.valueRate)){
        errors.valueRate ='El campo solo admite números';
      }

      if(tarifa==null && !image){
        errors.routeRate ='El campo es requerido';
      }

      
      
   
      return errors;
    }}
    

    onSubmit={async (values) => {
      
      if (tarifa) {
        if (imageFile!=null) {
            const dataImage = new FormData();
            dataImage.append("file", imageFile);
            dataImage.append("upload_preset", "images");
            setLoadin(true);
            const res = await fetch("https://api.cloudinary.com/v1_1/dxqlkqb68/image/upload",{
              method: 'POST',
              body: dataImage,
            });
            const file =await res.json();

            values.routeRate = file.secure_url;

          }
            setLoadin(true);
            await  fetchData('http://adeptuscode.tis.cs.umss.edu.bo//UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRate/apiRate.php/editRate',values);
            setLoadin(false);
            cancelar();
        
      } else {
        const dataImage = new FormData();
          dataImage.append("file", imageFile);
          dataImage.append("upload_preset", "images");

          setLoadin(true);
          const res = await fetch("https://api.cloudinary.com/v1_1/dxqlkqb68/image/upload",{
            method: 'POST',
            body: dataImage,
          });
          const file =await res.json();

          values.routeRate = file.secure_url;
          
       
          await fetchData('http://adeptuscode.tis.cs.umss.edu.bo//UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRate/apiRate.php/insertRate',values);
          setLoadin(false);
          cancelar();
        
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
            <Form.Label className="text-left">Costo Bs</Form.Label>
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
            onChange={handleCargarImage}
            onBlur={handleBlur}
            />
            <br />
            <div className="text-center">
            {image && <Image src={image} alt="imagen qr" fluid className="custom-image"/> || tarifa && <Image src={tarifa.tarifa_ruta} alt="imagen qr" fluid className="custom-image"/> }
            </div>
          </Form.Group>
          <ErrorMessage name="routeRate" component={()=>(<div className="text-danger">{errors.routeRate}</div>)}></ErrorMessage>
          
          <br />
          {loadin?<Spinner animation="border" />:
          <Modal.Footer >
            <Button variant="secondary" onClick={cancelar}>
              Cancelar
            </Button>
            <Button variant="success" className="button" onClick={handleSubmit}  >
              {asunto}
            </Button>
          </Modal.Footer>
          
          }
          
        </Form>
      )}
    </Formik>
  );
};

export default Formulario;