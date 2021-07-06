import React from "react";
import apis from "../../api/api";

const UserInfos = (props) => {
    const login = (e) => {
        e.preventDefault()


    }
    return (
        <div className="user-infos">
            {props.user ?
                <a href='/?logout=true'>Déconnecter {props.user.firstname}</a>
                :
                <a href='/login' >Se connecter</a>
            }
            {props.curMember &&
                <div className="infos-cur-member">
                    {props.curMember.firstname}
                </div>
            }
        </div>
    )
}

export default UserInfos