import React from "react";

import bg from '../img/bg/bg_home.gif'
const Header = (props) => {
    return (
        <div className="home">
            <img className='bg' src={bg} />
            <div className='info'>
                <h2>Bienvenue dans la communauté Kikiclub</h2>
                <p>Votre espace membre: Visionnez votre avancement. Accumulez des points et des badges</p>
                <a href='/workshops' className='kikicode-btn'>
                    Naviguer comme invité
                </a>
            </div>
        </div>
    )
}

export default Header