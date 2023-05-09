import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";
import Header from "../Header/Header";
import { Outlet } from 'react-router-dom'
import ResRec from './ResponderReclamo'



export default function SolAct(){

    return (
        <div>
            <Header></Header>
            <Aside></Aside>
            {/* <Content></Content> */}
            <ResRec></ResRec>
            <Outlet/>
            <Footer></Footer>
        </div>
    )





}