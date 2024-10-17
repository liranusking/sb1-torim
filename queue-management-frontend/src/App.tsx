import React from 'react';
import { BrowserRouter as Router, Route, Switch, Link } from 'react-router-dom';
import ServiceList from './components/ServiceList';
import AppointmentList from './components/AppointmentList';
import WaitingList from './components/WaitingList';
import Dashboard from './components/Dashboard';

const App: React.FC = () => {
  return (
    <Router>
      <div className="App">
        <nav>
          <ul>
            <li><Link to="/">Dashboard</Link></li>
            <li><Link to="/services">Services</Link></li>
            <li><Link to="/appointments">Appointments</Link></li>
            <li><Link to="/waiting-list">Waiting List</Link></li>
          </ul>
        </nav>

        <Switch>
          <Route exact path="/" component={Dashboard} />
          <Route path="/services" component={ServiceList} />
          <Route path="/appointments" component={AppointmentList} />
          <Route path="/waiting-list" component={WaitingList} />
        </Switch>
      </div>
    </Router>
  );
};

export default App;