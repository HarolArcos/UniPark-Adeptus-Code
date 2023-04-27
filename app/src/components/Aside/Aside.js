import React from 'react'
import { Link } from 'react-router-dom'
import Opcions from "./User/Opciones.jsx";
let user = require("./User/User.json").usuarios[0];

export default function Aside() {
  return (
    <aside className="main-sidebar sidebar-dark-primary elevation-4">
      {/* Brand Logo */}

      <a to="index3.html" className="brand-link">
        <img
          src="dist/img/uni-park.png"
          alt="AdminLTE Logo"
          className="brand-image img-circle elevation-3"
          style={{
            opacity: ".8",
            marginLeft: "-1px",
            marginTop: "-15px",
            maxHeight: "55px",
            border: "10px",
          }}
        />
        <span className="brand-text font-weight-light">UNI-PARK</span>
      </a>
      {/* Sidebar */}
      <div className="sidebar">
        {/* Sidebar user panel (optional) */}
        <div className="user-panel mt-3 pb-3 mb-3 d-flex">
          <div className="info">
            <a to="#" className="d-block">
              {user["nombre"]} {user["apellido"]}
            </a>
          </div>
        </div>
        {/* SidebarSearch Form */}
        <div className="form-inline">
          <div className="input-group" data-widget="sidebar-search">
            <input
              className="form-control form-control-sidebar"
              type="search"
              placeholder="Buscar"
              aria-label="Search"
            />
            <div className="input-group-append">
              <button className="btn btn-sidebar">
                <i className="fas fa-search fa-fw" />
              </button>
            </div>
          </div>
        </div>
        {/* Sidebar Menu */}
        <nav className="mt-2">
          <ul
            className="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview"
            role="menu"
            data-accordion="false"
          >
            <Opcions />
          </ul>
        </nav>
        {/* /.sidebar-menu */}
      </div>
      {/* /.sidebar */}
    </aside>
  );
}
