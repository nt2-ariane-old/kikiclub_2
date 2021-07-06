import React, { Component } from "react";
import apis from "../../api/api"
import errorlogger from '../../tools/errorlogger'
export default class Workshop extends Component {
    constructor(props) {
        super(props)
        this.state = {
            image_path: "",
        }
    }
    handleClick = () => {
        this.props.setModal('workshop', this.props.infos)
    }
    componentDidMount = () => {
        this.loadImage()
    }
    componentDidUpdate = (prevProps) => {
        if (this.props !== prevProps) {
            this.loadImage()
        }
    }
    loadImage = async () => {
        const { infos } = this.props
        await apis.getMedia(infos.id_media)
            .then(media => {
                media = media.data
                this.setState({ image_path: media.path })
            })
            .catch((err) => errorlogger(err))

    }
    render() {
        const { infos } = this.props
        const { image_path } = this.state
        return (
            <div onClick={this.handleClick} className="workshop">
                <img className="media" src={image_path} />
                <div className="title"><span>{infos.title}</span></div>
            </div>
        )
    }
}