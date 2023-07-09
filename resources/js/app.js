import React from 'react';
import ReactDOM from 'react-dom';
import { createRoot } from 'react-dom/client';

const App = () => {
    return (
        <h1>
            Hello World!
        </h1>
    )
}
const container = document.getElementById('app');
const root = createRoot(container);
root.render(<App />);


