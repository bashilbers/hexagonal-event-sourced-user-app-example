'use strict';

var React = require('react/addons');


require('styles/Home.sass');

var Home = React.createClass({

  render: function () {
    return (
        <div className="Home">
          <p>Content for Home</p>
        </div>
      );
  }
});

module.exports = Home;
