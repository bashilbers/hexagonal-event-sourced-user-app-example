'use strict';

var React = require('react/addons');

require('styles/Login.sass');

var Login = React.createClass({
    mixins: [React.addons.LinkedStateMixin],

    getInitialState: function() {
        return {
            user: '',
            password: ''
        };
    },

    login(e) {
        e.preventDefault();
        Auth.login(this.state.user, this.state.password)
            .catch(function() {
                // something happening
            });
    },

    render: function () {
        return (
            <div>
                <form role="form">
                    <div className="form-group">
                    <input type="text" valueLink={this.linkState('user')}placeholder="Username" />
                <input type="password" valueLink={this.linkState('password')} placeholder="Password" />
                </div>
                <button type="submit" onClick={this.login.bind(this)}>Submit</button>
                </form>
            </div>
        );
    }
});

module.exports = Login;
