import React from "react";


const Admin = (props) => {
    if (props.user) {
        if (props.user.visibility > 1) {
            return (
                <div className="admin-console">

                </div>
            )
        }
        else {
            window.location = '/'
        }
    }
    else {
        return ('Loading...')
    }
}

export default Admin