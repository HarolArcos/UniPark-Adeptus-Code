import React, { useState, useEffect } from "react";
import { Table, Button, Modal, ModalBody, Form } from "react-bootstrap";

export default function NumeroSitios({ fetchData }) {
  const [editingId, setEditingId] = useState(null);
  const [editedValor1, setEditedValor1] = useState('');
  const [editedNombre, setEditedNombre] = useState("");
  const [show, setShow] = useState(false);
  const [sitios, setsitios] = useState([])

  // Función para manejar el evento de clic en el botón de editar
  const handleEdit = (configuracionId, valor1,nombre) => {
    setEditingId(configuracionId);
    setEditedValor1(valor1);
    setEditedNombre(nombre);
    setShow(true);
  };
  useEffect(() => {
    fetchConfiguraciones();
  }, []);

  const fetchConfiguraciones = async () => {
    try {
      const response = await fetch("http://adeptuscode.tis.cs.umss.edu.bo//UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiConfiguracion/apiConfiguracion.php/listConfigurationNumSitios");
      const data = await response.json();
      setsitios(data);
      
    } catch (error) {
      console.log(error);
    } 
    
  };






  // Función para manejar el evento de cambio en el campo de valor1 editado
  const handleValor1Change = (event) => {
    setEditedValor1(event.target.value);
  };
  const handleClose = () => {
    setEditingId(null);
    setEditedValor1("");
   
    setEditedNombre("");
    setShow(false);
  };
  // Función para guardar los cambios editados
  function saveChanges() {
    fetchData("http://adeptuscode.tis.cs.umss.edu.bo//UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiConfiguracion/apiConfiguracion.php/editConfiguration",
    {
        "idConfiguration" : editingId,
        "nameConfiguration" : editedNombre,
        "value1Configuration" : editedValor1
    })
    handleClose()
    fetchConfiguraciones();
    
    // Aquí puedes realizar una llamada a tu backend para guardar los cambios
    // por ejemplo, utilizando una función `saveChangesToBackend(updatedSitio)`
    // saveChangesToBackend(updatedSitio);
  }
  sitios.sort((a, b) => parseInt(a.configuracion_id) - parseInt(b.configuracion_id));
 
  return (
    <div>
    <Table striped bordered hover className="table">
      <thead>
        <tr>
          <th>Sitios</th>
          <th>Número de Sitios</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        {sitios.map((sitio) => (
          <tr key={sitio.configuracion_id}>
            <td>Límite Número de Sitios </td>
            <td>
              
                
              
                {sitio.configuracion_valor1}
             
            </td>
            <td>
              
                <Button
                  variant="success"
                  onClick={() =>
                    handleEdit(
                      sitio.configuracion_id,
                      sitio.configuracion_valor1,
                      sitio.configuracion_nombre
                    )
                  }
                >
                  Editar
                </Button>
            
            </td>
          </tr>
        ))}
      </tbody>
    </Table>

    <Modal show={show} onHide={handleClose} centered>
        <ModalBody className="modal-body">
          <h1 className="forgot-password-modal">Editar Acción</h1>
          <Form className="container">
            <Form.Group>
              <Form.Label className="text-left">Nombre: {editedNombre}</Form.Label>
            </Form.Group>
            <Form.Group>
              <Form.Label className="text-left">Valor:</Form.Label>
              <br />
              <input
                  type="text"
                  value={editedValor1}
                  onChange={handleValor1Change}
                  style={{ width: '80px' }} // Establecer un ancho fijo
                />
            </Form.Group>
            
          </Form>

          <div>
          <Button variant="success" onClick={() => saveChanges()}>
                  Guardar
                </Button>
          </div>
        </ModalBody>
      </Modal>
    </div>
  );
}
