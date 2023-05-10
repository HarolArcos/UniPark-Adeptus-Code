import React from 'react'
import Aside from '../Aside/Aside'
// import Content from '../Content/Content'
import Footer from '../Footer/Footer'
import Header from '../Header/Header'
import { Outlet } from 'react-router-dom'
import DatosUser from '../DatosUser/DatosUser'

export const Main = () => {
    return (
        <div>
            <Header></Header>
            <Aside></Aside>
            <DatosUser/>
            {/* <Content></Content> */}
            <Outlet/>
            <Footer></Footer>
        </div>
    )
}


