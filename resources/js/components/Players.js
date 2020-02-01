import React, {Component} from 'react';
import PlayerCard from "./PlayerCard";
import api from './api';
import Pagination from "./Pagination";

class Players extends Component {
    constructor(props) {
        super(props);
        this.state = {
            players: [],
            isLoading: true
        };
    }

    componentDidMount() {
        api.get('players')
            .then((resp) => {
                console.log(resp);
                this.setState({
                    players: resp.data.players,
                    isLoading: false
                });
            })
    }

    displayPlayers() {
        if (this.state.isLoading) {
            return <p>Loading...</p>
        } else {
            return this.state.players.data.map((player, index) => {
                return <PlayerCard player={player} key={index}/>
            })
        }
    }

    displayPagination() {
        if (!this.state.isLoading) {
            return <Pagination items={this.state.players}/>
        }
    }

    render() {
        return (
            <div className="row justify-content-center">
                {this.displayPlayers()}
                {/*{this.displayPagination()}*/}
            </div>
        );
    }
}

export default Players;
