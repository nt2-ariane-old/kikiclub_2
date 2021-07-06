import React, { Component } from "react";

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faBars } from '@fortawesome/free-solid-svg-icons'

export default class NavBar extends Component {
    constructor(props) {
        super(props)
        this.state = {
            isOpen: false
        }
    }
    setOpen = () => {
        this.setState({ isOpen: !this.state.isOpen })
    }
    render() {
        const { user, members } = this.props
        return (
            <nav className="navbar">
                <button className="navbar-toggle" onClick={this.setOpen}>
                    <FontAwesomeIcon icon={faBars} />
                </button>
                <ul className={this.state.isOpen ? 'navbar-menu open' : 'navbar-menu'} >
                    <li><a href='/'>Accueil</a></li>
                    <li><a href='/workshops'>Ateliers</a></li>
                    <li><a href="/robots">Robots</a></li>
                    {user &&
                        <div>
                            <li><a href="/members">Profils</a>
                                {members &&
                                    <ul>
                                        {members.map((member) => <li><a href={`profil/${member.id}`}>{member.firstname}</a></li>)}
                                    </ul>
                                }
                            </li>
                            <li><a href="/reference">Invitez un(e) ami(e)</a></li>
                            {
                                user.visibility > 1 &&
                                <li><a href="/administration">Administration</a></li>
                            }
                        </div>
                    }
                </ul>
            </nav>
        )
    }
}
