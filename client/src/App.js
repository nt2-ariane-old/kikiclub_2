import React, { Component } from 'react';
import { ErrorPage, WorkshopModal, Login, RobotModal, Modal, Admin, Invitation, Robots, ProfilInfos, Header, Footer, Accueil, Members, Workshops } from './Components'
import { Route, Switch } from 'react-router-dom';
import $ from 'jquery'
import apis from './api/api';
import { withCookies, Cookies } from 'react-cookie';
import { instanceOf } from 'prop-types';

class App extends Component {
  static propTypes = {
    cookies: instanceOf(Cookies).isRequired
  };
  constructor(props) {
    super(props)
    const { cookies } = props;
    this.state = {
      modal_content: null,
      user: cookies.get('user') || null,
      members: null,
      avatars: null,
      curMember: null,
    }
  }
  openModal = (type, params) => {
    let content = null
    if (type === 'workshop') {
      content = <WorkshopModal infos={params} />
    }
    else if (type === 'robot') {
      content = <RobotModal infos={params} />
    }
    if (content === null) {
      $(".App-body").off("touchmove");
      $("body").css({ "position": "static", "overflow": "auto" });
    }
    else {
      $(".App-body").on("touchmove", function (event) {
        event.preventDefault()
      });
      $("body").css({ "position": "sticky", "overflow": "hidden" });
    }

    this.setState({ modal_content: content })

  }
  componentDidMount = () => {
    const token = this.getUrlParam("user_t");
    const { cookies } = this.props;
    if (token !== null) {
      apis.getUserByToken(token).then((res) => {
        const user = res.data.user;
        cookies.set('user', user, { path: '/' });
        this.setState({ user });
      })
    }
    const logout = this.getUrlParam("logout");
    if (logout !== null) {
      cookies.set('user', null, { path: '/' });
      this.setState({ user: null })
    }
    apis.getAllAvatars().then((res) => {
      this.setState({ avatars: res.data })
    })
    if (cookies.get('id_member')) {
      apis.getMemberById(cookies.get('id_member')).then((res) => {
        this.setState({ curMember: res.data[0] })
      })
    }
    this.loadMembers()
  }
  componentDidUpdate = (prevProps, prevStates) => {
    if (prevStates.user !== this.state.user) {
      this.loadMembers()
    }
  }
  loadMembers = () => {
    if (this.state.user) {
      apis.getMemberByUserId(this.state.user.id).then((res) => {
        const members = res.data
        this.setState({ members })
      })
    }
  }
  getUrlParam = (field) => {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    return urlParams.get(field)
  }
  closeModal = () => {
    $(".App-body").off("touchmove");
    $("body").css({ "position": "static", "overflow": "auto" });


    this.setState({ modal_content: null })
  }
  setCurMember = (id_member, callback = null) => {
    const { cookies } = this.props;
    cookies.set('id_member', id_member, { path: '/' });
    apis.getMemberById(id_member).then((res) => {
      this.setState({ curMember: res.data[0] })
    })
    if (callback) callback()
  }
  render() {
    const { modal_content, user, members, avatars, curMember, admin_mode } = this.state
    return (
      <div className="App">
        <Header user={user} members={members} curMember={curMember} admin_mode={admin_mode} />

        <main className="App-body">
          <Switch>
            <Route path='/' exact component={Accueil} />
            <Route path='/members' exact component={() => <Members members={members} avatars={avatars} setCurMember={this.setCurMember} />} />
            <Route path='/workshops' exact component={() => <Workshops setModal={this.openModal} />} />
            <Route path='/administration' exact component={() => <Admin user={user} />} />

            <Route path='/profil' exact component={() => <ProfilInfos curMember={curMember} setCurMember={this.setCurMember} />} />
            <Route path='/robots' exact component={() => <Robots setModal={this.openModal} />} />
            <Route path='/reference' exact component={Invitation} />
            <Route path='/login' exact component={Login} />
            <Route path="*" component={ErrorPage} />
          </Switch>

        </main>

        {modal_content != null &&
          <Modal closeModal={this.closeModal}>
            {modal_content}
          </Modal>
        }

        <Footer />
      </div>
    );
  }
}
export default withCookies(App);
