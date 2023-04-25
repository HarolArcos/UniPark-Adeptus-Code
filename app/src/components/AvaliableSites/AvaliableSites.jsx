import React from "react";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import ContentSitesAvalible from "../ContentAvaliableSites/ContentSitesAvaliable";


export const AvaliableSites = () => {
    return(
        <div>
            <Header></Header>
            <Aside></Aside>
            <ContentSitesAvalible></ContentSitesAvalible>
            <Footer></Footer>
        </div>
    )
}