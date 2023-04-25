import {
    BrowserRouter as Router,
    Route,
    Routes
} from "react-router-dom";
import React from 'react'
import Login from "../Login/Login";
import { Main } from "../Main/Main";
import Content from "../Content/Content";
import ContentUnavalible from "../ContentUnavaliableSites/ContentUnavaliableSites";
import ContentSitesAvalible from "../ContentAvaliableSites/ContentSitesAvaliable";

export const AppRouter = () => {

    return (
        <Router>
                <Routes>
                    <Route exact path="/login" element={ <Login/> }/>
                    <Route exact path="/main" element={ <Main/> } >
                        <Route index path="" element={ <Content/> } />
                        <Route path="sitiosOcupados" element={ <ContentUnavalible/> } />
                        <Route path="sitiosDisponibles" element={ <ContentSitesAvalible/> } />
                    </Route>
                </Routes>
        </Router>
    )
}