import React from 'react'
import Aside from '../Aside/Aside'
import Content from '../Content/Content'
import Footer from '../Footer/Footer'
import Header from '../Header/Header'

export const Main = () => {
    return (
        <div>
            <Header></Header>
            <Aside></Aside>
            <Content></Content>
            <Footer></Footer>
        </div>
    )
}
