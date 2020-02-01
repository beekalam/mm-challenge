import React, {Component} from 'react';
import {BrowserRouter, Link} from "react-router-dom";

class Nav extends Component {
    render() {
        return (
            <div>
                <nav className="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                    <div className="container">
                        <a className="navbar-brand" href="">
                            Laravel
                        </a>

                        <button className="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent"
                                aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="">
                            <span className="navbar-toggler-icon"></span>
                        </button>

                        <div className="collapse navbar-collapse" id="navbarSupportedContent">

                            <ul className="navbar-nav mr-auto">
                                <li className="nav-item">
                                    <span className="nav-link">
                                        <Link to="/react/teams">Teams</Link>
                                    </span>
                                </li>
                                <li className="nav-item">
                                   <span className="nav-link">
                                        <Link to="/react/players">Players</Link>
                                    </span>
                                </li>
                                <li className="nav-item">
                                    <a className="nav-link" href="">Create Team</a>
                                </li>
                                <li className="nav-item">
                                    <a className="nav-link" href="">Create Player</a>
                                </li>
                            </ul>

                            <ul className="navbar-nav ml-auto">
                                <li className="nav-item">
                                    <a className="nav-link" href="">Login</a>
                                </li>
                                <li className="nav-item">
                                    <a className="nav-link" href="">Register</a>
                                </li>
                                <li className="nav-item dropdown">
                                    {/*<a id="navbarDropdown" className="nav-link dropdown-toggle" href="#" role="button"*/}
                                    {/*   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">*/}
                                    {/*    /!*<span className="caret"></span>*!/*/}
                                    {/*</a>*/}

                                    {/*<div className="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">*/}
                                    {/*    <a className="dropdown-item" href="">*/}
                                    {/*    </a>*/}

                                    {/*    <form id="logout-form" method="POST" style="display: none;">*/}
                                    {/*    </form>*/}
                                    {/*</div>*/}

                                </li>
                            </ul>

                        </div>
                    </div>
                </nav>

            </div>
        );
    }
}

export default Nav;
