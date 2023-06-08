import { useContext } from "react";
import { DataUser } from "../context/UserContext.jsx";
import { Table, Row, Col } from "react-bootstrap";
import { useFetch } from "../../hooks/HookFetchListData.js";

export default function DatosUser() {
  const { data, loading, error } = useFetch(
    "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiNews/apiNews.php/listNewsActive"
  );
  const { userglobal } = useContext(DataUser);

  return (
    <div className="content-wrapper contenteSites-body">
      <Table striped bordered hover className="table">
        <thead>
          <tr key="1">
            <th>Datos</th>
            <th>Informacion</th>
          </tr>
        </thead>
        <tbody>
          <tr key="2">
            <th>Nombre:</th>
            <th>{userglobal.persona_nombre}</th>
          </tr>
        </tbody>
        <tbody>
          <tr key="3">
            <th>Apellido:</th>
            <th>{userglobal.persona_apellido}</th>
          </tr>
        </tbody>
        <tbody>
          <tr key="4">
            <th>Telefono:</th>
            <th>{userglobal.persona_telefono}</th>
          </tr>
        </tbody>
        <tbody>
          <tr key="5">
            <th>Telegram:</th>
            <th>{userglobal.persona_telegram}</th>
          </tr>
        </tbody>
        <tbody>
          <tr key="6">
            <th>NickName:</th>
            <th>{userglobal.persona_nickname}</th>
          </tr>
        </tbody>
        <tbody>
          <tr key="7">
            <th>CI:</th>
            <th>{userglobal.persona_ci}</th>
          </tr>
        </tbody>
      </Table>
      {!loading && (
        <div>
        <div className="d-flex justify-content-center align-items-center">
          <h5>Noticias</h5>
          </div>
          
          
          
          <Row >
            {data.map((noti) => (
              <Col key={noti.noticia_id} className="d-flex justify-content-center align-items-center" >
                <div className="card " style={{width:"400px"}}>
                  <div className="card-header">
                    <h3 className="card-title">{noti.noticia_titulo}</h3>
                    <div className="card-tools">
                      <button
                        type="button"
                        className="btn btn-tool"
                        data-card-widget="collapse"
                      >
                        <i className="fas fa-minus"></i>
                      </button>
                      <button
                        type="button"
                        className="btn btn-tool"
                        data-card-widget="remove"
                      >
                        <i className="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div className="card-body">{noti.noticia_texto}</div>
                  <div className="card-footer">
                    Autor: {noti.autormodificacion}
                  </div>
                </div>
              </Col>
            ))}
          </Row>
          
        </div>
      )}
      <br/><br/>
    </div>
    
  );
}
