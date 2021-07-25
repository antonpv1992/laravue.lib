import {createStore} from "vuex";
import {bookModule as book}  from "./bookModule";
import {userModule as user}  from "./userModule";

export default createStore({
    state: {
      isAuth: localStorage.getItem('token') ? true : false,
      isAdmin: JSON.parse(localStorage.getItem('role')) || false,
      token: localStorage.getItem('token') || '',
      verify: JSON.parse(localStorage.getItem('verify')) || false,
      userId: localStorage.getItem('uid') || 0,
      userName: localStorage.getItem('uname') || false
    },
    modules: {
      book, user
    }
})
