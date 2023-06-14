import React from "react";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
//import {Tabs, Tab} from "react-bootstrap";
import AddOptions from "./AddOption";
//import AddRolSection from "./AddRolSection";
import "./Options.css";

export default function Options(){
    return(
        <>
        <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper contenteSites-body" style={{minHeight: '100vh'}} >
        {/* <Tabs
            defaultActiveKey="profile"
            id="justify-tab-example"
            className="mb-3"
            justify
            >
                <Tab eventKey="Anadir Rol" title="Añadir Rol">
                    <AddRolSection/>
                </Tab>
                <Tab eventKey="Añadir opciones" title="Añadir Opciones">
                    
                </Tab>
            </Tabs> */}
            <div className="addOpciones">
                <AddOptions/>
            </div>
        </div>
        <Footer></Footer>
        </>
    )
}