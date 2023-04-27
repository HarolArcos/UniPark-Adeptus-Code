
import React, { useState, useEffect } from "react";
import { Form, Button,Modal } from "react-bootstrap";

const Formulario = ({asunto,cancelar, cliente, manejarEnvio,actualizarCliente,nuevoCliente, añadirNuevo }) => {
  console.log(cliente,asunto,nuevoCliente);
  const [nombre, setNombre] = useState("");
  const [apellido, setApellido] = useState("");
  const [email, setEmail] = useState("");
  const [telefono, setTelefono] = useState("");

  useEffect(() => {
    if (cliente) {
      setNombre(cliente.nombre);
      setApellido(cliente.apellido);
      setEmail(cliente.email);
      setTelefono(cliente.telefono);
    }
  }, [cliente]);

  const handleSubmit = (event) => {
  
    event.preventDefault();
    const nuevoCliente = {
      ...cliente,
      nombre,
      apellido,
      email,
      };

      if (cliente) {
        actualizarCliente(nuevoCliente);
      } else {
        añadirNuevo(nuevoCliente);
      }
      cancelar();

  };

  return (
    <Form onSubmit={handleSubmit} >
      <div className="row">
        <div className="col-md-6">
        <Form.Group controlId="nombre">
          <Form.Label>Nombre</Form.Label>
          <Form.Control type="text" value={nombre} onChange={(event) => setNombre(event.target.value)} required />
        </Form.Group>

        <Form.Group controlId="apellido">
          <Form.Label>Apellido</Form.Label>
          <Form.Control type="text" value={apellido} onChange={(event) => setApellido(event.target.value)} required />
        </Form.Group>
        </div>

        <div className="col-md-6">
        <Form.Group controlId="email">
          <Form.Label>Email</Form.Label>
          <Form.Control type="email" value={email} onChange={(event) => setEmail(event.target.value)} required />
        </Form.Group>

        {/* <Form.Group controlId="telefono">
          <Form.Label>Teléfono</Form.Label>
          <Form.Control type="tel" value={telefono} onChange={(event) => setTelefono(event.target.value)} required />
        </Form.Group> */}
        </div>
      </div>
      <br/>
      <Modal.Footer >
      <Button variant="secondary" onClick={cancelar}>
            Cancelar
          </Button>
          <Button variant="primary" onClick={handleSubmit}>
            {asunto}
          </Button>
      </Modal.Footer>
    </Form>
  );
};

export default Formulario;
