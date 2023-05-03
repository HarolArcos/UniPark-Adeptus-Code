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

export const AppRouter = () => {

    return (
        <Router>
                <Routes>
                    <Route exact path="/" element={ <Login/> }/>
                    <Route  path="/main" element={ <Main/> } />
                    <Route path="/sitiosOcupados" element={ <ContentUnavalible/> } />
                    <Route path="/sitiosDisponibles" element={ <ContentSitesAvalible/> }  />
                    <Route path="/asignarSitio" element={ <AssignSite/> } />
                    <Route path="/reasignarSitio" element={ <ReassignSite /> } />
                    <Route path="/Clientes"  element={ <Client/> } />
                </Routes>
        </Router>
    )
}

/* <Route path="/main/" element={ <Main/> } >
                        <Route index path="" element={ <Content/> } />
                        <Route path="sitiosOcupados" element={ <ContentUnavalible/> } />
                        <Route path="sitiosDisponibles" element={ <ContentSitesAvalible/> } />
                    </Route> */