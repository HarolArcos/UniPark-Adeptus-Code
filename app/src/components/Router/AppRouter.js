import {
    BrowserRouter as Router,
    Route,
    Routes
} from "react-router-dom";
import React from 'react'
import Login from "../Login/Login";
import { Main } from "../Main/Main";
//import Content from "../Content/Content";
import ContentUnavalible from "../ContentUnavaliableSites/ContentUnavaliableSites";
import ContentSitesAvalible from "../ContentAvaliableSites/ContentSitesAvaliable";
//import { Contact } from "../Contact/Contact";
//import { Client } from "../Client/Client";
import AssignSite from "../AssignSite/AssignSite";
import ReassignSite from "../ReassignSite/ReassignSite";
import { Client } from "../Client/Client";
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
import { Tarifa } from "../Tarifa/Tarifa";

export const AppRouter = () => {

    return (
        <Router>
                <Routes>
                    <Route exact path="/"               element={ <Login/> }/>
                    <Route path="/main"                 element={ <Main/> } />
                    <Route path="/sitiosDisponibles"    element={ <ContentSitesAvalible/> }  />
                    <Route path="/sitiosOcupados"       element={ <ContentUnavalible/> } />
                    <Route path="/asignarSitio"         element={ <AssignSite/> } />
                    <Route path="/reasignarSitio"       element={ <ReassignSite /> } />
                    <Route path="/clientes"             element={ <Client/> } />
                    <Route path="/personas"             element={ <Persons/> } />
                    <Route path="/referencias"          element={ <ComboboxReferences/> }/>
                    <Route path='/guard'                element={ <Guard/>} />
                    <Route path='/ReclamosResp'         element={ <SolucionAccionReclamo/>} />
                    <Route path="/comboboxPerson"       element={ <ComboboxPerson/> } />
                    <Route path="/editPersonas"         element={ <EditPerson/> }/>
                    <Route path="/deletePersonas"       element={ <DeletePerson/> } />
                    <Route path="/listCliente"             element={ <ListCli/> } />
                    <Route path="/listvehiculo"         element={ <ListVehicle/> } />
                    <Route path="/listDeletevehiculo"   element={ <Vehicle/> } />
                    <Route path="/solicitud"            element={ <Solicitude/> } />
                    <Route path="/solicitudesEnProceso"       element={ <SubscriptionInProcess/> } />
                    <Route path="/tarifa"       element={ <Tarifa/> } />

                </Routes>
        </Router>
    )
}

/* <Route path="/main/" element={ <Main/> } >
                        <Route index path="" element={ <Content/> } />
                        <Route path="sitiosOcupados" element={ <ContentUnavalible/> } />
                        <Route path="sitiosDisponibles" element={ <ContentSitesAvalible/> } />
                    </Route> */
