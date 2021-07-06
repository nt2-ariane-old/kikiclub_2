import React from "react";

import kikicode from '../img/logo/kikicode.png'
import café from '../img/logo/café.png'

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faFacebook } from '@fortawesome/free-brands-svg-icons'

const Footer = (props) => {
    return (
        <footer className="App-footer">
            <span className='logo'>@2020 par <a href='https://www.kikicode.ca/'>kikicode</a></span>
            <a className='logo' href='https://www.kikicode.ca/'><img src={kikicode} /></a>
            <a className='logo' href='https://www.codecafe.cafe/'><img src={café} /></a>
            <a className='logo' href='https://www.facebook.com/kikicode/'><FontAwesomeIcon icon={faFacebook} /></a>
        </footer>
    )
}

export default Footer