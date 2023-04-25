import React from "react";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import ContentUnavalible from "../ContentUnavaliableSites/ContentUnavaliableSites";


export const UnavaliableSites = () => {
    return(
        <div>
            <Header></Header>
            <Aside></Aside>
            <ContentUnavalible></ContentUnavalible>
            <Footer></Footer>
        </div>
    )
}