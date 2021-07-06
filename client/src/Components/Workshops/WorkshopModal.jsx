import React, { Component } from "react";
import apis from "../../api/api";
import errorlogger from '../../tools/errorlogger'
export default class WorkshopModal extends Component {
    constructor(props) {
        super(props)
        this.state = {
            robots: null,
            niveaux: null,
            difficultes: null,
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
        let difficultes = []
        for (let index = 0; index < infos.difficultes.length; index++) {
            const element = infos.difficultes[index];
            await apis.getWorkshopFilterCategoryById('difficultes', element).then((res) => {
                res = res.data
                difficultes.push(res)
            })
        }
        this.setState({ difficultes })
        let niveaux = []
        for (let index = 0; index < infos.niveaux.length; index++) {
            const element = infos.niveaux[index];
            await apis.getWorkshopFilterCategoryById('niveaux', element).then((res) => {
                res = res.data
                niveaux.push(res)
            })
        }
        this.setState({ niveaux })
        let robots = []
        for (let index = 0; index < infos.robots.length; index++) {
            const element = infos.robots[index];
            await apis.getWorkshopFilterCategoryById('robots_taxo', element).then((res) => {
                res = res.data
                robots.push(res)
            })
        }
        this.setState({ robots })

    }
    render() {
        const { infos } = this.props
        const { robots, niveaux, difficultes, media_path } = this.state
        return (
            <div className="workshop-infos">
                <h2>{infos.title}</h2>
                <div className="workshop-body">

                    <div className="infos">

                        <div className="workshop-filters">
                            {
                                difficultes &&
                                <div><span className="label">Difficultés: </span> {difficultes.map((diff) => diff.name + " ")} </div>
                            }
                            {
                                niveaux &&
                                <div><span className="label">Année Scolaires: </span> {niveaux.map((grade) => grade.name + " ")}</div>
                            }
                            {
                                robots &&
                                <div><span className="label">Robots: </span> {robots.map((robot) => robot.name + " ")} </div>
                            }
                        </div>
                        <div className="workshop-description" dangerouslySetInnerHTML={{ __html: infos.body }}></div>
                    </div>
                    <div className="workshop-image">
                        <img src={media_path} alt="" />
                    </div>
                </div>

            </div>
        )
    }
}