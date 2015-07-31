'use strict';

describe('WebApp', () => {
  let React = require('react/addons');
  let WebApp, component;

  beforeEach(() => {
    let container = document.createElement('div');
    container.id = 'content';
    document.body.appendChild(container);

    WebApp = require('components/WebApp.js');
    component = React.createElement(WebApp);
  });

  it('should create a new instance of WebApp', () => {
    expect(component).toBeDefined();
  });
});
