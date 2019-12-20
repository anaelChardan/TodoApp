require('../css/app.css');

import React from 'react';
import ReactDom from 'react-dom';

const App = () => {
  return (
    <div>
      Coucou Biloute!
    </div>
  );
};

ReactDom.render(<App />, document.getElementById('root'));


