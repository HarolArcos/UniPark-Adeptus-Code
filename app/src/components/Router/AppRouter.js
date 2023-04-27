import {
    BrowserRouter as Router,
    Navigate,
    Route,
    Routes
} from "react-router-dom";
import React from 'react'
import Login from "../Login/Login";
import { Main } from "../Main/Main";
import { Contact } from "../Contact/Contact";
import { Client } from "../Client/Client";


export const AppRouter = () => {

    return (
        <Router>
                <Routes>
                    <Route exact={true} path='/login' element={<Login></Login>} ></Route>
                    <Route exact={true} path='/main' element={<Main></Main>} ></Route>
                    <Route exact={true} path='/client' element={<Client></Client>} ></Route>
                </Routes>
        </Router>
    )
}