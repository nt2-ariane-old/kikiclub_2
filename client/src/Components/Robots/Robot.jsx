import React, { Component } from "react";
import apis from '../../api/api'
import errorlogger from '../../tools/errorlogger'
class Profil extends Component {
    constructor(props) {
        super(props)
        this.state = {
            media_path: "",
        }
    }
    handleClick = () => {
        this.props.setModal('robot', this.props.robot)
    }
    componentDidMount = () => {
        this.loadImage()
    }
    loadImage = async () => {
        const { robot } = this.props
        await apis.getMedia(robot.id_media)
            .then(media => {
                media = media.data
                this.setState({ media_path: media.path })
            })
            .catch((err) => errorlogger(err))

    }
    render() {
        const { robot } = this.props
        const {media_path} = this.state
        return (
            <div className='robot' onClick={this.handleClick}>
                <img src={media_path} />
            </div>
        )
    }
}

export default Profil