import React, { Component } from "react";
import apis from '../../api/api'
import errorlogger from '../../tools/errorlogger'
export default class WorkshopsFilter extends Component {
    constructor(props) {
        super(props)
        this.state = {
            taxonomies: null,
            diffIsOpen: false,
            agesIsOpen: false,
            robotsIsOpen: false,
            selected_taxonomies: {
                "difficultes": [],
                "niveaux": [],
                "robots": [],
            }
        }
    }
    componentDidMount = () => {
        this.loadTaxonomies()
    }
    loadTaxonomies = async () => {
        await apis.getAllWorkshopFilters().then(res => {
            this.setState({ taxonomies: res.data })
        }).catch((e) => errorlogger(e))
    }
    handleClick = e => {
        e.persist()
        const target = e.target.dataset.target
        this.setState({ [target]: !this.state[target] })
    }

    handleChange = e => {
        e.persist()
        const slug = e.target.id
        const category = e.target.parentElement.parentElement.parentElement.id
        const selected_taxonomies = this.state.selected_taxonomies
        if (!selected_taxonomies[category]) {
            selected_taxonomies[category] = []
        }
        if (selected_taxonomies[category].includes(slug)) {
            const index = selected_taxonomies[category].indexOf(slug);
            if (index > -1) {
                selected_taxonomies[category].splice(index, 1);
            }
        }
        else {
            selected_taxonomies[category].push(slug)
        }
        this.setState(selected_taxonomies, this.filterWorkshops)
    }
    filterWorkshops = () => {
        apis.filterWorkshops(this.state.selected_taxonomies).then(res => {
            this.props.setWorkshops(res.data)
        }).catch((e) => errorlogger(e))
    }
    deleteFilter = () => {
        this.setState({
            selected_taxonomies: {
                "difficultes": [],
                "niveaux": [],
                "robots": [],
            }
        }, this.filterWorkshops)
    }
    render() {
        const { robotsIsOpen, taxonomies, diffIsOpen, agesIsOpen, selected_taxonomies } = this.state
        console.log(selected_taxonomies)
        return (
            <div className="workshops-filter">
                <h2>Filtrer</h2>
                {
                    taxonomies &&
                    <div className='workshops-filter-body'>
                        <div className='filter'>
                            <button data-target='diffIsOpen' onClick={this.handleClick}>Difficulté <span>{diffIsOpen ? '-' : '+'}</span></button>

                            <ul className={diffIsOpen ? 'filters-list open' : 'filters-list'} id="difficultes" >
                                {
                                    taxonomies["difficultes"].map((diff, i) =>
                                        <li key={'diff_' + i}>
                                            <label key={diff["slug"]}>
                                                <input type="checkbox" checked={selected_taxonomies["difficultes"] && selected_taxonomies["difficultes"].includes(diff["id"].toString())} id={diff["id"]} onChange={this.handleChange} />
                                                <span className='checkmark'>
                                                </span>{diff["name"]}
                                            </label>
                                        </li>
                                    )
                                }
                            </ul>


                        </div>
                        <div className='filter'>
                            <button data-target='agesIsOpen' onClick={this.handleClick}>Année Scolaire suggérée <span>{agesIsOpen ? '-' : '+'}</span></button>
                            <ul className={agesIsOpen ? 'filters-list open' : 'filters-list'} id="niveaux">
                                {
                                    taxonomies["niveaux"].map((lvl, i) =>
                                        <li key={'lvl_' + i}>
                                            <label key={lvl["slug"]}>
                                                <input checked={selected_taxonomies["niveaux"] && selected_taxonomies["niveaux"].includes(lvl["id"].toString())} type="checkbox" id={lvl["id"].toString()} onChange={this.handleChange} />
                                                <span className='checkmark'>
                                                </span>{lvl["name"]}
                                            </label>
                                        </li>
                                    )
                                }
                            </ul>


                        </div>
                        <div className='filter'>
                            <button data-target='robotsIsOpen' onClick={this.handleClick}>Robots <span>{robotsIsOpen ? '-' : '+'}</span></button>

                            <ul className={robotsIsOpen ? 'filters-list open' : 'filters-list'} id="robots">
                                {
                                    taxonomies["robots"].map((bot, i) =>
                                        <li key={'bot_' + i}>
                                            <label key={bot["slug"]}>
                                                <input checked={selected_taxonomies["robots"] && selected_taxonomies["robots"].includes(bot["id"].toString())} type="checkbox" id={bot["id"]} onChange={this.handleChange} />
                                                <span className='checkmark'>
                                                </span>{bot["name"]}
                                            </label>
                                        </li>
                                    )
                                }
                            </ul>

                        </div>
                    </div>
                }
                <button id="delete_filters" onClick={this.deleteFilter}>Supprimer les filtres</button>
            </div>
        )
    }
}
