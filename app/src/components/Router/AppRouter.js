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
import { Vehicle } from "../Vehicle/Vehicle";
import ListCli from "../ListasDeUsuario/ListaCliente";
import EditPerson from "../Persons/EditPerson";
import DeletePerson from "../Persons/ChangeState/ChangeStatePerson";
import { ListVehicle } from "../Vehicle/ListVehicle";
import { Solicitude } from "../Solicitude/Solicitude";
import { SubscriptionInProcess } from "../Subscription/SuscripcionInProcess";
import Employee from "../Employee/Employee";
import EditEmpleado from "../Employee/EditEmpleado";
import Event from "../Event/Event";
import ViewEmployee from "../Employee/ViewEmployee";
import ViewPerson from "../Persons/ViewPerson";
import { Tarifa } from "../Tarifa/Tarifa";
import Mensaje from "../MensajesGlobales/GroupTelegram.jsx";
import ReclamoConsulta from "../Reclamo-Consulta/RecCon";
import ListaPag from "../Listar Pagos/ListaPago";
import Configurations from "../Configuraciones/Configurations";


export const AppRouter = () => {

    return (
        <Router>
                <Routes>
                    {/*---------------------------Rutas------------------------ */}
                    <Route exact path="/"               element={ <Login/> }/>
                    <Route path="/main"                 element={ <Main/> } />
                    <Route path="/sitiosDisponibles"    element={ <ContentSitesAvalible/> }  />
                    <Route path="/sitiosOcupados"       element={ <ContentUnavalible/> } />
                    {/* <Route path="/asignarSitio"         element={ <AssignSite/> } /> */}
                    {/* <Route path="/reasignarSitio"       element={ <ReassignSite /> } /> */}
                    {/* <Route path="/clientes"             element={ <Client/> } /> */}
                    <Route path='/guard'                element={ <Guard/>} />
                    <Route path="/listClientes"         element={ <Persons/> } />
                    <Route path="/editClientes"         element={ <EditPerson/> }/>
                    <Route path="/statusClientes"       element={ <DeletePerson/> } />
                    <Route path="/viewClientes"         element={ <ViewPerson/> } />
                    <Route path="/listEmpleados"        element={ <Employee/> }/>
                    <Route path="/editEmpleados"        element={ <EditEmpleado/> }/>
                    <Route path="/viewEmpleados"        element={ <ViewEmployee/> }/>


                    <Route path='/ReclamosResp'         element={ <SolucionAccionReclamo/>} />
                    <Route path="/comboboxPerson"       element={ <ComboboxPerson/> } />
                    <Route path="/evento"               element={ <Event/> }/>
                    <Route path="/editPersonas"         element={ <EditPerson/> }/>
                    <Route path="/deletePersonas"       element={ <DeletePerson/> } />
                    <Route path="/listMensaje"          element={ <ListCli/> } />
                    <Route path="/listvehiculo"         element={ <ListVehicle/> } />
                    <Route path="/listEditarVehiculo"   element={ <Vehicle/> } />
                    <Route path="/solicitud"            element={ <Solicitude/> } />
                    <Route path="/solicitudesEnProceso" element={ <SubscriptionInProcess/> } />
                    <Route path="/tarifa"               element={ <Tarifa/> } />
                    <Route path="/MensajeGlobal"        element={ <Mensaje/> } />
                    <Route path="/Reclamos"             element={ <ReclamoConsulta/> } />
                    <Route path="/ListaPagos"             element={ <ListaPag/> } />
                    <Route path="/Configurar"             element={ <Configurations/> } />
                </Routes>
        </Router>
    )
}
