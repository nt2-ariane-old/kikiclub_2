import React, { Component } from "react";
// import Slider from '../Slider'
import Robot from './Robot'
import Carousel from 'react-multi-carousel';
import 'react-multi-carousel/lib/styles.css';

import apis from '../../api/api'
import errorlogger from '../../tools/errorlogger'

export default class Robots extends Component {
    constructor(props) {
        super(props)
        this.state = {
            robots: []

        }
    }
    componentDidMount = async () => {
        await apis.getAllRobots()
            .then(robots => {
                this.setState({ robots: robots.data })
            })
            .catch((err) => errorlogger(err))
    }
    render() {
        const { robots } = this.state

        const responsive = {
            superLargeDesktop: {
                // the naming can be any, depends on you.
                breakpoint: { max: 4000, min: 3000 },
                items: 5
            },
            desktop: {
                breakpoint: { max: 3000, min: 1024 },
                items: 3
            },
            tablet: {
                breakpoint: { max: 1024, min: 464 },
                items: 2
            },
            mobile: {
                breakpoint: { max: 464, min: 0 },
                items: 1
            }
        };
        return (
            <div className="robots">
                <h2>Les <span className='kikicode-color'>Robots</span></h2>
                <Carousel
                    infinite={true}
                    removeArrowOnDeviceType={["tablet", "mobile"]}
                    dotListClass="custom-dot-list-style"
                    swipeable={true}
                    draggable={true}
                    showDots={false}
                    responsive={responsive}
                >
                    {robots.map((robot, index) =>
                        <div key={index}>
                            <Robot robot={robot} setModal={this.props.setModal} />
                        </div>
                    )}
                </Carousel>

            </div>
        )
    }
}
