import React, { Component } from "react";
import apis from '../../api/api'
import errorlogger from '../../tools/errorlogger'
export default class RobotModal extends Component {
    constructor(props) {
        super(props)
        this.state = {
            niveaux: null,
            media_path: ""
        }
    }
    componentDidMount = async () => {
        const { infos } = this.props
        await apis.getMedia(infos.id_media)
            .then(media => {
                media = media.data
                this.setState({ media_path: media.path })
            })
            .catch((err) => errorlogger(err))

        let niveaux = []
        for (let index = 0; index < infos.niveaux.length; index++) {
            const element = infos.niveaux[index];
            await apis.getWorkshopFilterCategoryById('niveaux', element).then((res) => {
                res = res.data
                niveaux.push(res)
            })
        }
        this.setState({ niveaux })



    }
    render() {
        const { infos } = this.props
        const { niveaux,media_path } = this.state
        return (
            <div className="robot-infos">
                <div>
                    <img src={media_path}/>
                </div>
                <div className="robot-desc">
                    <h2>{infos.title}</h2>
                    <div className="robot-filters">
                        {
                            niveaux &&
                            <div><span className="label">Année Scolaires: </span> {niveaux.map((grade) => grade.name + " ")}</div>
                        }
                    </div>
                    <div dangerouslySetInnerHTML={{ __html: infos.body }}>
                    </div>
                </div>

            </div>
        )
    }
}