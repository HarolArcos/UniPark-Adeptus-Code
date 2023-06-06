import { useState } from "react";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import Header from "../Header/Header";

import { Button, Table } from "react-bootstrap";

export default function Mensaje() {
  const [mensa, setmensa] = useState("");
  const [titulo, settitulo] = useState("");
  const [error, seterror] = useState(null);

  function Enviar() {
    if (mensa && titulo) {
      
      fetch(
        "https://api.telegram.org/bot5920320499:AAFavxSuyHr4gDi1IY4SEhAkWt0Er7kcQlM/sendMessage?chat_id=-848439578&text=<" +
          titulo.toUpperCase() +
          ">%0A%0A%0A" +
          mensa
      );

      seterror(null);
    } else {
      seterror("tiene que llenar los campos Titulo y Mensaje");
    }
  }
  return (
    <div>
      <Header />
      <Aside></Aside>
      <div className="content-wrapper contenteSites-body">
        <label style={{ fontSize: "30px" }}>
          Mensajes Globales a Grupo Telegram
        </label>
        <Table striped bordered hover className="table">
          <thead>
            <tr>
              <th>Nombre Campo </th>
              <th> Datos </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th> Titulo</th>
              <td>
                <textarea
                  rows="3"
                  cols="50"
                  placeholder="escriba el Titulo aqui"
                  onChange={(e) => settitulo(e.target.value)}
                ></textarea>
              </td>
            </tr>
          </tbody>
          <tbody>
            <tr>
              <th>Mensaje</th>
              <td>
                <textarea
                  rows="3"
                  cols="50"
                  placeholder="escriba el mensaje aqui"
                  onChange={(e) => setmensa(e.target.value)}
                ></textarea>
              </td>
            </tr>
          </tbody>
        </Table>

        <Button
          variant="success"
          onClick={() => Enviar()}
          type="submit"
          className="btn btn-primary  "
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-telegram" viewBox="0 0 16 16"> <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/> </svg>

        </Button>
        {error ? <span className="text-danger">{error}</span> : <span></span>}
      </div>
      <Footer></Footer>
    </div>
  );
}
