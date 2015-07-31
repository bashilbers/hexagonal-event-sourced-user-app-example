import {LOGIN_USER, LOGOUT_USER} from '../constants/LoginConstants';

class LoginStore {
    get user() {
        return this._user;
    }

    get token() {
        return this._jwt;
    }

    isLoggedIn() {
        return !!this._user;
    }
}

export default new LoginStore();