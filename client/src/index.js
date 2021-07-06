import React from 'react';
import ReactDOM from 'react-dom';
import './style';
import App from './App';
import * as serviceWorker from './serviceWorker';

import { CookiesProvider } from 'react-cookie';
import { BrowserRouter } from 'react-router-dom'

ReactDOM.render(
  <React.StrictMode>
    <CookiesProvider>
      <BrowserRouter>
        <App />
      </BrowserRouter>
    </CookiesProvider>
  </React.StrictMode>,
  document.getElementById('root')
);

serviceWorker.register();
