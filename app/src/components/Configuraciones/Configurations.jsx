import React, { useState } from 'react';
import { Outlet } from 'react-router-dom';
import Footer from '../Footer/Footer';
import Header from '../Header/Header';
import Aside from '../Aside/Aside';
import './Configuration.css'
import { useFetch } from '../../hooks/HookFetchListData';
import Dias from './ConfiguracionDias';
import { useFetchSendData } from '../../hooks/HookFetchSendData';
import NumeroSitios from './ConfigSitios';
import ConfiguracionesContac from './ConfigDatosDeContacto';
export default function Configura () {
    const [activeTab, setActiveTab] = useState(0);

  const handleTabClick = (index) => {
    setActiveTab(index);
  };
const { data, loading, error }= useFetch("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiConfiguracion/apiConfiguracion.php/listConfiguration")
    const{ fetchData }= useFetchSendData()
if (!loading) {
    console.log(data);
    return (
        <div>
          <Header></Header>
          <Aside></Aside>
          <div className="content-wrapper contenteSites-body">
          <div className="tab-container">
            <div className="tab-buttons">
              <button
                className={`tab-button ${activeTab === 0 ? 'active-tab' : ''}`}
                onClick={() => handleTabClick(0)}
              >
                Datos de Contacto
              </button>
              <button
                className={`tab-button ${activeTab === 1 ? 'active-tab' : ''}`}
                onClick={() => handleTabClick(1)}
              >
                Horario de Dias
              </button>
              <button
                className={`tab-button ${activeTab === 2 ? 'active-tab' : ''}`}
                onClick={() => handleTabClick(2)}
              >
                Numero de Sitios
              </button>
            </div>

            <div className="tab-content">
              {activeTab === 0 && <ConfiguracionesContac configuraciones={data.filter(
    (configuracion) =>
      configuracion.configuracion_nombre === 'telefono' ||
      configuracion.configuracion_nombre === 'grupo_telegram' ||
      configuracion.configuracion_nombre === 'token_bot'
  )} fetchData={fetchData} />}
              {activeTab === 1 && (
                <Dias
                  dia={data.filter((obj) => {
                    const diaSemana = obj.configuracion_nombre.toLowerCase();
                    return (
                      diaSemana === 'lunes' ||
                      diaSemana === 'martes' ||
                      diaSemana === 'miercoles' ||
                      diaSemana === 'jueves' ||
                      diaSemana === 'viernes' ||
                      diaSemana === 'sabado' ||
                      diaSemana === 'domingo'
                    );
                  })}
                  fetchData={ fetchData } // Extrae la función fetchData del hook useFetchSendData
                />
              )}
              {activeTab === 2 && <NumeroSitios sitios={data.filter((obj)=> obj.configuracion_nombre==="numero_sitios")} fetchData={ fetchData }/>}
            </div>
          </div>
        </div>
        <Outlet />
          <Footer></Footer>
        </div>
      );
}
  
  };