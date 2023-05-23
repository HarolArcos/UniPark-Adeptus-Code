import React, { useEffect } from "react";
import { Form, Button, Modal } from "react-bootstrap";
import { Formik, ErrorMessage } from "formik";
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import "./FormPersona.css";
import ComboboxReferences from "../ComboboxReferences/ComboboxReferencia2";
import { useFetch } from "../../hooks/HookFetchListData";

const FormularioPersona = ({
  
  asunto,
  cancelar,
  persona,
  actualizarVehiculo,
  añadirNuevo,
}) => {
  const { data, fetchData } = useFetchSendData();
   const {data:lista,loading} =  useFetch(
    "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPerson")
  useEffect(() => {
    
  }, [data]);

  return (
    <Formik
      initialValues={
        persona
          ? {
              idPerson: persona.persona_id,
              typePerson: persona.persona_tipo,
              namePerson: persona.persona_nombre,
              lastNamePerson: persona.persona_apellido,
              ciPerson: persona.persona_ci,
              phonePerson: persona.persona_telefono,
              telegramPerson: persona.persona_telegram,
              statusPerson: persona.persona_estado,
              nicknamePerson: persona.persona_nickname,
              passwordPerson: persona.persona_contraseña,
            }
          : {
              typePerson: "3",
              namePerson: "",
              lastNamePerson: "",
              ciPerson: "",
              phonePerson: "",
              telegramPerson: "",
              statusPerson: "",
              nicknamePerson: "",
              passwordPerson: "",
            }
      }
      validate={(values) => {
        const errors = {};

        if (!values.namePerson) {
          errors.namePerson = "Campo Obligatorio";
        } else {
          if (values.namePerson.startsWith(" ")) {
            errors.namePerson = "Este campo no puede empezar con espacio “ ”";
          } else {
            if (/\s\s+/i.test(values.namePerson)) {
              errors.namePerson =
                "Solo se permite un caracter espacio entre 2 nombres";
            } else {
              if (
                /[^a-zA-Z-ÿ\u00f1\u00d1\u00E0-\u00FC\u00DC\s]/i.test(
                  values.namePerson
                )
              ) {
                errors.namePerson =
                  "Se ingreso un caracter invalido";
              }
            }
          }
        }

        
        if (!values.lastNamePerson) {
          errors.lastNamePerson = "Campo Obligatorio";
        } else {
          if (values.lastNamePerson.startsWith(" ")) {
            errors.lastNamePerson = "Este campo no puede empezar con espacio “ ”";
          } else {
            if (/\s\s+/i.test(values.lastNamePerson)) {
              errors.lastNamePerson =
                "Solo se permite un caracter espacio entre 2 apellidos";
            } else {
              if (
                /[^a-zA-Z-ÿ\u00f1\u00d1\u00E0-\u00FC\u00DC\s]/i.test(
                  values.lastNamePerson
                )
              ) {
                errors.lastNamePerson =
                  "Se ingreso un caracter invalido";
              }
            }
          }
        }
        
        if (!values.ciPerson) {
          errors.ciPerson = "Campo Obligatorio";
        } else {
          if (/[^0-9]/i.test(values.ciPerson)) {
            errors.ciPerson = "Se ingreso un caracter invalido ";
          }
          else{
            if (!loading) {
              if(lista.filter((CI)=>CI.persona_ci===values.ciPerson).length>0){
                errors.ciPerson = "CI ya registrado a otro usuario";
                }
            }
          }
        }
        
        

        if (!values.phonePerson) {
          errors.phonePerson = "Campo Obligatorio";
        } else if (!values.phonePerson.startsWith("6")&& !values.phonePerson.startsWith("7")) {
          errors.phonePerson = "Un número de teléfono debe iniciar con 6 o 7";
        } else {
          
          if (values.phonePerson.length!==8) {
            errors.phonePerson = "Un número de teléfono debe tener 8 digitos";
    
          } else {
            if (/[^0-9]/i.test(values.phonePerson)) {
              errors.phonePerson = "datos invalidos";
            }
            else{
              if (!loading) { 
                if(lista.filter((CI)=>CI.persona_telefono===values.phonePerson).length>0){
                  errors.phonePerson = "Teléfono ya registrado a otro usuario";
                    }  
              }
            }
          }
        } 
        
        
        
        if (!values.telegramPerson) {
          errors.telegramPerson = "El campo es requerido";
        } else if (!/^[A-Za-z-0-9]+$/i.test(values.telegramPerson)) {
          errors.telegramPerson = "datos invalidos";
        }

        if (!values.statusPerson) {
          errors.statusPerson = "El campo es requerido";
        } else if (!/^[0-9]+$/i.test(values.statusPerson)) {
          errors.statusPerson = "datos invalidos";
        }

        


        if (!values.nicknamePerson) {
          errors.nicknamePerson = "Campo Obligatorio";
        } else {
          
          
            
              if (!loading) { 
                if(lista.filter((CI)=>CI.persona_telefono===values.nicknamePerson).length>0){
                  errors.nicknamePerson = "Teléfono ya registrado a otro usuario";
                    }  
              }
            
          
        } 

        if (!values.passwordPerson) {
          errors.passwordPerson = "El campo es requerido";
        } else if (/[^A-Za-z-0-9\u00f1\u00d1\u00E0\u00FC\u00DC]/i.test(values.passwordPerson)) {
          errors.passwordPerson = "datos invalidos";
        }
        return errors;
      }}
      onSubmit={async (values) => {
        if (persona) {
          console.log(values, "editar personas");
          // actualizarVehiculo(values);
          fetchData(
            "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/editPerson",
            values
          );
          cancelar();
        } else {
          console.log(values);
          fetchData(
            "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/insertPerson",
            values
          );
          cancelar();
        }
      }}
    >
      {({ values, errors, handleBlur, handleChange, handleSubmit }) => (
        <Form className="container ">
          <div className="row ">
            <div className="col-md-2" style={{ width: "220.60000000000002px" }}>
              <Form.Group className="inputGroup " controlId="namePerson">
                <Form.Label className="label text-left ">Nombre</Form.Label>
                <Form.Control
                  type="text"
                  name="namePerson"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.namePerson}
                />
                <ErrorMessage
                  name="namePerson"
                  component={() => (
                    <div className="text-danger">{errors.namePerson}</div>
                  )}
                ></ErrorMessage>
              </Form.Group>
            </div>
            <div className="col-md-2" style={{ width: "220.60000000000002px" }}>
              <Form.Group className="inputGroup" controlId="lastNamePerson">
                <Form.Label className="label">Apellido</Form.Label>
                <Form.Control
                  type="text"
                  name="lastNamePerson"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.lastNamePerson}
                />
                <ErrorMessage
                  name="lastNamePerson"
                  component={() => (
                    <div className="text-danger">{errors.lastNamePerson}</div>
                  )}
                ></ErrorMessage>
              </Form.Group>
            </div>
            <div
              className=" col-md-2"
              style={{ width: "220.60000000000002px" }}
            >
              <Form.Group className="inputGroup" controlId="ciPerson">
                <Form.Label className="label">CI</Form.Label>
                <Form.Control
                  type="text"
                  name="ciPerson"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.ciPerson}
                />
                <ErrorMessage
                  name="ciPerson"
                  component={() => (
                    <div className="text-danger">{errors.ciPerson}</div>
                  )}
                ></ErrorMessage>
              </Form.Group>
            </div>
            <div
              className="col-md-2 "
              style={{ width: "220.60000000000002px" }}
            >
              <Form.Group className="inputGroup" controlId="phonePerson">
                <Form.Label className="label">Telefono</Form.Label>
                <Form.Control
                  type="text"
                  name="phonePerson"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.phonePerson}
                />
                <ErrorMessage
                  name="phonePerson"
                  component={() => (
                    <div className="text-danger">{errors.phonePerson}</div>
                  )}
                ></ErrorMessage>
              </Form.Group>
            </div>
            <div
              className="col-md-2 "
              style={{ width: "220.60000000000002px" }}
            >
              <Form.Group className="inputGroup" controlId="telegramPerson">
                <Form.Label className="label">Telegram</Form.Label>
                <Form.Control
                  type="text"
                  name="telegramPerson"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.telegramPerson}
                />
                <ErrorMessage
                  name="telegramPerson"
                  component={() => (
                    <div className="text-danger">{errors.telegramPerson}</div>
                  )}
                ></ErrorMessage>
              </Form.Group>
            </div>
            <div
              className="col-md-2 "
              style={{ width: "220.60000000000002px" }}
            >
              <Form.Group className="inputGroup" controlId="nicknamePerson">
                <Form.Label className="label">Nickname</Form.Label>
                <Form.Control
                  type="text"
                  name="nicknamePerson"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.nicknamePerson}
                />
                <ErrorMessage
                  name="nicknamePerson"
                  component={() => (
                    <div className="text-danger">{errors.nicknamePerson}</div>
                  )}
                ></ErrorMessage>
              </Form.Group>
            </div>
            <div
              className="col-md-2 "
              style={{ width: "220.60000000000002px" }}
            >
              <Form.Group className="inputGroup" controlId="passwordPerson">
                <Form.Label className="label">Contraseña</Form.Label>
                <Form.Control
                  type="text"
                  name="passwordPerson"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.passwordPerson}
                />
                <ErrorMessage
                  name="passwordPerson"
                  component={() => (
                    <div className="text-danger">{errors.passwordPerson}</div>
                  )}
                ></ErrorMessage>
              </Form.Group>
            </div>
            <div
              className="contentModalPerson"
              style={{ width: "220.60000000000002px" }}
            >
              <Form.Group controlId="referencias">
                <Form.Label className="label">Referencias</Form.Label>

                <ComboboxReferences>
                  <br />
                </ComboboxReferences>
              </Form.Group>
            </div>
          </div>

          <br />
          <Modal.Footer>
            <Button variant="secondary" onClick={cancelar}>
              Cancelar
            </Button>
            <Button variant="primary" onClick={handleSubmit}>
              {asunto}
            </Button>
          </Modal.Footer>
        </Form>
      )}
    </Formik>
  );
};

export default FormularioPersona;
