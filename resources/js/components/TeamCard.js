import React, {Component} from 'react';

class TeamCard extends Component {
    constructor(props) {
        super(props);
    }

    displayTeamMembers() {
        let team = this.props.team;
        return <ul>
            {
                this.props.team.players.map((player, index) => {
                    return <li key={index}>{player.name}</li>
                })
            }
        </ul>
    }


    render() {
        return (
            <div className="col-md-8 mb-2">
                <div className="card">

                    <div className="card-header d-flex justify-content-between">
                        <h4>
                            {this.props.team.name}
                        </h4>
                        <h5>
                            {/*<form action=""*/}
                            {/*      style="display: none;"*/}
                            {/*      method="post" id="delete-player">*/}
                            {/*</form>*/}
                            <button className="btn btn-danger btn-sm">Delete
                            </button>
                            <a href="" className="btn btn-sm">
                                Edit
                            </a>
                        </h5>
                    </div>


                    <div className="card-body">
                        <ul className="">
                            {this.displayTeamMembers()}
                        </ul>

                    </div>
                </div>
            </div>
        );
    }
}

export default TeamCard;
