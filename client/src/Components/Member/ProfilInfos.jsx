import React, { Component } from 'react'
import apis from '../../api/api'
import errorlogger from '../../tools/errorlogger'
import { Container, Row, Col } from 'fluid-react'
import Workshop from '../Workshops/Workshop'
export default class ProfilInfos extends Component {
    constructor(props) {
        super(props)
        this.state = {
            newer: null,
            started: null,
            ended: null,
        }
    }
    componentDidMount = () => {
        if (this.props.curMember) {
            apis.getAllMemberWorkshopsCategorized(this.props.curMember.id).then(res => {
                let workshops = res.data
                const nouveaux = workshops.filter((element) => element.statut === "< Mes nouveaux défis >")
                const commencer = workshops.filter((element) => element.statut === "# J'ai pas eu le temps de terminer!")
                const terminer = workshops.filter((element) => element.statut === "== Yeah! J'ai réussi ces ateliers!")
                this.setState({ newer: nouveaux, started: commencer, ended: terminer })

            }).catch(e => errorlogger(e))
        }
        else {
            // window.location = "/"
        }
    }
    render() {
        const { ended, started, newer } = this.state
        return (
            <div className='profil-infos' >
                <h2>Informations</h2>
                {newer &&
                    <section>
                        <h3>{'< Mes nouveaux défis >'}</h3>
                        <Container fluid>
                            <Row>
                                {newer.map((workshop, i) =>
                                    <Col key={i} md={3}><Workshop infos={workshop} setModal={this.props.setModal} /></Col>
                                )}
                            </Row>
                        </Container>
                    </section>
                }
                {started &&
                    <section>
                        <h3>{'# J\'ai pas eu le temps de terminer!'}</h3>
                        <Container fluid>
                            <Row>
                                {started.map((workshop, i) =>
                                    <Col key={i} md={3}><Workshop infos={workshop} setModal={this.props.setModal} /></Col>
                                )}
                            </Row>
                        </Container>
                    </section>
                }
                {ended &&
                    <section>
                        <h3>{'== Yeah! J\'ai réussi ces ateliers!'}</h3>
                        <Container fluid>
                            <Row>
                                {ended.map((workshop, i) =>
                                    <Col key={i} md={3}><Workshop infos={workshop} setModal={this.props.setModal} /></Col>
                                )}
                            </Row>
                        </Container>
                    </section>
                }
                <h3>__ Badges</h3>
            </div>
        )
    }
}