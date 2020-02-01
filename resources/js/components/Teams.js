import React, {Component, Fragment} from 'react';
import TeamCard from "./TeamCard";
import api from './api';
import Pagination from "./Pagination";
import {BrowserRouter, Route} from "react-router-dom";

class Teams extends Component {

    constructor(props) {
        super(props);
        const page = this.props.match.params.id;
        console.log(page);
        this.state = {
            teams: [],
            isLoading: true,
            teamsLoading: true
        };
    }

    componentDidMount() {
        api.get('teams')
            .then((resp) => {
                this.setState({
                    teams: resp.data.teams,
                    isLoading: false
                });
            })
    }

    displayTeams() {
        console.log('in display teams');
        if (this.state.isLoading) {
            return <p>Loading...</p>
        } else {
            return this.state.teams.data.map((team, index) => {
                return <TeamCard team={team} key={index}/>
                // return <Route exact path="react/teams/:id" key={index} component={() => {
                // }}/>
            });
        }
    }

    displayPagination() {
        return <Pagination items={this.state.teams}/>
    }

    render() {
        if (this.state.isLoading)
            return null;
        return (
            <Fragment>
                <div className="row justify-content-center">
                    {this.displayTeams()}
                </div>
                {this.displayPagination()}

            </Fragment>
        );
    }
}

export default Teams;
