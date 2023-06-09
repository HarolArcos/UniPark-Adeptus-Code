import React from "react";
import { useFetch } from "../../hooks/HookFetchListData";

export default function Header() {
   const { data, loading, error }= useFetch("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiConfiguracion/apiConfiguracion.php/listConfigurationHorario")
  const localStorageValue = localStorage.getItem("mora") || localStorage.getItem("sus");
  
  return (
    <nav className="main-header navbar navbar-expand navbar-white navbar-light">
      {/* Left navbar links */}
      <ul className="navbar-nav">
        <li className="nav-item">
          <a
            className="nav-link"
            data-widget="pushmenu"
            to="/#"
            role="button"
            href="Nada"
          >
            <i className="fas fa-bars" />
          </a>
        </li>

        <li className="nav-item d-none d-sm-inline-block">
          <a href="/contact" className="nav-link">
            Contact
          </a>
        </li>
        </ul>
        <ul className="navbar-nav ml-auto" >
        {localStorageValue && (
          <li className="nav-item d-none d-sm-inline-block" >
            <a className="nav-link" style={{ color: localStorageValue === localStorage.getItem("mora") ? "red" : "green" }}>
              {localStorageValue}
            </a>
          </li>
        )}
      </ul>

      {/* Right navbar links */}
      <ul className="navbar-nav ml-auto">
      <li className="nav-item dropdown">
  <a className="nav-link" data-toggle="dropdown" href="/#">
    Horarios de atención
  </a>
  <div className="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <span className="dropdown-item dropdown-header">Horario por día</span>
    <div className="dropdown-divider" />
    {!loading ? (
      data.sort((a, b) => parseInt(a.configuracion_id) - parseInt(b.configuracion_id)).map((dia) => (
        <a
          className="dropdown-item"
          key={dia.configuracion_id}
          onClick={(e) => e.preventDefault()} // Evitar acción predeterminada del clic
        >
          <label style={{ fontWeight: 'bold' }}>{dia.configuracion_nombre}:</label>
          <br />
          <div>Apertura: {dia.configuracion_valor1}</div>
          <div>Cierre: {dia.configuracion_valor2}</div>
        </a>
      ))
    ) : (
      <a className="dropdown-item">Cargando</a>
    )}
  </div>
</li>
    
      <li className="nav-item d-none d-sm-inline-block">
          <a href="/#" style={{ color: 'red' }} className="nav-link">Cerrar Sesión</a>
        </li>
      </ul>
    </nav>
  );
}

        {/* Messages Dropdown Menu 
        <li className="nav-item dropdown">
          <a className="nav-link" data-toggle="dropdown" href="/#">
            <i className="far fa-comments" />
            <span className="badge badge-danger navbar-badge">3</span>
          </a>
          <div className="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="/#" className="dropdown-item">*/}
        {/* Message Start 
              <div className="media">
                <img src="dist/img/user1-128x128.jpg" alt="User Avatar" className="img-size-50 mr-3 img-circle" />
                <div className="media-body">
                  <h3 className="dropdown-item-title">
                    Brad Diesel
                    <span className="float-right text-sm text-danger"><i className="fas fa-star" /></span>
                  </h3>
                  <p className="text-sm">Call me whenever you can...</p>
                  <p className="text-sm text-muted"><i className="far fa-clock mr-1" /> 4 Hours Ago</p>
                </div>
              </div>*/}
        {/* Message End 
            </a>
            <div className="dropdown-divider" />
            <a href="/#" className="dropdown-item">*/}
        {/* Message Start 
              <div className="media">
                <img src="dist/img/user8-128x128.jpg" alt="User Avatar" className="img-size-50 img-circle mr-3" />
                <div className="media-body">
                  <h3 className="dropdown-item-title">
                    John Pierce
                    <span className="float-right text-sm text-muted"><i className="fas fa-star" /></span>
                  </h3>
                  <p className="text-sm">I got your message bro</p>
                  <p className="text-sm text-muted"><i className="far fa-clock mr-1" /> 4 Hours Ago</p>
                </div>
              </div>*/}
        {/* Message End 
            </a>
            <div className="dropdown-divider" />
            <a href="/#" className="dropdown-item">*/}
        {/* Message Start 
              <div className="media">
                <img src="dist/img/user3-128x128.jpg" alt="User Avatar" className="img-size-50 img-circle mr-3" />
                <div className="media-body">
                  <h3 className="dropdown-item-title">
                    Nora Silvester
                    <span className="float-right text-sm text-warning"><i className="fas fa-star" /></span>
                  </h3>
                  <p className="text-sm">The subject goes here</p>
                  <p className="text-sm text-muted"><i className="far fa-clock mr-1" /> 4 Hours Ago</p>
                </div>
              </div>*/}
        {/* Message End 
            </a>
            <div className="dropdown-divider" />
            <a href="/#" className="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>*/}
        {/* Notifications Dropdown Menu 
        <li className="nav-item dropdown">
          <a className="nav-link" data-toggle="dropdown" href="/#">
            <i className="far fa-bell" />
            <span className="badge badge-warning navbar-badge">15</span>
          </a>
          <div className="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span className="dropdown-item dropdown-header">15 Notifications</span>
            <div className="dropdown-divider" />
            <a href="/#" className="dropdown-item">
              <i className="fas fa-envelope mr-2" /> 4 new messages
              <span className="float-right text-muted text-sm">3 mins</span>
            </a>
            <div className="dropdown-divider" />
            <a href="/#" className="dropdown-item">
              <i className="fas fa-users mr-2" /> 8 friend requests
              <span className="float-right text-muted text-sm">12 hours</span>
            </a>
            <div className="dropdown-divider" />
            <a href="/#" className="dropdown-item">
              <i className="fas fa-file mr-2" /> 3 new reports
              <span className="float-right text-muted text-sm">2 days</span>
            </a>
            <div className="dropdown-divider" />
            <a href="/#" className="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>
        <li className="nav-item">
          <a className="nav-link" data-widget="fullscreen" href="/#" role="button">
            <i className="fas fa-expand-arrows-alt" />
          </a>
        </li>
        <li className="nav-item">
          <a className="nav-link" data-widget="control-sidebar" data-slide="true" href="/#" role="button">
            <i className="fas fa-th-large" />
          </a>
        </li>
        */}
     