import React, { Component } from "react";

import apis from '../../api/api'
import errorlogger from '../../tools/errorlogger'
import WorkshopsFilter from './WorkshopsFilter'
// import 'bootstrap/dist/css/bootstrap.min.css';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faTimes } from '@fortawesome/free-solid-svg-icons'

import Workshop from './Workshop'
import { Container, Row, Col } from 'fluid-react'
export default class Workshops extends Component {
    constructor(props) {
        super(props)
        this.state = {
            workshops: [],
            page: 1,
            nb_pages: 1,
            filterMenuActive: false,
            sort_value: "none"
        }
    }
    componentDidMount = async () => {
        await apis.getAllWorkshops()
            .then(workshops => {
                this.setState({ workshops: workshops.data, nb_pages: Math.ceil(workshops.data.length / 12) }, this.sortWorkshops)
            })
            .catch((err) => errorlogger(err))
    }
    setFilterActive = () => {
        this.setState({ filterMenuActive: !this.state.filterMenuActive })
    }
    setPage = (page) => {
        this.setState({ page: page })
    }
    handleSort = e => {
        const value = e.target.value;
        this.setState({ sort_value: value }, this.sortWorkshops);
    }
    setWorkshops = workshops => {
        this.setState({ workshops }, this.sortWorkshops)
    }
    sortWorkshops = async () => {
        const sort_value = this.state.sort_value
        let workshops = this.state.workshops
        switch (sort_value) {
            case "none":
                workshops.sort((a, b) => a.id - b.id);
                break;
            case "recents":
                workshops.sort((a, b) => b.id - a.id);
                break;
            case "ascName":
                workshops.sort(function (a, b) {
                    if (a.title < b.title) { return -1; }
                    if (a.title > b.title) { return 1; }
                    return 0;
                });
                break;
            case "descName":
                workshops.sort(function (a, b) {
                    if (a.title > b.title) { return -1; }
                    if (a.title < b.title) { return 1; }
                    return 0;
                });
                break;

            default:
                break;
        }
        this.setState({ workshops })
    }
    render() {
        let { workshops, page, nb_pages, sort_value } = this.state
        workshops = workshops.slice((page - 1) * 12, ((page - 1) * 12) + 12)
        let pages = []
        for (let index = 1; index <= nb_pages; index++) {
            pages.push(index)
        }
        return (
            <div className="workshops">
                <div className="workshops-header">
                    <h2>Les <span className='kikicode-color'>Ateliers</span></h2>
                    <a href='https://www.kikicode.ca/reservation-ateliers-libres' className='kikicode-btn'>Réserver des ateliers</a>
                </div>
                <button className='workshops-active-filter' onClick={this.setFilterActive}>
                    Filtrer
                </button>
                <div className="workshops-page">
                    <div className={this.state.filterMenuActive ? "workshops-nav active" : "workshops-nav"}>
                        <button className='workshops-active-filter x-btn' onClick={this.setFilterActive} >
                            <FontAwesomeIcon icon={faTimes} />
                        </button>
                        <WorkshopsFilter setWorkshops={this.setWorkshops} />
                    </div>
                    <div className="workshops-content">
                        <div id="sort_select">
                            <select value={sort_value} onChange={this.handleSort}>
                                <option value="none" selected="">Trier par</option>
                                <option value="recents">Plus récents</option>
                                <option value="ascName">Noms (A-Z)</option>
                                <option value="descName">Noms (Z-A)</option>
                            </select>
                        </div>
                        <Container>
                            <Row>
                                {workshops.map((workshop, i) =>
                                    <Col key={i} md={3}><Workshop infos={workshop} setModal={this.props.setModal} /></Col>
                                )}
                            </Row>
                        </Container>
                        <div className="pages-index">
                            {
                                pages.map((page, i) =>
                                    <button key={i} onClick={() => this.setPage(page)}>{page}</button>
                                )
                            }
                        </div>
                    </div>
                </div>

            </div>
        )
    }
}
