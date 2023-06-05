import React, { useState } from 'react';
import { Table, Button } from 'react-bootstrap';

export default function Dias({ dia, fetchData }) {
    dia.sort((a, b) => parseInt(a.configuracion_id) - parseInt(b.configuracion_id));
  const [editingId, setEditingId] = useState(null);
  const [editedEntrada, setEditedEntrada] = useState('');
  const [editedSalida, setEditedSalida] = useState('');

  // Función para manejar el evento de clic en el botón de editar
  const handleEdit = (configuracionId, entrada, salida) => {
    setEditingId(configuracionId);
    setEditedEntrada(entrada);
    setEditedSalida(salida);
  };

  // Función para manejar el evento de cambio en el campo de entrada editado
  const handleEntradaChange = (event) => {
    setEditedEntrada(event.target.value);
  };

  // Función para manejar el evento de cambio en el campo de salida editado
  const handleSalidaChange = (event) => {
    setEditedSalida(event.target.value);
  };
  
  // Función para guardar los cambios editados
   function saveChanges(di) {
    fetchData("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiConfiguracion/apiConfiguracion.php/editConfiguration",
    {
        "idConfiguration" : di.configuracion_id,
        "nameConfiguration" : di.configuracion_nombre,
        "value1Configuration" : editedEntrada,
        "value2Configuration" : editedSalida
    })
    setEditingId(null);
    setEditedEntrada('');
    setEditedSalida('');
    alert(`Para ver los Cambios Recargue al página`);
    // Aquí puedes realizar una llamada a tu backend para guardar los cambios
    // por ejemplo, utilizando una función `saveChangesToBackend(updatedDia)`
    // saveChangesToBackend(updatedDia);
  }

  return (
    <Table striped bordered hover className="table">
      <thead>
        <tr>
          <th>Dia</th>
          <th>Hora Entrada</th>
          <th>Hora Salida</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        {dia.map((di) => (
          <tr key={di.configuracion_id}>
            <td>{di.configuracion_nombre}</td>
            <td>
              {editingId === di.configuracion_id ? (
                <input
                  type="text"
                  value={editedEntrada}
                  onChange={handleEntradaChange}
                  style={{ width: '80px' }} // Establecer un ancho fijo
                />
              ) : (
                di.configuracion_valor1
              )}
            </td>
            <td>
              {editingId === di.configuracion_id ? (
                <input
                  type="text"
                  value={editedSalida}
                  onChange={handleSalidaChange}
                  style={{ width: '80px' }} // Establecer un ancho fijo
                />
              ) : (
                di.configuracion_valor2
              )}
            </td>
            <td>
              {editingId === di.configuracion_id ? (
                <Button variant="success" onClick={() => saveChanges(di)}>
                  Guardar
                </Button>
              ) : (
                <Button
                  variant="primary"
                  onClick={() =>
                    handleEdit(
                      di.configuracion_id,
                      di.configuracion_valor1,
                      di.configuracion_valor2
                    )
                  }
                >
                  Editar
                </Button>
              )}
            </td>
          </tr>
        ))}
      </tbody>
    </Table>
  );
}
