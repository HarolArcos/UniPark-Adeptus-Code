import {
    BrowserRouter as Router,
    // Navigate,
    Route,
    Routes
} from "react-router-dom";
import React from 'react'
import Login from "../Login/Login";
import { Main } from "../Main/Main";
//import { Contact } from "../Contact/Contact";


export const AppRouter = () => {

    return (
        <Router>
                <Routes>
                    <Route exact path="/login" element={ <Login/> }/>
                    {/* <Route exact={true} path='/login' element={<Login></Login>} ></Route> */}
                    <Route exact path='/main' element={<Main/>} ></Route>
                </Routes>
        </Router>
    )
}