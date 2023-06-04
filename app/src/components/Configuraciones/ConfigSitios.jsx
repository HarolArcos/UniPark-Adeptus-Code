import React, { useState } from 'react';
import { Table, Button } from 'react-bootstrap';

export default function NumeroSitios({ sitios, fetchData }) {
  sitios.sort((a, b) => parseInt(a.configuracion_id) - parseInt(b.configuracion_id));
  const [editingId, setEditingId] = useState(null);
  const [editedValor1, setEditedValor1] = useState('');

  // Función para manejar el evento de clic en el botón de editar
  const handleEdit = (configuracionId, valor1) => {
    setEditingId(configuracionId);
    setEditedValor1(valor1);
  };

  // Función para manejar el evento de cambio en el campo de valor1 editado
  const handleValor1Change = (event) => {
    setEditedValor1(event.target.value);
  };

  // Función para guardar los cambios editados
  function saveChanges(sitio) {
    fetchData("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiConfiguracion/apiConfiguracion.php/editConfiguration",
    {
        "idConfiguration" : sitio.configuracion_id,
        "nameConfiguration" : sitio.configuracion_nombre,
        "value1Configuration" : editedValor1
    })
    setEditingId(null);
    setEditedValor1('');
    alert("Los cambios han sido guardados. Por favor, recargue la página para ver los cambios.");
    // Aquí puedes realizar una llamada a tu backend para guardar los cambios
    // por ejemplo, utilizando una función `saveChangesToBackend(updatedSitio)`
    // saveChangesToBackend(updatedSitio);
  }

  return (
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
            <td>Limite Numero de Sitios </td>
            <td>
              {editingId === sitio.configuracion_id ? (
                <input
                  type="text"
                  value={editedValor1}
                  onChange={handleValor1Change}
                  style={{ width: '80px' }} // Establecer un ancho fijo
                />
              ) : (
                sitio.configuracion_valor1
              )}
            </td>
            <td>
              {editingId === sitio.configuracion_id ? (
                <Button variant="success" onClick={() => saveChanges(sitio)}>
                  Guardar
                </Button>
              ) : (
                <Button
                  variant="primary"
                  onClick={() =>
                    handleEdit(
                      sitio.configuracion_id,
                      sitio.configuracion_valor1
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
