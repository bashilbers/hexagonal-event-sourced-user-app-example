'use strict';

var React = require('react/addons');

require('styles/Signup.sass');

var Signup = React.createClass({
  getInitialState: function () {
    return {
        user: '',
        password: '',
        extra: ''
    }
  },

  mixins: [React.addons.LinkedStateMixin],

  render: function () {
    return (
        <div className="login jumbotron center-block">
            <h1>Signup</h1>
            <form role="form">
                <div className="form-group">
                    <label htmlFor="username">Username</label>
                    <input type="text" valueLink={this.linkState('user')} className="form-control" id="username" placeholder="Username" />
                </div>
                <div className="form-group">
                    <label htmlFor="password">Password</label>
                    <input type="password" valueLink={this.linkState('password')} className="form-control" id="password" ref="password" placeholder="Password" />
                </div>
                <div className="form-group">
                    <label htmlFor="extra">Extra</label>
                    <input type="text" valueLink={this.linkState('extra')} className="form-control" id="password" ref="password" placeholder="Some extra information" />
                </div>
                <button type="submit" className="btn btn-default" onClick={this.signup.bind(this)}>Submit</button>
            </form>
        </div>
      );
  }
});

module.exports = Signup;
