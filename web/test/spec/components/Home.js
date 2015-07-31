'use strict';

// Uncomment the following lines to use the react test utilities
// import React from 'react/addons';
// const TestUtils = React.addons.TestUtils;

import createComponent from 'helpers/createComponent';
import Home from 'components/Home.js';

describe('Home', () => {
    let HomeComponent;

    beforeEach(() => {
        HomeComponent = createComponent(Home);
    });

    it('should have its component name as default className', () => {
        expect(HomeComponent._store.props.className).toBe('Home');
    });
});
