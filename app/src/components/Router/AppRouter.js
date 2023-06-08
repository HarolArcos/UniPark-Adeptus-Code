import {
    BrowserRouter as Router,
    Route,
    Routes
} from "react-router-dom";
import React from 'react'
import Login from "../Login/Login";
import { Main } from "../Main/Main";
import ContentUnavalible from "../ContentUnavaliableSites/ContentUnavaliableSites";
import ContentSitesAvalible from "../ContentAvaliableSites/ContentSitesAvaliable";
//import AssignSite from "../AssignSite/AssignSite";
//import ReassignSite from "../ReassignSite/ReassignSite";
//import { Client } from "../Client/Client";
import { Guard } from "../Guard/Guard";
//import ComboboxReferences from "../ComboboxReferences/ComboboxReferences";
import Persons from "../Persons/Persons";
import SolucionAccionReclamo from "../PaginaSolucionReclamo/SolucionAccionReclamo";
import ComboboxPerson from "../ComboboxPerson/ComboboxPerson";
import {VehicleEdit } from "../Vehicle/VehicleEdit";
import ListCli from "../ListasDeUsuario/ListaCliente";
import EditPerson from "../Persons/EditPerson";
import DeletePerson from "../Persons/ChangeState/ChangeStatePerson";
import { Solicitude } from "../Solicitude/Solicitude";
import { SubscriptionList } from "../Subscription/SuscriptionToList";
import Employee from "../Employee/Employee";
import EditEmpleado from "../Employee/EditEmpleado";
import Event from "../Event/Event";
import ViewEmployee from "../Employee/ViewEmployee";
import ViewPerson from "../Persons/ViewPerson";
import { TarifaEdit } from "../Tarifa/TarifaEdit";
import Mensaje from "../MensajesGlobales/GroupTelegram";
import ReclamoConsulta from "../Reclamo-Consulta/RecCon";
import { SubscriptionToChangeStatus } from "../Subscription/SuscriptionToChangeStatus";
import ListaPag from "../Listar Pagos/ListaPago";
import Configurations from "../Configuraciones/Configurations";
import { SolicitudeList } from "../Subscription/SolicitudeList";
import { SubscriptionEdit } from "../Subscription/SubscriptionEdit";
import { SolicitudeToChangeStatus } from "../Subscription/SolicitudeToChangeStatus";
import { TarifaListCreate } from "../Tarifa/TarifaListAndCreate";
import { VehicleListCreate } from "../Vehicle/VehicleListAndCreate";


export const AppRouter = () => {

    return (
        <Router>
                <Routes>
                    {/*---------------------------Rutas------------------------ */}
                    <Route exact path="/"                   element={ <Login/> }/>
                    <Route path="/main"                     element={ <Main/> } />
                    {/* Sitios */}
                    <Route path="/sitiosDisponibles"        element={ <ContentSitesAvalible/> }  />
                    <Route path="/sitiosOcupados"           element={ <ContentUnavalible/> } />
                    {/* <Route path="/asignarSitio"             element={ <AssignSite/> } />
                    <Route path="/reasignarSitio"           element={ <ReassignSite /> } />
                    <Route path="/clientes"                 element={ <Client/> } /> */}
                    <Route path='/guard'                    element={ <Guard/>} />
                    <Route path="/listClientes"             element={ <Persons/> } />
                    <Route path="/editClientes"             element={ <EditPerson/> }/>
                    <Route path="/statusClientes"           element={ <DeletePerson/> } />
                    <Route path="/viewClientes"             element={ <ViewPerson/> } />
                    <Route path="/listEmpleados"            element={ <Employee/> }/>
                    <Route path="/editEmpleados"            element={ <EditEmpleado/> }/>
                    <Route path="/viewEmpleados"            element={ <ViewEmployee/> }/>


                    <Route path='/ReclamosResp'             element={ <SolucionAccionReclamo/>} />
                    <Route path="/comboboxPerson"           element={ <ComboboxPerson/> } />
                    <Route path="/evento"                   element={ <Event/> }/>
                    <Route path="/editPersonas"             element={ <EditPerson/> }/>
                    <Route path="/deletePersonas"           element={ <DeletePerson/> } />
                    <Route path="/listMensaje"              element={ <ListCli/> } />
                    {/* Vehiculo */}
                    <Route path="/registrarVehiculo"             element={ <VehicleListCreate crear={true}/> } /> {/* Registrar datos de Vehiculo */} 
                    <Route path="/listvehiculo"             element={ <VehicleListCreate/> } /> {/* Ver Lista de Vehiculos */} 
                    <Route path="/listEditarVehiculo"       element={ <VehicleEdit/> } />{/* Modificar datos de Vehiculo */}
                    {/* Solicitud */}
                    <Route path="/listaSolicitudes"         element={ <SolicitudeList/> } />            {/* Ver Lista de Solicitudes */}
                    <Route path="/listaEstadoSolicitudes"   element={ <SolicitudeToChangeStatus/> } />  {/* Modificar Estado de Solicitud */}
                    <Route path="/solicitud"                element={ <Solicitude/> } />                {/* Realizar Solicitud*/}
                    
                    <Route path="/MensajeGlobal"            element={ <Mensaje/> } />
                    <Route path="/Reclamos"                 element={ <ReclamoConsulta/> } />
                    <Route path="/listaEnMora"      element={ <SubscriptionToChangeStatus /> } />
                    {/* Suscipcion */}
                    <Route path="/listaEstadoSuscripciones" element={ <SubscriptionToChangeStatus /> } /> {/* Modificar Estado de Suscripcion*/}
                    <Route path="/listaSuscipciones"        element={ <SubscriptionList /> } />           {/* Ver lista de Suscripciones */}
                    <Route path="/listaEditarSuscipciones"        element={ <SubscriptionEdit /> } />     {/* Modificar Datos deSuscripciones*/}
                    
                    <Route path="/ListaPagos"               element={ <ListaPag/> } />
                    <Route path="/Configurar"               element={ <Configurations/> } />
                    {/* Tarifa */}
                    <Route path="/registrarTarifa"               element={ <TarifaListCreate crear={true}/> } /> {/* Registrar datos de Tarifa */}
                    <Route path="/listaTarifa"                   element={ <TarifaListCreate /> } />             {/* Ver Lista de Tarifas */}
                    <Route path="/editartarifa"                   element={ <TarifaEdit/> } />                   {/* Modificar datos de Tarifa */}
                    
                </Routes>
        </Router>
    )
}
