'use strict';

var WebApp = require('./WebApp');
var React = require('react');
var Router = require('react-router');
var RouterContainer = require('./../services/RouterContainer');
var LoginActions = require('./../actions/LoginActionCreators');
var Route = Router.Route;
var Login = require('./Login');
var Signup = require('./Signup');
var Home = require('./Home');

var routes = (
  <Route handler={WebApp}>
    <Route name="login" handler={Login}/>
    <Route name="signup" handler={Signup}/>
    <Route name="home" path="/" handler={Home}/>
  </Route>
);

var router = Router.create({routes});
RouterContainer.set(router);

let jwt = localStorage.getItem('jwt');
if (jwt) {
    LoginActions.loginUser(jwt);
}

Router.run(routes, function (Handler) {
  React.render(<Handler/>, document.getElementById('content'));
});
