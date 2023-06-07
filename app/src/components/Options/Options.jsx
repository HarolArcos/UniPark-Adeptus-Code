import React from "react";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import {Tabs, Tab} from "react-bootstrap";
import FormAddRol from "./AddRol";
import AddOptions from "./AddOption";

export default function Options(){
    return(
        <>
        <Header></Header>
        <Aside></Aside>
        <div className="content-wrapper">
        <Tabs
            defaultActiveKey="profile"
            id="justify-tab-example"
            className="mb-3"
            justify
            >
                <Tab eventKey="Anadir Rol" title="Añadir Rol">
                    <FormAddRol/>
                </Tab>
                <Tab eventKey="Añadir opciones" title="Añadir Opciones">
                    <AddOptions/>
                </Tab>
                <Tab eventKey="longer-tab" title="Lista de Roles">
                    Tab content for Loooonger Tab
                </Tab>
            </Tabs>
        </div>
        <Footer></Footer>
        </>
    )
}