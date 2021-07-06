import React from "react";

import NavBar from './NavBar'
import UserInfos from "./UserInfos";

const Header = (props) => {
    return (
        <header className="App-header">
            <NavBar user={props.user} members={props.members} />
            <a href='/'><h1><span className='kikicode-color'>Kiki</span>club</h1></a>
            <UserInfos user={props.user} curMember={props.curMember} />
        </header>
    )
}

export default Header