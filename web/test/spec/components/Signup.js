'use strict';

// Uncomment the following lines to use the react test utilities
// import React from 'react/addons';
// const TestUtils = React.addons.TestUtils;

import createComponent from 'helpers/createComponent';
import Signup from 'components/Signup.js';

describe('Signup', () => {
    let SignupComponent;

    beforeEach(() => {
        SignupComponent = createComponent(Signup);
    });

    it('should have its component name as default className', () => {
        expect(SignupComponent._store.props.className).toBe('Signup');
    });
});
