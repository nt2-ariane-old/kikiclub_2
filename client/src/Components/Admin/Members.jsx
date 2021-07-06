import React, { Component } from "react";

import Carousel from 'react-multi-carousel';
import 'react-multi-carousel/lib/styles.css';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faPlus } from '@fortawesome/free-solid-svg-icons'
import Profil from "../Member/Profil";

export default class Members extends Component {
    constructor(props) {
        super(props)
        this.state = {
            members: props.members || null,
            // members: { 'Ajouter Membre': { prenom: 'Ajouter Membre', icon: <FontAwesomeIcon icon={faPlus} />, isAdd: true }, 'Ludovic': { prenom: 'Ludovic', icon: null, ateliers: 3, pts: 200, notification: 5 }, 'Lesly': { prenom: 'Lesly', icon: null }, 'Jean-Claude': { prenom: 'Jean-Claude', icon: null }, 'Test': { prenom: 'Test', icon: null }, 'Jean-Guy': { prenom: 'Jean-Guy', icon: null }, 'Belzebuth': { prenom: 'Belzebuth', icon: null } },
            updateMode: false
        }
    }
    setUpdate = () => {
        this.setState({ updateMode: !this.state.updateMode })
    }
    render() {
        const { members, updateMode } = this.state

        const responsive = {
            superLargeDesktop: {
                // the naming can be any, depends on you.
                breakpoint: { max: 4000, min: 3000 },
                items: 5
            },
            desktop: {
                breakpoint: { max: 3000, min: 1024 },
                items: 3
            },
            tablet: {
                breakpoint: { max: 1024, min: 464 },
                items: 2
            },
            mobile: {
                breakpoint: { max: 464, min: 0 },
                items: 1
            }
        };

        return (
            <div className="members">
                <div className="members-content">
                    {
                        members &&
                        <Carousel
                            infinite={true}
                            removeArrowOnDeviceType={["tablet", "mobile"]}
                            dotListClass="custom-dot-list-style"
                            swipeable={true}
                            draggable={true}
                            showDots={false}
                            responsive={responsive}
                        >
                            {
                                // <Profil member={{ prenom: 'Ajouter Membre', icon: <FontAwesomeIcon icon={faPlus} /> }} updateMode={updateMode} isAdd={true} />
                                members.map((member, i) => {
                                    return (
                                        <Profil avatars={this.props.avatars} setCurMember={this.props.setCurMember} member={member} updateMode={updateMode} isAdd={false} />
                                    )
                                })
                            }
                        </Carousel>
                    }
                </div>
                <div className="members-footer">
                    <button className='box-btn' onClick={this.setUpdate}>Modifier les profils</button>
                </div>
            </div>
        )
    }
}
