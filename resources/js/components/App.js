import React, {Component, Fragment} from 'react';
import Teams from "./Teams";
import Players from "./Players";
import Nav from "./Nav";
import {BrowserRouter, Route, Switch} from "react-router-dom";
import TeamCard from "./TeamCard";

export default class App extends Component {
    constructor(props) {
        super(props);
        this.state = {};
    }

    render() {
        return <main className="py-4" >

            <BrowserRouter>
                <Nav/>
                <Switch>
                    <Route exact path="/react/teams" component={Teams}/>
                    <Route path="/react/teams/:id" component={Teams}/>
                    {/*<Route exact path="/react/players" component={Players}/>*/}
                </Switch>
            </BrowserRouter>

            <div className="container">
                {/*<Teams/>*/}
                {/*<Players/>*/}
            </div>

        </main>
    }
}
