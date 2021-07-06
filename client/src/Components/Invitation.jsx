import React from "react";

const Invitation = (props) => {
    let code = 'XHFDS'
    return (
        <div className="inventation">
            <div className='info'>
                <h2>Recommandez à vos ami(es)!</h2>
                <p>Envoyez votre code à votre ami(e), et à sa première connexion, chacun des membres de votre famille et de la sienne recevra 1 point!</p>
                <p><b>Voice votre code : </b><span>{code}</span></p>
                <h3>Inviter un(e) ami(e)</h3>
                <input type="text" name="reference" id="reference" value={`https://www.kikicode.club/reference.php?token=${code}`} />
                <a href='/workshops' className='kikicode-btn'>
                    Envoyer a un(e) ami(e)
                </a>
            </div>
        </div>
    )
}

export default Invitation