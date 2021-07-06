import React, { Component } from "react";

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faTimes } from '@fortawesome/free-solid-svg-icons'

export default class Modal extends Component {

    render() {
        const { children } = this.props
        return (
            <div className="modal" >
                <button onClick={this.props.closeModal} className="close_modal"><FontAwesomeIcon icon={faTimes}/></button>
                <div className="inner_modal">
                    {children}
                </div>
            </div>
        )
    }
}