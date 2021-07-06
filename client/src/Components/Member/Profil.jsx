import React, { Component } from "react";

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faTools } from '@fortawesome/free-solid-svg-icons'

class Profil extends Component {
    componentDidMount = () => {
        const member = this.props.member;

        if (member.id) {

        }
    }
    setCurMember = (e) => {
        e.preventDefault()
        this.props.setCurMember(this.props.member.id, () => window.location = e.currentTarget.href)
        // 
    }
    render() {
        const { updateMode, member, isAdd, avatars } = this.props
        let avatar = null
        if (avatars) {
            avatar = avatars.find(element => element.id === member.id_avatar)
        }
        return (
            <div className='profil'>

                <a onClick={this.setCurMember} href={updateMode ? '/member/edit' : `/profil`}>
                    <div className='profil-avatar'><img src={avatar && avatar.media_path} alt="" /></div>
                    {
                        !isAdd &&
                        updateMode &&
                        <div className='profil-tool'> <FontAwesomeIcon icon={faTools} /></div>
                    }
                </a>
                <span className='profil-name'>{member.firstname}</span>
                {
                    member.ateliers && member.score
                    &&
                    <div className='profil-more-infos'>
                        <div className='profil-ateliers'>{member.ateliers} ateliers terminés</div>
                        <div className='profil-pts'>{member.score} points cummulés</div>
                    </div>

                }
                {
                    member.notification &&
                    <div className='profil-notification'>
                        <div className='notif-text'>
                            {member.notification}
                        </div>
                    </div>
                }

            </div>
        )
    }
}

export default Profil