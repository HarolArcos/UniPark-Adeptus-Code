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
import ComboboxReferences from "../ComboboxReferences/ComboboxReferences";
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
                    
                    
                    <Route path="/listvehiculo"         element={ <ListVehicle/> } />
                    <Route path="/listDeletevehiculo"   element={ <Vehicle/> } />
                    <Route path="/solicitud"            element={ <Solicitude/> } />
                    <Route path="/solicitudesEnProceso" element={ <SubscriptionInProcess/> } />
                    <Route path="/evento"               element={ <Event/> }/>

                    {/*---------------------------otros------------------------ */}
                    <Route path="/referencias"          element={ <ComboboxReferences/> }/>
                    <Route path="/msgIndividual"        element={ <ListCli/> } />

                </Routes>
        </Router>
    )
}
