import React, { Component } from "react";

import apis from "../../api/api"
import errorlogger from '../../tools/errorlogger'

export default class Login extends Component {
    constructor(props) {
        super(props)
        this.state = {
            courriel: "",
            passwd: ""
        }
    }
    componentDidMount = () => {

    }
    componentDidUpdate = (prevProps) => {

    }
    handleLogin = (e) => {
        e.preventDefault()
        apis.login({ "email": this.state.courriel, "password": this.state.passwd }).then((res) => {
            console.log(res.data)
        }).catch((e) => console.log(e))
    }
    handleChange = (event) => {
        this.setState({ [event.target.name]: event.target.value });
    }

    render() {
        return (
            <div className="login">
                <form>
                    <label>
                        Courriel
                        <input type="text" value={this.state.courriel} onChange={this.handleChange} name="courriel" placeholder="Courriel" />
                    </label>
                    <label>
                        Mot de Passe
                        <input type="password" value={this.state.passwd} onChange={this.handleChange} name="passwd" placeholder="Mot de Passe" />
                    </label>
                    <button type="submit" onClick={this.handleLogin}>Se Connecter</button>
                </form>
            </div>
        )
    }
}