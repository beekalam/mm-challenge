import React, {Component} from 'react';
import {Link} from "react-router-dom";

class Pagination extends Component {
    constructor(props) {
        super(props);
        console.log(this.props.items);
        console.log(this.props.items.lastPage);
    }

    showPrevious() {
        if (this.props.items.prevPageUrl) {
            console.log('in showprevious');
            return <li className="page-item disabled" aria-disabled="true">
                <span className="page-link" aria-hidden="true">&lsaquo;</span>
            </li>
        } else {
            return <li className="page-item">
                <a className="page-link" href="" rel="prev"
                   aria-label="">&lsaquo;</a>
            </li>
        }
    }

    showNext() {
        if (this.props.items.nextPageUrl) {
            return <li className="page-item">
                {/*<a className="page-link" href="" rel=" next">&rsaquo;</a>*/}
                <Link className="page-link" to={`/react/teams/${this.props.items.currentPage+1}`}>&rsaquo;</Link>
            </li>
        } else {
            return <li className=" page-item disabled" aria-disabled=" true">
                <span className=" page-link" aria-hidden=" true">&rsaquo;</span>
            </li>
        }

    }

    render() {
        return (
            <div>
                <ul className="pagination" role="navigation">
                    {this.showPrevious()}


                    {/*<li className="page-item disabled" aria-disabled="true"><span className="page-link"></span></li>*/}

                    <li className="page-item active" aria-current="page">
                        <span className="page-link">{this.props.items.currentPage}</span>
                    </li>
                    {/*<li className="page-item"><a className="page-link" href=""></a></li>*/}

                    {this.showNext()}
                </ul>
            </div>
        );
    }
}

export default Pagination;
